<?php

try {
    require_once 'utility/ensure_logged_in.php';
    require_once 'models/database.php';
    require_once 'models/stocks.php';

    $symbol = htmlspecialchars(filter_input(INPUT_POST, "symbol"));
    $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
    $current_price = filter_input(INPUT_POST, "current_price", FILTER_VALIDATE_FLOAT);
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));

    if ($action == "insert_or_update" && $symbol != "" && $name != "" && $current_price != 0) {
        $insert_or_update = filter_input(INPUT_POST, 'insert_or_update');
        
        $stock = new Stock($symbol, $name, $current_price);
        
        if($insert_or_update == "insert") {
        insert_stocks($stock);
        
        } elseif($insert_or_update == "update") {
            update_stocks($stock);
        }
        
        
        header("Location: stocks.php");
               
    } elseif ($action == "delete" && $symbol != "") {
        
        $stock = new Stock($symbol, "", 0);
        
        delete_stocks($stock);
        header("Location: stocks.php");
        
    } elseif ($action != "") {
        $error_message = "Missing symbol, name, or current price";
        include 'views/error.php';
    }

    $stocks = list_stocks();
    include 'views/stocks.php';
    
    
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include 'views/error.php';
}

