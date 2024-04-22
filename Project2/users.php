<?php

try {
    require_once 'utility/ensure_logged_in.php';
    require_once 'models/database.php';
    require_once 'models/users.php';

    $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
    $email_address = htmlspecialchars(filter_input(INPUT_POST, "email_address"));
    $cash_balance = filter_input(INPUT_POST, "cash_balance", FILTER_VALIDATE_FLOAT);
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));

    if ($action == "insert_or_update" && $name != "" && $email_address != "" && $cash_balance != 0) {
        $insert_or_update = filter_input(INPUT_POST, "insert_or_update");
        
        $user = new User($name, $email_address, $cash_balance);

        if ($insert_or_update == "insert") {
            insert_user($user);
            
        } elseif ($insert_or_update == "update") {
            update_user($user);
        }
        
        header("Location: users.php");
        
    } elseif ($action == "delete" && $email_address != "") {
        
        $user = new User($name = "", $email_address, $cash_balance = 0);
        
        delete_user($user);
        
        header("Location: users.php");
    
} elseif ($action != "") {
        $error_message = "Missing name, email_address, or cash_balance";
        include 'views/error.php';
    }

    $users = list_user();
    include 'views/users.php';
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include 'views/error.php';
}

