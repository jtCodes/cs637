<?php include '../view/header.php'; ?>
<main>
    <section>
        <h1>Sizes List</h1>
        <table>
            <tr>
                <th>Topping Name</th>
                <th>&nbsp;</th>
            </tr>

            <?php 
            foreach ($sizes as $size) : ?>
            <tr>
                <td>
                    <?php echo $size['size']; ?>
                </td>
                <td>
                    <form action="index.php" method="post" id="delete_size_form">
                        <input type="hidden" name="action" value="delete_size">
                        <input type="submit" value="Delete" />
                        <input type="hidden" name="size_name" value='<?php echo $size['size']; ?>'>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p>
            <a href="?action=show_add_form">Add Size</a>
        </p>
    </section>
</main>
<?php include '../view/footer.php';