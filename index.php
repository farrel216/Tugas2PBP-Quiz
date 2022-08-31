<?php 
    require("questions.php");
    global $questionNum, $prevNum; 
    $questionNum = isset($_POST['questionNum']) ? $_POST['questionNum'] : 1;
    $prevNum = $questionNum;
    if(isset($_POST['answer'])){ 
        $questions[$prevNum]['userAnswer'] = $_POST['answer'];
    }
    
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
    <form action="index.php" method="POST">
        <section>
            <p>
                <?= $questions[$questionNum-1]['question'] ?>
            </p>
            
            <?php foreach($questions[$questionNum-1]['answers'] as $answer): ?>
                <!-- <h1><?= $questionNum ?></h1> -->
                <h1><?= $prevNum ?></h1>
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
            <button name="questionNum" type="submit" value='<?= $questionNum - 1?>'>Previous</button>
            <?= "Soal ".$questionNum?>
            <button name="questionNum" type="submit" value='<?= $questionNum + 1?>'>Next</button>
        </section>
    </form>
</body>
</html>


