<?php

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    
    $workoutDate= htmlspecialchars($_POST["date"]);
    $workoutType= htmlspecialchars($_POST["type"]);
    $numberOfSets= htmlspecialchars($_POST["number"]);

    echo $workoutDate;
    echo "<br>";
    echo $workoutType;
    echo "<br>";
    echo $numberOfSets;
    echo "<br>";
    
    // formhandler.php

    $exerciseCount = isset($_POST['number']) ? (int)$_POST['number'] : 0;
    $exercises = [];

    for ($i = 1; $i <= $exerciseCount; $i++) {
        $name      = isset($_POST["ex{$i}"])   ? trim($_POST["ex{$i}"]) : '';
        $setNumber = isset($_POST["sets{$i}"]) ? (int)$_POST["sets{$i}"] : 0;

        $weights = [];
        $reps    = [];

        for ($j = 1; $j <= $setNumber; $j++) {
            $wKey = "set{$i}_w{$j}";   // matches JS above
            $rKey = "set{$i}_r{$j}";

            $w = isset($_POST[$wKey]) ? (int)$_POST[$wKey] : 0;
            $r = isset($_POST[$rKey]) ? (int)$_POST[$rKey] : 0;

            $weights[] = $w;
            $reps[]    = $r;
        }

        $exercises[] = [
            'name'      => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            'setNumber' => $setNumber,
            'weights'   => $weights,
            'reps'      => $reps,
        ];
    }

    // Example echo to verify:
    foreach ($exercises as $ex) {
        echo "name: {$ex['name']}<br>";
        echo "setNumber: {$ex['setNumber']}<br>";
        echo "Weights: " . implode(', ', $ex['weights']) . "<br>";
        echo "Reps: "    . implode(', ', $ex['reps'])    . "<br><hr>";
    }
    
    //header("Location: ../index.php");
} else{
    header("Location: ../index.php");
}