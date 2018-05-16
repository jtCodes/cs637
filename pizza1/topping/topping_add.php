<?php include '../view/header.php'; ?>
<main>
    <h1>Add Topping</h1>
    <form action="index.php" method="post" id="add_topping_form">
        <input type="hidden" name="action" value="add_topping">

        <label>Topping:</label>
        <input type="text" name="topping_name" required/>
        <br>
        <input id="add_topping_button" type="submit" value="Add Topping" />
        <br>
    </form>
    <p class="last_paragraph">
        <a href="../topping">View Topping List</a>
    </p>

</main>
<?php include '../view/footer.php'; ?>