<?php 
    require("questions.php");
    isset($_GET['id']) ? $questionId = $_GET['id'] : $questionId = 1;

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
    <section>
        <p>
            <?= $questions[isset($_GET['id']) ? $_GET['id']-1 : 0]['question'] ?>
        </p>
        
            <?php foreach($questions[isset($_GET['id']) ? $_GET['id']-1 : 0]['answers'] as $answer): ?>
                <input type="radio" name="answer" value="<?= $answer['id']?>" 
                <?php if ($answer['id'] == $questions[isset($_GET['id']) ? $_GET['id']-1 : 0]['userAnswer']) {
                    echo "checked";
                }?>>
            <?= $answer['answer'] ?>
            <?php endforeach; ?>
    </section>
    <?php for($i=0;$i<count($questions);$i++): ?>
        <a href="?id=<?= $i+1 ?>"><?= $i+1 ?></a>
        <?php endfor; ?>
    <form action="index.php" method="GET">
        <button name="id" type="submit" value='<?= $questionId-1 ?>'>Previous</button>
        <?= "Soal ".$questionId ?>
        <button name="id" type="submit" value='<?= $questionId+1 ?>'>Next</button>
    </form>
</body>
</html>


