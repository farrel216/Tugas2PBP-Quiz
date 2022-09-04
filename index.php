<?php 
// Reset session terlebih dahulu agar session sebelumnya hilang
session_start();
session_destroy();
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
    <title>[SIAP] Pengembangan Berbasis Platform C</title>
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
    <h1 class="text-light">Kuis 2 - PHP</h1>
    <!-- Navigasi ke halaman pertama kuis -->
    <button type="button" class="btn btn-primary btn-lg"><a class="nav-link" href="questionPage.php?questionNum=1">Start</a></button>
</body>
</html>
