<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/reset.css?v=2025-11-10-01">
    <link rel="stylesheet" href="./css/login.css?v=2025-11-10-01">
    <script src="login.js?v=2025-11-10-01" defer></script>
</head>
<body>

    <div id="container" class="container">
        <div id="form-container" class="container">
            <form action="/includes/login.inc.php" method="POST">
                <fieldset class="fieldset-header">
                    <legend><h2>Login</h2></legend>
                </fieldset>
                <fieldset class="fieldset">
                    <label for="email">E-Mail Address</label>
                    <input type="text" name="email" class="text-input" id="email" placeholder="Email" required>
                </fieldset>
                <fieldset class="fieldset" id="password-container">
                    <label for="password">Password
                        <a href="#" class="float-right">Forgot Password?</a>
                    </label>
                    <input type="password" name="password" id="password" class="text-input" placeholder="Password" required>
                </fieldset>
                <fieldset id="remember-container">
                    <input type="checkbox" name="remember">
                    <label for="remember">Remember Me</label>
                </fieldset>
            </form>
        </div>
    </div>

</body>
</html>