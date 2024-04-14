<?php

class Stock {

    private $symbol, $name, $current_price, $id;

    public function __construct($symbol, $name, $current_price, $id = 0) {
        $this->set_symbol($symbol);
        $this->set_name($name);
        $this->set_current_price($current_price);
        $this->set_id($id);
    }

    public function set_symbol($symbol) {
        $this->symbol = $symbol;
    }

    public function get_symbol() {
        return $this->symbol;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_current_price() {
        return $this->current_price;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_current_price($current_price) {
        $this->current_price = $current_price;
    }

    public function set_id($id) {
        $this->id = $id;
    }
}

function list_stocks() {
    global $db;

    //create the query for stocks
    $query = 'SELECT symbol, name, current_price, id FROM stocks';

    //prepare the query
    $statement = $db->prepare($query);

    //run the query
    $statement->execute();

    //fetch the data
    $stocks = $statement->fetchAll();
    $statement->closeCursor();

    $stocks_array = array();

    foreach ($stocks as $stock) {
        $stocks_array[] = new Stock($stock['symbol'], $stock['name'], $stock['current_price'], $stock['id']);
        
    }

    return $stocks_array;
}

function insert_stocks($stock) {
    global $db;

    //create the query
    $query = "INSERT INTO stocks (symbol, name, current_price) VALUES (:symbol, :name, :current_price)";

    //prepare the query
    $statement = $db->prepare($query);
    $statement->bindValue(":symbol", $stock->get_symbol());
    $statement->bindValue(":name", $stock->get_name());
    $statement->bindValue(":current_price", $stock->get_current_price());

    //run the query
    $statement->execute();
    $statement->closeCursor();

    echo "<b>Row inserted successfully!</b></br>";
}

function update_stocks($stock) {
    global $db;

    //create the query
    $query = "UPDATE stocks SET name = :name, current_price = :current_price WHERE symbol = :symbol";

    //prepare the query
    $statement = $db->prepare($query);
    $statement->bindValue(":symbol", $stock->get_symbol());
    $statement->bindValue(":name", $stock->get_name());
    $statement->bindValue(":current_price", $stock->get_current_price());

    //run the query
    $statement->execute();
    $statement->closeCursor();

    echo "<b>Row updated successfully!</b></br>";
}

function delete_stocks($stock) {
    global $db;

    //create the query
    $query = "DELETE FROM stocks WHERE symbol = :symbol";

    //prepare the query
    $statement = $db->prepare($query);
    $statement->bindValue(":symbol", $stock->get_symbol());

    //run the query
    $statement->execute();
    $statement->closeCursor();

    echo "<b>Row deleted successfully!</b></br>";
}
