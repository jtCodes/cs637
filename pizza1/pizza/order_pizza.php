<?php include '../view/header.php'; ?>
<main>
    <section>
        <h1> Order Pizza </h1>
        <form action="index.php" method="post" id="order_form">
            <input type="hidden" name="action" value="order_pizza">

            <h3> Pizza Size: </h3>
            <?php foreach ($sizes as $size) : ?>
            <input type="radio" name="size" value="<?php echo $size['size']; ?>" required>
            <?php echo $size['size']; ?>
            <?php endforeach; ?>

            <h3> Pizza Toppings: </h3>
            <?php foreach ($toppings as $topping) : ?>
            <input type="checkbox" name="topping[]" value="<?php echo $topping['topping']; ?>">
            <?php echo $topping['topping']; ?>
            <br>
            <?php endforeach; ?>

            <p>
                Room No:
                <select name="room">
                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <option value= <?php echo $i;?> <?php if($i == $room) echo 'selected="selected"';?>>
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </p>

            <input type="submit" value="Order Pizza" />
        </form>
    </section>
</main>
<?php include '../view/footer.php';