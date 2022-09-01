<?php 
    session_start();
    require("questions.php");

    $correctAnswer = 0;
    for ($i = 0; $i < count($_SESSION['userAnswers']); $i++) {
        if ($_SESSION['userAnswers'][$i] == $questions[$i]['trueAnswer']) {
            $correctAnswer++;
        }
    }

    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score</title>
</head>
<body>
    <h1>Selamat!!!</h1>
    <h2>Kamu telah menjawab benar <?=$correctAnswer?> dari <?=count($questions)?></h2>
    <!-- Play Again Button -->
    <a href="reset.php">Play Again</a>
</body>
</html>