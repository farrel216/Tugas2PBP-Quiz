<?= 
session_start();
session_destroy();

// setelah direset session, maka user akan kembali ke soal no 1
header('Location: questionsPage.php');
?>