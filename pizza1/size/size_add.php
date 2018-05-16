<?php include '../view/header.php'; ?>
<main>
    <section>
        <h1>Add Size</h1>
        <form action="index.php" method="post" id="add_size_form">
            <input type="hidden" name="action" value="add_size">

            <label>Size:</label>
            <input type="text" name="size_name" required/>
            <br>
            <input id="add_size_button" type="submit" value="Add Size" />
            <br>
        </form>
        <p class="size_last_paragraph">
            <a href="../size">View Size List</a>
        </p>
    </section>
</main>
<?php include '../view/footer.php';