<?php
/* Super global variabel session merupakan variabel yang digunakan untuk menyimpan 
   variabel-variabel penting yang digunakan oleh semua page dalam satu session.
   Session dibuat dengan menggunakan session_start(). Variabel session dapat diakses
   dengan menggunakan $_SESSION[<string_key_atau_nama_variabel>]
*/
session_start();
require("questions.php");

/* Dalam web kuis ini, jawaban hanya akan tersimpan apabila user menuju ke page lainnya
   (dengan menggunakan navigasi angka, tombol next dan previous, atau tombol submit).
   Method yang digunakan adalah GET, karena ingin menunjukkan nomor pertanyaan saat ini.
   Namun karena jawaban dikirim dengan menggunakan button-button navigasi, jawaban tidak 
   dapat dikirimkan dengan POST, karena form yang digunakan harus menggunakan GET
*/

// Mengambil nomor pertanyaan saat ini menggunakan variabel GET
$questionNum = isset($_GET['questionNum']) ? $_GET['questionNum'] : 1;

// Membuat variabel prevNum yang digunakan untuk menyimpan angka sebelumya
// Digunakan ketika menyimpan jawaban user
$prevNum = isset($_SESSION['prevNumberAccesed']) ? $_SESSION['prevNumberAccesed'] : $questionNum;

// Variabel prevNumberAccessed di SESSION berubah menjadi variabel saat ini, agar bisa 
// diakses ketika  user mengganti soal
$_SESSION['prevNumberAccesed'] = $questionNum;

// Setting waktu mulai. Ketika user memulai kuis, waktu saat ini akan secara otomatis tersetting
// Menggunakan waktu Asia/Bangkok. Timezone yang sama juga digunakan di JavaScript
if (!isset($_SESSION['start_time'])) {
    $date = new DateTime("now", new DateTimeZone("Asia/Bangkok"));
    $_SESSION['start_time'] = $date->format('Y-m-d H:i:s');
}

// Inisialisasi jawaban-jawaban dari user dengan array integer berisikan 0
if (!isset($_SESSION['userAnswers'])) {
    $_SESSION['userAnswers'] = array_fill(0, count($questions), 0);
}

// Apabilauser menjawab soal, jawaban user akan disimpan dalam variabel SESSION['userAnswers']
if (isset($_GET['answer'])) {
    $_SESSION['userAnswers'][$prevNum - 1] = $_GET['answer'];

    // Unset variabel agar jawaban yang sama tidak disimpan pada pertanyaan berikutnya apabila
    // user tidak menjawab pertanyaan berikutnya
    unset($_GET['answer']);
}

