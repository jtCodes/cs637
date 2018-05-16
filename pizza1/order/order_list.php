<?php include '../view/header.php'; ?>
<main>
    <section>
        <h1>Current Orders Report for Day <?php echo $day;?></h1>

        <h2>Orders Baked but not delivered</h2>
        <?php foreach ($baked_pizzas as $baked) : ?>
        <p>
            ID:
            <?php echo $baked['id'];?> 
            Room:
            <?php echo $baked['room_number']; ?>
        </p>
        <?php endforeach; ?>

        <h2>Orders Preparing(in the oven): Any ready now?</h2>
        <?php foreach ($preparing_pizzas as $preparing) : ?>
        <p>
            ID:
            <?php echo $preparing['id'];?> 
            Room:
            <?php echo $preparing['room_number']; ?>
        </p>
        <?php endforeach; ?>

        <br>
        <form action="index.php" method="post" id="mark_baked">
            <input type="hidden" name="action" value="mark_baked">
            <input type="submit" value="Mark Oldest Pizza Baked" />
        </form>
        <br>
    </section>
</main>
<?php include '../view/footer.php';