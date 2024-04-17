<?php

class Transaction {
    
    private $user_id, $stock_id, $quantity, $price, $timestamp, $id;
    
    public function __construct($user_id, $stock_id, $quantity, $price = 0, $timestamp = 0, $id = 0) {
        $this->user_id = $user_id;
        $this->stock_id = $stock_id;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->timestamp = $timestamp;
        $this->id = $id;
    }
    
    public function get_user_id() {
        return $this->user_id;
    }

    public function get_stock_id() {
        return $this->stock_id;
    }

    public function get_quantity() {
        return $this->quantity;
    }

    public function get_price() {
        return $this->price;
    }

    public function get_timestamp() {
        return $this->timestamp;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_user_id($user_id) {
        $this->user_id = $user_id;
    }

    public function set_stock_id($stock_id) {
        $this->stock_id = $stock_id;
    }

    public function set_quantity($quantity) {
        $this->quantity = $quantity;
    }

    public function set_price($price) {
        $this->price = $price;
    }

    public function set_timestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function set_id($id) {
        $this->id = $id;
    }



}

function list_transaction() {
    global $db;

    $query = 'SELECT user_id, stock_id, quantity, price, timestamp, id FROM transaction';

    $statement = $db->prepare($query);

    $statement->execute();

    $transactions = $statement->fetchAll();
    $statement->closeCursor();
    
    $transactions_array = [];
    
    foreach($transactions as $transaction) {
        $transactions_array[] = new Transaction($transaction['user_id'], $transaction['stock_id'], $transaction['quantity'],
                $transaction['price'], $transaction['timestamp'], $transaction['id']);
    }

    return $transactions_array;
}

function insert_transaction($transaction, $symbol) {
    global $db;

    $query = 'SELECT current_price, id FROM stocks WHERE symbol = :symbol';

    $statement = $db->prepare($query);
    $statement->bindValue(":symbol", $symbol);

    //run the query
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $price = $result['current_price'];
    $stock_id = $result['id'];

    $stock_amount = $price * $transaction->get_quantity();

    $statement->closeCursor();

    //query the users table
    $query2 = 'SELECT cash_balance FROM users WHERE id = :id';

    //prepare query
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":id", $transaction->get_user_id());

    //run query
    $statement2->execute();
    $cash_amount = $statement2->fetchColumn();

    if ($cash_amount >= $stock_amount) {
        //insert row
        $query = 'INSERT INTO transaction (user_id, stock_id, quantity, price) VALUES (:user_id, :stock_id, :quantity, :price)';

        $statement = $db->prepare($query);
        $statement->bindValue(":user_id", $transaction->get_user_id());
        $statement->bindValue(":stock_id", $stock_id);
        $statement->bindValue(":quantity", $transaction->get_quantity());
        $statement->bindValue(":price", $price);

        $statement->execute();
        $statement->closeCursor();

        //update user
        $new_balance = $cash_amount - $stock_amount;

        $query2 = 'UPDATE users SET cash_balance = :cash_balance WHERE id = :id';

        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":cash_balance", $new_balance);
        $statement2->bindValue(":id", $transaction->get_user_id());

        $statement2->execute();
        $statement2->closeCursor();
    } else {
        echo "Error: Insufficient funds.";
    }
}

function update_transaction($transaction, $symbol) {
    global $db;

    $query = 'SELECT current_price, id FROM stocks WHERE symbol = :symbol';

    $statement = $db->prepare($query);
    $statement->bindValue(":symbol", $symbol);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $price = $result['current_price'];
    $stock_id = $result['id'];
    $statement->closeCursor();

    $query2 = 'UPDATE transaction SET quantity = :quantity, price = :price '
            . 'WHERE user_id = :user_id AND stock_id = :stock_id';

    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":quantity", $transaction->get_quantity());
    $statement2->bindValue(":price", $price);
    $statement2->bindValue(":user_id", $transaction->get_user_id());
    $statement2->bindValue(":stock_id", $stock_id);
    
    $statement2->execute();
    $statement2->closeCursor();
}

function delete_transaction($transaction) {
    global $db;
    
     //query transactions table
    $query2 = 'SELECT quantity FROM transaction WHERE user_id = :user_id AND stock_id = :stock_id';
    
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":user_id", $transaction->get_user_id());
    $statement2->bindValue(":stock_id", $transaction->get_stock_id());
    
    $statement2->execute();
    $quantity = $statement2->fetchColumn();
    $statement2->closeCursor();
    
    //query stocks table
    $query3 = 'SELECT current_price FROM stocks WHERE id = :id';
    
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":id", $transaction->get_stock_id());
    
    $statement3->execute();
    $current_price = $statement3->fetchColumn();
    $statement3->closeCursor();
    
    $new_balance = $quantity * $current_price;
    
    //update users table
    $query4 = 'UPDATE users SET cash_balance = :cash_balance WHERE id = :id';
    
    $statement4 = $db->prepare($query4);
    $statement4->bindValue(":cash_balance", $new_balance);
    $statement4->bindValue(":id", $transaction->get_user_id());
    
    $statement4->execute();
    $statement4->closeCursor();
    
    $query = 'DELETE FROM transaction WHERE user_id = :user_id AND stock_id = :stock_id';
    
    $statement = $db->prepare($query);
    $statement->bindValue(":user_id", $transaction->get_user_id());
    $statement->bindValue(":stock_id", $transaction->get_stock_id());
    
    $statement->execute();
    $statement->closeCursor();
    
   
}
