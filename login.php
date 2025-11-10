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
                <fieldset>
                    <legend><h2>Login</h2></legend>
                </fieldset>
                <fieldset>
                    <label for="email">E-Mail Address</label>
                    <input type="text" name="email" class="text-input" id="email" placeholder="email" required>
                </fieldset>
                <fieldset>
                <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="text-input" placeholder="Password" required>
                </fieldset>
            </form>
        </div>
    </div>

</body>
</html>