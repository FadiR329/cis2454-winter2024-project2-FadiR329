<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php include 'topNavigation.php'; ?>
    <body>
        <h2>Users</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email Address</th>
                <th>Cash Balance</th>
                <th>ID</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user->get_name(); ?></td>
                    <td><?php echo $user->get_email_address(); ?></td>
                    <td><?php echo $user->get_cash_balance(); ?></td>
                    <td><?php echo $user->get_id(); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <div>
            <h2>Add or Update User</h2>
            <form action="users.php" method="post"> 
                <label>Name:</label> 
                <input type="text" name="name"/><br> 
                <label>Email Address:</label> 
                <input type="text" name="email_address"/><br> 
                <label>Cash Balance:</label>
                <input type="text" name="cash_balance"/><br>
                <input type="hidden" name="action" value="insert_or_update"/><br>
                <input type="radio" name="insert_or_update" value="insert" checked>Add</br>
                <input type="radio" name="insert_or_update" value="update">Update</br>
                <label>&nbsp;</label>
                <input type="submit" value="Submit"/> 
            </form>
        </div>
        <div>
            <br>
            <h2>Delete User</h2> 
            <form action="users.php" method="post"> 
                <?php include 'userEmailDropDown.php'; ?>
                <input type="hidden" name="action" value="delete"/><br>
                <label>&nbsp;</label>
                <input type="submit" value="Delete User"/> 
            </form> 
        </div>
        <br>
    </body>
    <?php include 'footer.php'; ?>
</html>
