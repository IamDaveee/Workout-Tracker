// login.js
import { account } from "./appwrite.js";

// ========== Helpers ==========
function showError(id, message) {
    const el = document.getElementById(id);
    if (el) el.textContent = message || "";
}

function clearError(id) {
    showError(id, "");
}

function validEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// ========== Form validation ==========
const form = document.querySelector("form");
if (form) {
    form.addEventListener("submit", (e) => {
        let ok = true;
        const email = document.getElementById("email");
        const password = document.getElementById("password");

        clearError("email-error");
        clearError("password-error");

        if (!email || !validEmail(email.value.trim())) {
            showError("email-error", "Please enter a valid email address.");
            ok = false;
        }

        if (!password || password.value.trim().length < 1) {
            showError("password-error", "Please enter your password.");
            ok = false;
        }

        if (!ok) {
            console.log("Form validation failed");
            e.preventDefault();
        }
    });

    ["email", "password"].forEach((id) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener("input", () => clearError(id + "-error"));
    });
} else {
    console.warn("No <form> found on page");
}

// ========== Google login ==========
document.getElementById("login-google").onclick = () => {
    account.createOAuth2Session(
      "google",
      "http://localhost",
      "http://localhost/fail.php"
    );
};
