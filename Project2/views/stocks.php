<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Stocks List</title>
    </head>
    <?php include 'topNavigation.php'; ?>
    <body>
        <table>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Current Price</th>
                <th>ID</th>
            </tr>
<?php foreach ($stocks as $stock) : ?>
                <tr>
                    <td><?php echo $stock->get_symbol(); ?></td>
                    <td><?php echo $stock->get_name(); ?></td>
                    <td><?php echo $stock->get_current_price(); ?></td>
                    <td><?php echo $stock->get_id(); ?></td>
                </tr>
<?php endforeach; ?>
        </table>
        <br>
        <div>
            <h2>Add or Update Stock</h2>

            <form action="stocks.php" method="post"> 
                <label>Symbol:</label> 
                <input type="text" name="symbol"/><br> 
                <label>Name:</label> 
                <input type="text" name="name"/><br> 
                <label>Current Price:</label>
                <input type="text" name="current_price"/><br>
                <input type="hidden" name="action" value="insert_or_update"/><br>
                <input type="radio" name="insert_or_update" value="insert" checked>Add</br>
                <input type="radio" name="insert_or_update" value="update">Update</br>
                <label>&nbsp;</label>
                <input type="submit" value="Submit"/> 
            </form>
        </div>
        
        <div>
            <br><h2>Delete Stock</h2> 

            <form action="stocks.php" method="post"> 
                <?php include 'stockSymbolDropDown.php'; ?>
                <input type="hidden" name="action" value="delete"/><br>
                <label>&nbsp;</label>
                <input type="submit" value="Delete Stock"/> 
            </form> 
        </div>

    </body>
    <?php include 'footer.php'; ?>
</html>
