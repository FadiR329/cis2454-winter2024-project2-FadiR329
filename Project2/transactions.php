<?php

try {
    require_once 'utility/ensure_logged_in.php';
    require_once 'models/database.php';
    require_once 'models/transactions.php';

    $symbol = htmlspecialchars(filter_input(INPUT_POST, "symbol"));
    $user_id = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
    $stock_id = filter_input(INPUT_POST, "stock_id", FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_FLOAT);
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));

    if ($action == "insert_or_update" && $user_id != 0 && $symbol != "" && $quantity != 0) {
        $insert_or_update = filter_input(INPUT_POST, 'insert_or_update');
        
        $transaction = new Transaction($user_id, $stock_id = 0, $quantity);

        if ($insert_or_update == "insert") {
            insert_transaction($transaction, $symbol);
        } elseif ($insert_or_update == "update") {
            update_transaction($transaction, $symbol);
        }

        header("Location: transactions.php");
    } elseif ($action == "delete" && $user_id != 0 && $stock_id != 0) {
        
        $transaction = new Transaction($user_id, $stock_id, $quantity = 0);
         
        delete_transaction($transaction);

        header("Location: transactions.php");
        
    } elseif ($action != "") {
        $error_message = "Missing symbol, user_id, or quantity";
        include 'views/error.php';
    }


    $transactions = list_transaction();
    include 'views/transactions.php';
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include 'views/error.php';
}

