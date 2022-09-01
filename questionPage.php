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

if (!isset($_SESSION['start_time'])) {
    $date = new DateTime("now", new DateTimeZone("Asia/Bangkok"));
    $_SESSION['start_time'] = $date->format('Y-m-d H:i:s');
}

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

if (isset($_GET['submit'])) {
    if ((bool)$_GET['submit']) {
        header('Location: scorePage.php');
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Quiz - Soal <?=$questionNum?> dari <?=count($questions)?></title>
</head>

<body class="container bg-success d-flex flex-column align-items-center justify-content-center py-5">
    <form action="questionPage.php" method="GET" style="width:100%;">
        <section class="row">
            <div class="col-lg-9 rounded-2 p-4 fs-3" style="background:#E6F1F3;">
                <p>
                    <?= $questions[$questionNum - 1]['question'] ?>
                </p>
                <ul class="list-group">
                    <?php foreach ($questions[$questionNum - 1]['answers'] as $answer) : ?>
                        <li class="list-group-item">
                            <input class="" type="radio" name="answer" id="<?= $answer['id'] ?>" value="<?= $answer['id'] ?>" 
                            <?php
                            if ($answer['id'] == $_SESSION['userAnswers'][$questionNum - 1]) {
                                echo "checked";
                            }
                            ?>>
                            <label class="user-select-none" for="<?= $answer['id'] ?>"><?= $answer['content'] ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <!-- Reset answer -->
                <a class="nav-link text-danger mt-2" href="?answer=0&questionNum=<?= $questionNum ?>">Reset</a>
            </div>
            <div class="col-lg-3 mt-3 mt-lg-0">
                <!-- Navigasi angka -->
                <nav class="navigation p-2 rounded-2" style="background:#E6F1F3; min-height: 200px;">
                    <?php for ($i = 0; $i < count($questions); $i++) : ?>
                        <button class="btn btn-lg m-2 <?= ($_SESSION['userAnswers'][$i] != 0 || $_SESSION['userAnswers'][$i] != '0' ? 'bg-success text-light' : 'bg-light ') ?> " name="questionNum" type="submit" value=<?= $i + 1 ?>><?= $i + 1 ?></button>
                    <?php endfor; ?>
                </nav>
                <section class="d-flex flex-column align-items-center">
                    <button class="btn btn-lg btn-primary my-3" type="submit" id="submit-btn">Submit</button>

            <!-- Timer -->
            <div class="text-light fs-3" id="timer"></div>
                    <div class="d-flex">
                        <button style="visibility: <?= ($questionNum == 1 ? 'hidden' : 'visible') ?>" class="btn btn-warning  me-2 <?= ($questionNum == 1 ? 'hidden' : '') ?>" name="questionNum" type="submit" value='<?= $questionNum - 1 ?>' >Previous</button>
                        <button style="visibility: <?= ($questionNum == count($questions) ? 'hidden' : 'visible') ?>" class="btn btn-warning" name="questionNum" type="submit" value='<?= $questionNum + 1 ?>' >Next</button>
                    </div>
                </section>

                <!-- Uncomment untuk debugging jawaban user saat ini -->
                <!-- <h1>Jawaban user:</h1>
        <h2>
            <?php foreach ($_SESSION['userAnswers'] as $ans) : ?>
                <?= $ans ?>
            <?php endforeach ?>
        </h2> -->
            </div>


        </section>
    </form>
    <script>
        document.getElementById("submit-btn").addEventListener('click', (e) => {
            e.preventDefault()
            if (confirm("Apakah anda yakin ingin mensubmit?")) {
                const radioButtons = document.getElementsByName("answer");
                let answeredIdx = 0;
                for (let i = 0; i < radioButtons.length; i++) {
                    if (radioButtons[i].checked) {
                        answeredIdx = i + 1;
                        break;
                    }
                }

                window.location.href = `questionPage.php?answer=${answeredIdx}&submit=True`
            }
        })
        
        const timer = document.getElementById("timer")
        function timerFunc() {
            let startTime = new Date("<?= $_SESSION['start_time'] ?>"); 
            let currentTime = new Date()
            
            let remainingSeconds = parseInt("<?= $timeLimitSec ?>") - Math.floor(Math.abs(currentTime - startTime) / 1000)
            let hour = Math.floor(remainingSeconds / 3600)
            let minute = Math.floor(remainingSeconds % 3600 / 60)
            let second = Math.floor(remainingSeconds % 3600 % 60)

            if(hour === 0 && minute === 0 && second === 0) {
                const radioButtons = document.getElementsByName("answer");
                let answeredIdx = 0;
                for (let i = 0; i < radioButtons.length; i++) {
                    if (radioButtons[i].checked) {
                        answeredIdx = i + 1;
                        break;
                    }
                }

                window.location.href = `questionPage.php?answer=${answeredIdx}&submit=True`
            }
            
            timer.innerHTML = `${(hour < 10 ? '0' : '') + hour}:${(minute < 10 ? '0' : '') + minute}:${(second < 10 ? '0' : '') + second}`
        }

        timerFunc()

        setInterval (timerFunc, 1000);
    </script>
</body>

</html>