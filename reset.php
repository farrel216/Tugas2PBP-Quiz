<?= 
// Reset session menggunakan session_destroy()
session_start();
session_destroy();
?>

<script>
    // setelah direset session, maka user akan kembali ke soal no 1
    window.location.href = './questionPage.php'
</script>