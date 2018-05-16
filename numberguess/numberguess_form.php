<!DOCTYPE html>
<html>
    <head>
        <title>Guess a number</title>
    </head>
    <body> 
        <?php
        if (isset($guess)) { 
            echo $_SESSION['name'].", Please try another number than $guess<br>";
           // var_dump($guess);
        } ?>
        For $100, what number I am thinking of?
        <?php
        echo $_SESSION['name'];
        ?>
        <form method='POST' action='.'>
            Name: <input type='text' name='name' value = <?php echo isset($_SESSION['name'])? $_SESSION['name']:''?>><br>
            Guess: <input type='text' name='guess'>
            <input type='submit' value='Try!'>
        </form>
    </body>
</html> 
