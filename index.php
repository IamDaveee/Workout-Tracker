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
            <svg id="pp" xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M399 384.2C376.9 345.8 335.4 320 288 320l-64 0c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>
            <div id="nav-container" class="container"></div>
                <nav>
                    <div class="items">
                        <p><a href="#">Log</a></p>
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
            <form action="#" method="POST" name="workout">
                <div class="left" id="left">
                    <fieldset class="base-data">
                        <legend><h3>Workout Date</h3></legend>
                        <input type="date" name="date" id="date" class="input">
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