// Apabila user mensubmit quiz, maka lakukan redirect ke scorePage.php (menggunakan JavaScript)
if (isset($_GET['submit'])) {
    if ((bool)$_GET['submit']) {
        echo "<script>document.location.href = 'scorePage.php'</script>";
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
    <title>Quiz - Soal <?=$questionNum?> dari <?=count($questions)?></title>
</head>

<body class="container bg-success d-flex flex-column align-items-center justify-content-center py-5">
    <form action="questionPage.php" method="GET" style="width:100%;">
        <section class="row">
            <div class="col-lg-9 rounded-2 p-4 fs-3" style="background:#E6F1F3;">
                <!-- Pertanyaan -->
                <!-- Ambil dari array questions, berdasarkan questionNum saat ini -->
                <p>
                    <?= $questions[$questionNum - 1]['question'] ?>
                </p>

                <!-- Jawaban -->
                <ul class="list-group">
                    <!-- Iterasi setiap jawaban yang ada, lalu munculkan sebagai elemen HTML dengan echo -->
                    <?php foreach ($questions[$questionNum - 1]['answers'] as $answer) : ?>
                        <li class="answer-list list-group-item">
                            <!-- Menambahkan radio button (dengan atribut checked apabila user sebelumnya telah memilih jawaban tersebut) -->
                            <input type="radio" name="answer" id="<?= $answer['id'] ?>" value="<?= $answer['id'] ?>" 
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
                <!-- Navigasi angka, menggunakan for loop hingga jumlah pertanyaan saat ini -->
                <!-- Button ini akan mensubmit value questionNum sesuai angka di dalamnya, serta akan mensubmit jawaban apabila telah diset -->
                <nav class="navigation p-2 rounded-2" style="background:#E6F1F3; min-height: 200px;">
                    <?php for ($i = 0; $i < count($questions); $i++) : ?>
                        <!-- Bila pertanyaan sudah dijawab, warna navigasi angka berubah menjadi hijau -->
                        <!-- Navigasi angka juga diberi border apabila merupakan pertanyaaan saat ini -->
                        <button class="btn btn-lg m-2 <?= $i+1 == $questionNum ? "border border-3" : "" ?> <?= ($_SESSION['userAnswers'][$i] != 0 || $_SESSION['userAnswers'][$i] != '0' ? 'bg-success text-light' : 'bg-light ') ?> " name="questionNum" type="submit" value=<?= $i + 1 ?>><?= $i + 1 ?></button>
                    <?php endfor; ?>
                </nav>
                <section class="d-flex flex-column align-items-center">
                    <!-- Submit button -->
                    <button class="btn btn-lg btn-primary my-3" type="submit" id="submit-btn">Submit</button>
                    
                    <!-- Timer -->
                    <div class="text-light fs-3" id="timer"></div>
                    
                    <!-- Navigasi Next/Previous -->
                    <!-- Button ini akan mensubmit value questioNum selanjutnya (Next) atau sebelumnya (Previous), serta akan mensubmit jawaban apabila telah diset -->
                    <div class="d-flex">
                        <button style="visibility: <?= ($questionNum == 1 ? 'hidden' : 'visible') ?>" class="btn btn-warning  me-2 <?= ($questionNum == 1 ? 'hidden' : '') ?>" name="questionNum" type="submit" value='<?= $questionNum - 1 ?>' >Previous</button>
                        <button style="visibility: <?= ($questionNum == count($questions) ? 'hidden' : 'visible') ?>" class="btn btn-warning" name="questionNum" type="submit" value='<?= $questionNum + 1 ?>' >Next</button>
                    </div>
                </section>
            </div>
        </section>
    </form>
    <script>
        // Membuat seluruh bagian jawaban bisa diklik untuk memilih jawaban
        Array.from(document.getElementsByClassName("answer-list")).forEach(answer => {
            answer.addEventListener('click', e => {
                // Hanya lakukan event ini apabila yang diklik adalah list
                // Mencegah event berjalan apabila child dari list diklik
                if (e.target.tagName === "LI") {
                    const radioBtn = e.target.childNodes[1];
                    radioBtn.checked = true
                }
            })
        })

        // Fungsi untuk mengumpulkan quiz
        function submitQuiz() {
            // Melakukan pencarian jawaban apabila user menkonfirmasi ingin submit.
            // Hal ini dilakukan karena proses submit dilakukan dengan menambahkan
            // data submit=True ke GET, lalu diproses di script PHP di atas
            const radioButtons = document.getElementsByName("answer");
            let answeredIdx = 0;
            for (let i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    answeredIdx = i + 1;
                    break;
                }
            }

            // Mengubah url dan mengisinya dengan data-data jawaban dan submit=True
            // Dengan menggunakan script PHP di bagian paling atas, jawaban user akan
            // diambil dari variabel GET dan akan dilakukan submit
            window.location.href = `questionPage.php?answer=${answeredIdx}&submit=True`

        }
        // Memberikan alert submit
        document.getElementById("submit-btn").addEventListener('click', (e) => {
            // Bila submit button diklik, lakukan alert konfirmasi submit terlebih dahulu
            // Karena harus ada alert sebelum dilakukan submit, harus dilakukan preventDefault
            // agar form tidak tersubmit
            e.preventDefault()
            if (confirm("Apakah anda yakin ingin mensubmit?")) {
                submitQuiz()
            }
        })
        
        // Kode untuk timer
        const timer = document.getElementById("timer")
        
        // Prosedur timerFunc akan melakukan processing waktu yang tersisa untuk mengerjakan soal
        function timerFunc() {
            // Ambil waktu mulai dari SESSION['start_time] dan waktu saat ini dengan menggunakan new Date() 
            // Menggunakan timezone Asia/Bangkok agar konsisten
            let startTime = new Date("<?= $_SESSION['start_time'] ?>"); 
            let currentTime = new Date(new Date().toLocaleString([], {"timeZone": "Asia/Bangkok"}))
            
            // Sisa waktu dihitung dari time_limit - (currentTime - startTime) {time_limit diset di questions.php}
            let remainingSeconds = parseInt("<?= $timeLimitSec ?>") - Math.floor(Math.abs(currentTime - startTime) / 1000)
            
            // Hitung waktu tersisa dari remainingSeconds
            let hour = Math.floor(remainingSeconds / 3600)
            let minute = Math.floor(remainingSeconds % 3600 / 60)
            let second = Math.floor(remainingSeconds % 3600 % 60)

            // Apabila waktu habis, lakukan submit quiz
            if (hour <= 0 && minute <= 0 && second <= 0) {
                submitQuiz()
            }
            
            // Ubah innerHTML dari div timer
            timer.innerHTML = `${(hour < 10 ? '0' : '') + hour}:${(minute < 10 ? '0' : '') + minute}:${(second < 10 ? '0' : '') + second}`
        }

        // Mulai timer secara langsung terlebih dahulu, lalu buat interval sehingga setiap 1 detik, timerFunc akan dijalankan
        // Fungsi timerFunc() dijalankan terlebih dahulu karena apabila tidak, timer baru muncul setelah 1 detik website diload
        timerFunc()
        setInterval (timerFunc, 1000);
    </script>
</body>

</html>