<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Tracker</title>
    <link rel="stylesheet" href="./css/reset.css?v=2025-11-09-01">
    <link rel="stylesheet" href="./css/style.css?v=2025-11-09-01">
    <script src="app.js?v=2025-11-04-01" defer></script>
</head>
<body>
    
    <header>
        <div class="container" id="header-container">
            <h1>Workout Tracker</h1>
            <a href="login.php"><svg id="pp" xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/></svg></a>
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

    <section id="log" class="section">
        <div class="container" id="log-container">
            <h2 class="h2">Log Your Workout</h2>

            <form action="includes/formhandler.php" method="POST" name="workout">
                <div class="left" id="left">
                    <fieldset class="base-data">
                        <legend><h3>Workout Date</h3></legend>
                        <input required type="date" name="date" id="date" class="input">
                    </fieldset>
                    <fieldset class="base-data">
                        <legend><h3>Workout Type</h3></legend>
                        <select name="type" id="type" label="Workout-Type">
                            <option value="Chest">Chest</option>
                            <option value="Back">Back</option>
                            <option value="Leg">Leg</option>
                        </select>
                    </fieldset>
                    <fieldset class="base-data">
                        <legend><h3>Number of Exercises</h3></legend>
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

</body>
</html>