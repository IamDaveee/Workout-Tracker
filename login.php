<?php
    require_once 'includes/login_view.inc.php';
    require_once 'includes/config_session.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/reset.css?v=2025-11-10-01">
    <link rel="stylesheet" href="./css/login.css?v=2025-11-10-01">
    <script type="module" src="login.js?v=2025-11-10-01"></script>
    <script type="module" src="logout_helper.js?v=2025-12-02-01"></script>
</head>
<body>

    <?php
        if (!isset($_SESSION["user_username"])) { ?>
            <div id="container" class="container">
            <div id="form-container" class="container">
                <form action="/includes/login.inc.php" method="POST">
                    <fieldset class="fieldset-header">
                        <legend><h2>Login</h2></legend>
                    </fieldset>
                    <fieldset class="fieldset">
                        <label for="email">E-Mail Address</label>
                        <div class="input-group">
                            <span class="input-icon" aria-hidden="true">
                                <!-- envelope icon -->
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M3 7.5L12 13L21 7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input type="text" name="email" class="text-input" id="email" placeholder="Email" required aria-describedby="email-error">
                        </div>
                        <div class="error-message" id="email-error"></div>
                    </fieldset>
                    <fieldset class="fieldset" id="password-container">
                        <label for="password">Password
                            <a href="#" class="float-right">Forgot Password?</a>
                        </label>
                        <div class="input-group">
                            <span class="input-icon" aria-hidden="true">
                                <!-- lock icon -->
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 11V8a5 5 0 0110 0v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input type="password" name="password" id="password" class="text-input" placeholder="Password" required aria-describedby="password-error">
                            <button type="button" class="toggle-password" aria-label="Show password" data-target="password">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.3"/></svg>
                            </button>
                        </div>
                        <div class="error-message" id="password-error"></div>
                    </fieldset>
                    <fieldset id="remember-container">
                        <label for="remember"><input type="checkbox" name="remember" id="remember"> Remember Me</label>
                    </fieldset>

                    <fieldset>
                        <button type="submit" class="btn" id="submit-btn">Login</button>
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
                        <a id="register-link" href="register.php">Don't have an account?</a>
                    </fieldset>

                    <fieldset>
                        <?php
                            check_login_errors();
                        ?>
                    </fieldset>
                </form>
                
            </div>
        </div>
        <?php } 
        else { ?>
            <div id="container" class="container">
                <div id="logged-in-message" class="container">
                    <h2>You are already logged in as <?php echo htmlspecialchars($_SESSION["user_username"]); ?>.</h2>
                    <a href="index.php">Go to Homepage</a>
                </div>
            </div>

            <button id="logout-btn">Logout</button>
       <?php } ?>        
</body>
</html>