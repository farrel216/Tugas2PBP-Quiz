<?php 
    session_start();
    require("questions.php");
    global $questionNum;
    $questionNum = isset($_GET['questionNum']) ? $_GET['questionNum'] : 1;

    if (!isset($_SESSION['prevQuestion'])) {
        $_SESSION['prevQuestion'] = [$questionNum];
    } else {
        array_push($_SESSION['prevQuestion'], $questionNum); 
    }

    if (isset($_GET['answer'])) {
        $questions[$_SESSION['prevQuestion'][0]]['userAnswer'] = $_GET['answer']; 
    }

    array_shift($_SESSION['prevQuestion']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
</head>
<body>
    <form action="index.php" method="GET">
        <section>
            <p>
                <?= $questions[$questionNum-1]['question'] ?>
            </p>
            
            <?php foreach($questions[$questionNum-1]['answers'] as $answer): ?>
                <!-- <h1><?= $questionNum ?></h1> -->
                <input type="radio" name="answer" value="<?= $answer['id']?>" 
                    <?php if ($answer['id'] == $questions[$questionNum-1]['userAnswer']) {
                        echo "checked";
                    }?>>
                <?= $answer['content'] ?>
            <?php endforeach; ?>
        </section>
        <section>
            <?php for($i=0;$i<count($questions);$i++): ?>
                <a href="?questionNum=<?= $i+1 ?>"><?= $i+1 ?></a>
            <?php endfor; ?>
            <button name="questionNum" type="submit" value='<?= ($questionNum != 1) ? $questionNum - 1 : $questionNum?>'>Previous</button>
            
            <?= "Soal ".$questionNum?>
            <!-- <h1><?= (int)($questionNum)?></h1> --> 
            <!-- <h1><?= (int)($_GET['questionNum'])?></h1> -->
            
            <button name="questionNum" type="submit" value='<?= ($questionNum != count($questions)) ? $questionNum + 1 : $questionNum ?>'>Next</button>
        </section>
    </form>
</body>
</html>


