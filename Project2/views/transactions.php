<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Transactions</title>
    </head>
    <?php include 'topNavigation.php'; ?>
    <body>
        <h2>Transaction</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Stock ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Timestamp</th>
                <th>ID</th>
            </tr>
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?php echo $transaction->get_user_id(); ?></td>
                    <td><?php echo $transaction->get_stock_id(); ?></td>
                    <td><?php echo $transaction->get_quantity(); ?></td>
                    <td><?php echo $transaction->get_price(); ?></td>
                    <td><?php echo $transaction->get_timestamp(); ?></td>
                    <td><?php echo $transaction->get_id(); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <div>
            <h2>Add or Update Transaction</h2>

            <form action="transactions.php" method="post"> 
                <label>User ID:</label> 
                <input type="text" name="user_id"/><br> 
                <label>Symbol:</label> 
                <input type="text" name="symbol"/><br> 
                <label>Quantity:</label>
                <input type="text" name="quantity"/><br>
                <input type="hidden" name="action" value="insert_or_update"/><br>
                <input type="radio" name="insert_or_update" value="insert" checked>Add</br>
                <input type="radio" name="insert_or_update" value="update">Update</br>
                <label>&nbsp;</label>
                <input type="submit" value="Submit"/> 
            </form>
        </div>
            <div>
                <br>
                <h2>Delete Transaction</h2> 
                <form action="transactions.php" method="post"> 
                    <label>User ID:</label> 
                    <input type="text" name="user_id"/><br> 
                    <label>Stock ID:</label> 
                    <input type="text" name="stock_id"/><br> 
                    <input type="hidden" name="action" value="delete"/><br>
                    <label>&nbsp;</label>
                    <input type="submit" value="Delete Transaction"/> 
                </form> 
            </div>
    </body>
    <?php include 'footer.php'; ?>
</html>
