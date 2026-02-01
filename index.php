<?php
    require_once './includes/config_session.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Tracker</title>
    <link rel="stylesheet" href="./css/reset.css?v=2025-11-09-01">
    <link rel="stylesheet" href="./css/style.css?v=2025-11-09-01">
    <script src="app.js?v=2025-11-04-01" defer></script>
    <script type="module" src="logout_helper.js?v=2025-12-12-01"></script>
</head>
<body>
    
    <header>
        <div class="container" id="header-container">
            <h1>Workout Tracker</h1>

            <?php
            
                if (!isset($_SESSION["user_username"])) { ?>
                    <a href="login.php"><svg id="pp" xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/></svg></a>
            <?php }
                else { ?>
                    <button type="button" id="pp-toggle" class="pp-toggle-btn">
                    <svg id="pp" xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/></svg>
                </button>
                <!-- HIDDEN USER INFO PANEL -->
                <div id="user-menu" class="user-menu">
                    <p class="user-menu-title">
                        Bejelentkezve mint<br>
                        <strong><?php echo htmlspecialchars($_SESSION["user_username"]); ?></strong>
                    </p>

                    <form action="/includes/update_user.inc.php" method="POST" class="user-menu-form">
                        <label for="um-username">Felhasználónév</label>
                        
                        <div class="flex-row">
                            <input disabled type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION["user_username"]); ?>">
                            <button type="button" class="btn-change" aria-label="Change Username" data-target="username" target="username">
                                <svg xmlns="http://www.w3.org/2000/svg" height="14" width="14" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M100.4 417.2C104.5 402.6 112.2 389.3 123 378.5L304.2 197.3L338.1 163.4C354.7 180 389.4 214.7 442.1 267.4L476 301.3L442.1 335.2L260.9 516.4C250.2 527.1 236.8 534.9 222.2 539L94.4 574.6C86.1 576.9 77.1 574.6 71 568.4C64.9 562.2 62.6 553.3 64.9 545L100.4 417.2zM156 413.5C151.6 418.2 148.4 423.9 146.7 430.1L122.6 517L209.5 492.9C215.9 491.1 221.7 487.8 226.5 483.2L155.9 413.5zM510 267.4C493.4 250.8 458.7 216.1 406 163.4L372 129.5C398.5 103 413.4 88.1 416.9 84.6C430.4 71 448.8 63.4 468 63.4C487.2 63.4 505.6 71 519.1 84.6L554.8 120.3C568.4 133.9 576 152.3 576 171.4C576 190.5 568.4 209 554.8 222.5C551.3 226 536.4 240.9 509.9 267.4z"/></svg>
                            </button>
                        </div>
                        

                        <label for="um-email">E-mail</label>
                        <div class="flex-row">
                            <input disabled type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION["user_email"] ?? ''); ?>">
                            <button type="button" class="btn-change" aria-label="Change Email" data-target="email" target="email">
                                <svg xmlns="http://www.w3.org/2000/svg" height="14" width="14" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M100.4 417.2C104.5 402.6 112.2 389.3 123 378.5L304.2 197.3L338.1 163.4C354.7 180 389.4 214.7 442.1 267.4L476 301.3L442.1 335.2L260.9 516.4C250.2 527.1 236.8 534.9 222.2 539L94.4 574.6C86.1 576.9 77.1 574.6 71 568.4C64.9 562.2 62.6 553.3 64.9 545L100.4 417.2zM156 413.5C151.6 418.2 148.4 423.9 146.7 430.1L122.6 517L209.5 492.9C215.9 491.1 221.7 487.8 226.5 483.2L155.9 413.5zM510 267.4C493.4 250.8 458.7 216.1 406 163.4L372 129.5C398.5 103 413.4 88.1 416.9 84.6C430.4 71 448.8 63.4 468 63.4C487.2 63.4 505.6 71 519.1 84.6L554.8 120.3C568.4 133.9 576 152.3 576 171.4C576 190.5 568.4 209 554.8 222.5C551.3 226 536.4 240.9 509.9 267.4z"/></svg>
                            </button>
                        </div>


                        <!-- ide még jöhet bármi: display_name, stb. -->

                        <button type="submit" class="user-menu-save">Adatok módosítása</button>
                    </form>

                    <a id="logout-btn" href="#" class="user-menu-logout">Kijelentkezés</a>
                </div>
                <?php }?>

            

            
            <div id="nav-container" class="container"></div>
                <nav>
                    <div class="items">
                        <p><a href="#" class="active">Log</a></p>
                        <p><a href="#">Calendar</a></p>
                        <p><a href="#">Query</a></p>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div class="container" id="login-status">
        <?php
            if (isset($_SESSION["user_username"])) {
                echo "<p>Welcome back, " . $_SESSION["user_username"] . "!</p>";
            } else {
                echo "<p>Please <a href='login.php' id='login-link'>log in</a> to access all features.</p>";
            }
        ?>
    </div>
    

    <section id="log" class="section">
        <div class="container" id="log-container">
            <h2 class="h2">Log Your Workout</h2>

            <form action="includes/formhandler.php" method="POST" name="workout">
                <div class="left" id="left">
                    <fieldset class="base-data">
                        <label for="date">Workout Date</label>
                        <input required type="date" name="date" id="date" class="input">
                    </fieldset>
                    <fieldset class="base-data">
                        <label for="start_time">Start Time (optional)</label>
                        <input type="time" name="start_time" id="start_time" class="input">
                    </fieldset>
                    <fieldset class="base-data">
                        <label for="end_time">End Time (optional)</label>
                        <input type="time" name="end_time" id="end_time" class="input">
                    </fieldset>
                    <fieldset class="base-data">
                        <label for="preset">Preset</label>
                        <select name="preset" id="preset">
                            <?php
                                $count=$_SESSION["numberOfPresets"];
                                if ($count>0) {
                                    for ($i=1; $i <= $count; $i++) { 
                                        echo '<option value="'. $_SESSION["exercise$i-name"] .'">'. $_SESSION["exercise$i-name"] .'</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled selected>No Presets Found</option>';
                                }
                            ?>
                            
                        </select>
                    </fieldset>
                    <fieldset class="base-data">
                        <label for="type">Workout Type</label>
                        <select name="type" id="type" label="Workout-Type">
                            <option value="Chest">Chest</option>
                            <option value="Back">Back</option>
                            <option value="Leg">Leg</option>
                        </select>
                    </fieldset>
                    <fieldset class="base-data">
                        <label for="number">Number of Exercises</label>
                        <input type="number" name="number" id="number" class="num-input" min="1">
                    </fieldset>
                </div>
                <legend><h3>Exercises</h3></legend>
                <div class="right" id="right">
                    <fieldset class="exercisesContainer">
                        
                    </fieldset>
                </div>

                <div id="submit-container" class="container">
                    <button type="submit" id="submit"><span id="log-span">Lo</span>g Work<span id="workout-span">out</span></button>
                </div>

            </form>
        </div>
    </section>
        
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('pp-toggle');
            const userMenu = document.getElementById('user-menu');

            if (toggleBtn && userMenu) {
                toggleBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    userMenu.classList.toggle('open');
                });

                // kattintás máshova → panel bezár
                document.addEventListener('click', function (e) {
                    if (!userMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
                        userMenu.classList.remove('open');
                    }
                });
            }
        });

        document.querySelectorAll('.btn-change').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.target;
            const input = document.getElementById(targetId);
            if (!input) return;
            input.removeAttribute("disabled")
        });
    });
    </script>

</body>
</html>