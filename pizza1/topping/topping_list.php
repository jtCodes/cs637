<?php include '../view/header.php'; ?>
<main>
    <section>
        <h1>Topping List</h1>
        <table>
            <tr>
                <th>Topping Name</th>
                <th>&nbsp;</th>
            </tr>

            <?php 
            foreach ($toppings as $topping) : ?>
            <tr>
                <td>
                    <?php echo $topping['topping']; ?>
                </td>
                <td>
                    <form action="index.php" method="post" id="delete_topping_form">
                        <input type="hidden" name="action" value="delete_topping">
                        <input type="submit" value="Delete" />
                        <input type="hidden" name="topping_name" value='<?php echo $topping['topping']; ?>'>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p>
            <a href="?action=show_add_form">Add Topping</a>
        </p>
    </section>
</main>
<?php include '../view/footer.php';