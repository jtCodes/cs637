<?php include '../view/header.php'; ?>
<main>
    <section>
        <h1>Welcome Student!</h1>

        <h2>Available Sizes</h2>
        <p>
            <?php 
            foreach ($sizes as $size) : ?> |
            <?php echo $size['size']; ?> |
            <?php endforeach; ?>
        </p>
        <h2>Available Toppings</h2>
        <p>
            <?php 
            foreach ($toppings as $topping) : ?> |
            <?php echo $topping['topping']; ?> |
            <?php endforeach; ?>
        </p>
        <p>
            <form action="index.php" method="post" id="room_select_form">
                Room No:
                <input type="hidden" name="action" value="select_room">
                <select name="room">
                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php if(isset($_POST[ 'room']) && $_POST[ 'room']==$i) echo 'selected="selected"';?>>
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                <input type="submit" value="Select" />
            </form>
        </p>

        <h2>Orders in progress for room
            <?php echo $room ?> </h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Room No</th>
                <th>Toppings</th>
                <th>Status</th>
            </tr>
            <?php 
            foreach ($orders as $order) : ?>
            <tr>
                <td>
                    <?php echo $order['id']; ?>
                </td>
                <td>
                    <?php echo $order['room_number']; ?>
                </td>
                <td>
                    <?php echo $order['topping']; ?>
                </td>
                <td>
                    <?php echo $order['status']; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <form action="index.php" method="post" id="pizza_delivered">
            <input type="hidden" name="action" value="pizza_delivered">
            <input type="hidden" name="room" value='<?php echo $room; ?>'>
            <input type="submit" value="Acknowledge Delivery of Baked Pizzas" />
        </form>

        <p>
            <a href="?action=show_order_form&room=<?php echo $room ?>">Order Pizza</a>
        </p>
    </section>
</main>
<?php include '../view/footer.php';