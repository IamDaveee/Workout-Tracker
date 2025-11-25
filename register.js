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
    account.createOAuth2Session(
      "google",
      "http://localhost",
      "http://localhost/fail.php"
    );
};
