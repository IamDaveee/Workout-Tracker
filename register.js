import { account } from "./appwrite.js";


const form = document.querySelector('form');

function showError(id, message) {
    const el = document.getElementById(id);
    if (el) el.textContent = message || '';
}

function clearError(id) { showError(id, ''); }

// Toggle password visibility for any toggle buttons
document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.dataset.target;
        const input = document.getElementById(targetId);
        if (!input) return;
        const isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';
        btn.setAttribute('aria-label', isPwd ? 'Hide password' : 'Show password');
    });
});

function validEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function strongPassword(pw){
    // Minimum 8 chars, at least one letter and one number
    return /(?=.{8,})(?=.*[A-Za-z])(?=.*\d)/.test(pw);
}

if (form) {
    form.addEventListener('submit', (e) => {
        let ok = true;
        const username = document.getElementById('username');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const passwordRepeat = document.getElementById('password-repeat');
        const terms = document.getElementById('terms');

        clearError('username-error');
        clearError('email-error');
        clearError('password-error');
        clearError('password-repeat-error');

        if (!username || username.value.trim().length < 3) {
            showError('username-error', 'Username must be at least 3 characters.');
            ok = false;
        }

        if (!email || !validEmail(email.value.trim())) {
            showError('email-error', 'Please enter a valid email address.');
            ok = false;
        }

        if (!password || !strongPassword(password.value)) {
            showError('password-error', 'Password must be at least 8 characters and include letters and numbers.');
            ok = false;
        }

        if (!passwordRepeat || password.value !== passwordRepeat.value) {
            showError('password-repeat-error', 'Passwords do not match.');
            ok = false;
        }

        if (!terms || !terms.checked) {
            showError('password-repeat-error', 'You must accept the terms to continue.');
            ok = false;
        }

        if (!ok) e.preventDefault();
    });

    // Clear error on input
    ['username','email','password','password-repeat'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', () => { clearError(id + '-error'); });
    })
}

// ========== Google login ==========
document.getElementById("login-google").onclick = () => {
  // Try to clear any existing Appwrite session first so the account chooser
  // is shown and the selected Google account is used. If clearing the
  // session fails (CORS or other), still start the OAuth flow but log a
  // warning.
  (async () => {
    try {
      // attempt to delete current session; Appwrite requires CORS to allow this
      await account.deleteSession('current');
      console.log('Cleared existing Appwrite session before OAuth.');
    } catch (err) {
      console.warn('Could not clear Appwrite session before OAuth (continuing):', err);
    }

    account.createOAuth2Session(
      "google",
      "http://localhost/register.php?oauth_google=1",
      "http://localhost/fail.php"
    );
  })();
};

async function handleGoogleOAuthCallback() {
  const params = new URLSearchParams(window.location.search);
  if (!params.get("oauth_google")) return; // not coming from Google

  // Step 1: get Appwrite user
  let user;
  try {
    user = await account.get();
    console.log("Appwrite user:", user);
  } catch (err) {
    console.error("account.get() failed:", err);
    alert("Could not complete login (could not get Appwrite user).");
    return;
  }

  // Step 2: send to PHP backend
  try {
    const response = await fetch("./oauth_login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        provider: "google",
        appwrite_id: user.$id,
        email: user.email,
        name: user.name,
      }),
      credentials: "include",
    });

    if (!response.ok) {
      console.error("PHP returned HTTP error:", response.status);
      // Try to get response text for debugging
      const text = await response.text();
      console.error("Server response body:", text);
      alert("Could not complete login (server returned an error). Check console for details.");
      return;
    }

    let data;
    try {
      data = await response.json();
    } catch (jsonErr) {
      const text = await response.text();
      console.error("Invalid JSON from server:", text);
      alert("Server returned invalid JSON. Check console for details.");
      return;
    }

    console.log("PHP response:", data);

    if (data.success) {
      window.location.href = "./index.php"; // redirect to dashboard
    } else {
      // If the server included debug_output, log it for visibility
      if (data.debug_output) console.error("Server debug output:", data.debug_output);
      alert(
        "Could not complete login (backend error): " +
          (data.error || "Unknown error")
      );
    }
  } catch (err) {
    console.error("Error calling oauth_login.php:", err);
    alert("Could not complete login (network or JSON error).");
  }
}

handleGoogleOAuthCallback();
