<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/reset.css?v=2025-11-10-01">
    <link rel="stylesheet" href="./css/register.css?v=2025-11-10-01">
    <script type="module" src="./register.js?v=2025-11-10-01"></script>
</head>
<body>
    
    <div id="container" class="container">
        <div id="form-container" class="container">
            <form action="./includes/register.inc.php" method="POST">
                <fieldset class="fieldset-header">
                    <legend><h2>Register</h2></legend>
                </fieldset>

                <fieldset class="fieldset">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <span class="input-icon" aria-hidden="true">
                            <!-- user icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <input type="text" name="username" id="username" class="text-input" placeholder="Choose a username" required aria-describedby="username-error">
                    </div>
                    <div class="error-message" id="username-error"></div>
                </fieldset>

                <fieldset class="fieldset">
                    <label for="email">E-Mail Address</label>
                    <div class="input-group">
                        <span class="input-icon" aria-hidden="true">
                            <!-- envelope icon -->
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 7.5L12 13L21 7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <input type="email" name="email" id="email" class="text-input" placeholder="you@example.com" required aria-describedby="email-error">
                    </div>
                    <div class="error-message" id="email-error"></div>
                </fieldset>

                <fieldset class="fieldset" id="password-container">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <span class="input-icon" aria-hidden="true">
                            <!-- lock icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="11" width="18" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 11V8a5 5 0 0110 0v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <input type="password" name="password" id="password" class="text-input" placeholder="Create a password" required aria-describedby="password-error">
                        <button type="button" class="toggle-password" aria-label="Show password" data-target="password">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.3"/></svg>
                        </button>
                    </div>
                    <div class="error-message" id="password-error"></div>
                </fieldset>

                <fieldset class="fieldset">
                    <label for="password-repeat">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-icon" aria-hidden="true">
                            <!-- lock icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="11" width="18" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 11V8a5 5 0 0110 0v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <input type="password" name="passwordRepeat" id="password-repeat" class="text-input" placeholder="Repeat password" required aria-describedby="password-repeat-error">
                        <button type="button" class="toggle-password" aria-label="Show password" data-target="password-repeat">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.3"/></svg>
                        </button>
                    </div>
                    <div class="error-message" id="password-repeat-error"></div>
                </fieldset>

                <fieldset id="remember-container">
                    <label for="terms"><input type="checkbox" name="terms" id="terms" required> I agree to the Terms</label>
                </fieldset>

                <fieldset>
                    <button type="submit" class="btn" id="submit-btn">Create Account</button>
                </fieldset>

                <fieldset>
                    <button id="login-google" class="btn" type="button" aria-label="Sign in with Google">
                        <span class="btn-icon" aria-hidden="true">
                            <!-- Refined Google G logo (balanced, multi-path) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 46" focusable="false" aria-hidden="true">
                                <path fill="#4285F4" d="M23 10.5c2.8 0 5 1 6.7 2.6l4.9-4.9C31.7 5 27.7 3.5 23 3.5 14.9 3.5 8.2 8.8 5.5 16.2l5.7 4.4C12.5 13.6 17.3 10.5 23 10.5z"/>
                                <path fill="#34A853" d="M42.5 23c0-1.6-.1-3.2-.4-4.7H23v9h11.6c-.5 2.8-2.1 5.2-4.6 6.8l4 3.1C39.9 36.7 42.5 30.4 42.5 23z"/>
                                <path fill="#FBBC05" d="M10.6 27.8A13.9 13.9 0 0110 23c0-1.4.2-2.7.6-4l-5.7-4.4C2 16.7 1.5 19.8 1.5 23s.5 6.3 1.6 9.6l7.5-4.8z"/>
                                <path fill="#EA4335" d="M23 42.5c4.7 0 8.7-1.6 11.6-4.2l-4-3.1c-2 1.3-4.5 2-7.6 2-5.7 0-10.5-3.1-12.2-7.6l-7.5 4.8C8.2 40.2 14.9 45.5 23 45.5z"/>
                            </svg>
                        </span>
                        <span class="btn-text">Login With Google</span>
                    </button>
                </fieldset>

                <fieldset id="register">
                    <a id="register-link" href="login.php">Already have an account? Log in</a>
                </fieldset>
            </form>
        </div>
    </div>

</body>
</html>