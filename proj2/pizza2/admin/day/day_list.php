<?php include '../../view/header.php'; ?>
<main>
    <section>
        <h1>Today is day <?php echo $current_day; ?></h1>
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="next_day">
            <input type="submit" value="Advance to day <?php echo $current_day + 1; ?>" />
        </form>

        <form  action="index.php" method="post">
            <input type="hidden" name="action" value="initial_db">           
            <input type="submit" value="Initialize DB (making day = 1)" />
            <br>
        </form>
        <br>
        <h2>Today's Orders</h2>
        <?php if (count($todays_orders) > 0) : ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Room No</th>
                    <th>Status</th>
                </tr>

                <?php foreach ($todays_orders as $todays_order) : ?>
                    <tr>
                        <td><?php echo $todays_order['id']; ?> </td>
                        <td><?php echo $todays_order['room_number']; ?> </td>  
                        <td><?php echo $todays_order['status']; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No Orders Today </p>
        <?php endif; ?>
        <br>
        <h2>Undelivered Orders</h2>
        <table>
                <tr>
                    <th>Order ID</th>
                    <th>Flour Qty</th>
                    <th>Cheese Qty</th>
                </tr>

                <?php foreach ($undelivered_orders as $order) : ?>
                    <tr>
                        <td><?php echo $order['orderid']; ?> </td>  
                        <td><?php echo $order['flour_qty']; ?> </td>
                        <td><?php echo $order['cheese_qty']; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <br>
        <h2>Current Inventory</h2>
        <table>
                <tr>
                    <th>Flour Qty</th>
                    <th>Cheese Qty</th>
                </tr>

                <?php foreach ($inventory as $inven) : ?>
                    <tr>
                        <td><?php echo $inven[0]; ?> </td>  
                        <td><?php echo $inven[1]; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </table>
    </section>

</main>
<?php include '../../view/footer.php'; ?>