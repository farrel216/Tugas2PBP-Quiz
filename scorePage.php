<?php 
    session_start();
    require("questions.php");

    // Menghitung jumlah jawaban yang benar dengan mencocokan jawaban user (SESSION['userAnswers])
    // dengan jawaban asli (questions[i][trueAnswer])
    $correctAnswer = 0;
    for ($i = 0; $i < count($_SESSION['userAnswers']); $i++) {
        if ($_SESSION['userAnswers'][$i] == $questions[$i]['trueAnswer']) {
            $correctAnswer++;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Score</title>
    <style>
        body {
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        h1 {
            font-size: 64px;

        }
    </style>
</head>
<body class="bg-success d-flex flex-column align-items-center justify-content-center">
    <!-- Tampilan jumlah jawaban benar -->
    <h1 class="text-light">Selamat!!!</h1>
    <h2 class="text-light">Kamu telah menjawab benar <?=$correctAnswer?> dari <?=count($questions)?></h2>
    <div class="d-flex align-items-center mt-2">
        <!-- Navigasi ke homepage -->
        <a href="index.php" class="btn btn-light btn-lg me-3">Kembali ke halaman utama</a>
        <!-- Play Again Button -->
        <button type="button" class="btn btn-primary btn-lg"><a class="nav-link text-light" href="questionPage.php"><a class="nav-link" href="reset.php">Play Again</a></button>
    </div>
</body>
</html>