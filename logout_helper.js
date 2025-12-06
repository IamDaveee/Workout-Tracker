import { account } from './appwrite.js';

async function logoutAll() {
  try {
    // Ask Appwrite to delete the current session (requires Appwrite CORS to allow your origin)
    await account.deleteSession('current');
    console.log('Appwrite session deleted (if CORS allowed it).');
  } catch (err) {
    console.warn('Could not delete Appwrite session (continuing):', err);
  }

  // Now call your PHP logout to clear local session and cookies
  window.location.href = '/includes/logout.inc.php';
}

// Example: connect to a button
document.getElementById("logout-btn").addEventListener("click", function(e){
    e.preventDefault();
  (async () => {
    // First try to delete the Appwrite session so the Appwrite cookie
    // is removed. This requires Appwrite CORS to allow your origin.
    try {
      await account.deleteSession('current');
      console.log('Appwrite session deleted (if CORS allowed it).');
    } catch (err) {
      console.warn('Could not delete Appwrite session (continuing):', err);
    }

    // Now call server-side logout to clear local PHP session and cookies.
    // Use a normal navigation so the user ends up on the post-logout page.
    window.location.href = '/includes/logout.inc.php';
  })();
});