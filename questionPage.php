<?php
// Ngga bisa nyimpen jawaban di array questions karena arraynya bakal ke reset lagi (userAnswers berubah lagi jadi 0)
// Solusi: pakai session array, yang merupakan global variabel (tidak akan berubah ketika file direfresh)
session_start();
require("questions.php");

// Pakai variabel biar ngga kebanyakan pake isset dibawahnya
$questionNum = isset($_GET['questionNum']) ? $_GET['questionNum'] : 1;

// Bikin variabel prevNumber untuk nyimpen nomor soal yang diakses user sebelumnya
// Diambil dari variabel prevNumberAccesed di superglobal var session
// Nanti dipakai ketika nyimpen jawaban user
$prevNum = isset($_SESSION['prevNumberAccesed']) ? $_SESSION['prevNumberAccesed'] : $questionNum;

// Variabel prevNumberAccessed di SESSION berubah jadi variabel saat ini, agar bisa 
// diakses waktu user ganti soal
$_SESSION['prevNumberAccesed'] = $questionNum;

// Inisialisasi jawaban-jawaban dari user dengan array integer berisikan 0
if (!isset($_SESSION['userAnswers'])) {
    $_SESSION['userAnswers'] = array_fill(0, count($questions), 0);
}

// Kalau user menjawab soal, jawaban user disimpen dalam SESSION
if (isset($_GET['answer'])) {
    $_SESSION['userAnswers'][$prevNum - 1] = $_GET['answer'];

    // Unset agar kalo user ngga jawab di soal ini, jawabannya soal sebelumnya ngga
    // kesimpen di soal ini
    unset($_GET['answer']);
}

// Reset session. Tinggal di uncomment, terus next / previous
// session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Soal <?=$questionNum?> dari <?=count($questions)?></title>
</head>

<body>
    <form action="questionPage.php" method="GET">
        <section>
            <p>
                <?= $questions[$questionNum - 1]['question'] ?>
            </p>

            <?php foreach ($questions[$questionNum - 1]['answers'] as $answer) : ?>
                <input type="radio" name="answer" value="<?= $answer['id'] ?>" <?php if ($answer['id'] == $_SESSION['userAnswers'][$questionNum - 1]) {
                                                                                    echo "checked";
            } ?>>
                <?= $answer['content'] ?>
            <?php endforeach; ?>
        </section>
        <section>
            <button name="questionNum" type="submit" value='<?= $questionNum - 1 ?>' <?= ($questionNum == 1 ? 'hidden' : '') ?>>Previous</button>

            <?= "Soal " . $questionNum ?>

            <!-- Debugging -->
            <!-- <h1><?= (int)($questionNum) ?></h1> -->
            <!-- <h1><?= (int)($_GET['questionNum']) ?></h1> -->

            <button name="questionNum" type="submit" value='<?= $questionNum + 1 ?>' <?= ($questionNum == count($questions) ? 'hidden' : '') ?>>Next</button>

            <!-- Reset answer -->
            <a href="?answer=0&questionNum=<?=$questionNum?>">Reset</a>

        </section>

        <!-- Uncomment untuk debugging jawaban user saat ini -->
        <!-- <h1>Jawaban user:</h1>
        <h2>
            <?php foreach ($_SESSION['userAnswers'] as $ans) : ?>
                <?= $ans ?>
            <?php endforeach ?>
        </h2> -->
        <!-- Navigasi angka -->
        <?php for ($i = 0; $i < count($questions); $i++) : ?>
            <button name="questionNum" type="submit" value=<?= $i + 1 ?>><?= $i + 1 ?></button>
        <?php endfor; ?>
    </form>
    <section>
        <form action="scorePage.php" method="GET">
            <button type="submit">Submit</button>
        </form>
    </section>
</body>

</html>