<?php

class transactions {
    
}

function list_transaction() {
    global $db;

    $query = 'SELECT user_id, stock_id, quantity, price, timestamp, id FROM transaction';

    $statement = $db->prepare($query);

    $statement->execute();

    $transactions = $statement->fetchAll();
    $statement->closeCursor();
    
    return $transactions;
}
