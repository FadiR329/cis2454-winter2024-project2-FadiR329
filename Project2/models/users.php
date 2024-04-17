<?php

class User {
    
    private $name, $email_address, $cash_balance, $id;
    
    public function __construct($name, $email_address, $cash_balance, $id = 0) {
        $this->name = $name;
        $this->email_address = $email_address;
        $this->cash_balance = $cash_balance;
        $this->id = $id;      
    }
    
    public function get_name() {
        return $this->name;
    }

    public function get_email_address() {
        return $this->email_address;
    }

    public function get_cash_balance() {
        return $this->cash_balance;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_email_address($email_address) {
        $this->email_address = $email_address;
    }

    public function set_cash_balance($cash_balance) {
        $this->cash_balance = $cash_balance;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    
}

function list_user() {
    global $db;

    $query = 'SELECT name, email_address, cash_balance, id FROM users';

    $statement = $db->prepare($query);

    $statement->execute();

    $users = $statement->fetchAll();
    $statement->closeCursor();
    
    $users_array = [];
    
    foreach ($users as $user) {
        $users_array[] = new User($user['name'], $user['email_address'], $user['cash_balance'], $user['id']);
    }

    return $users_array;
}

function insert_user($user) {
    global $db;

    $query = "INSERT INTO users (name, email_address, cash_balance) VALUES (:name, :email_address, :cash_balance)";

    //prepare the query
    $statement = $db->prepare($query);
    $statement->bindValue(":name", $user->get_name());
    $statement->bindValue(":email_address", $user->get_email_address());
    $statement->bindValue(":cash_balance", $user->get_cash_balance());

    //run the query
    $statement->execute();
    $statement->closeCursor();

    echo "Row inserted successfully";
}

function update_user($user) {
    global $db;

    //create the query
    $query = "UPDATE users SET name = :name, cash_balance = :cash_balance WHERE email_address = :email_address";

    //prepare the query
    $statement = $db->prepare($query);
    $statement->bindValue(":name", $user->get_name());
    $statement->bindValue(":email_address", $user->get_email_address());
    $statement->bindValue(":cash_balance", $user->get_cash_balance());

    //run the query
    $statement->execute();
    $statement->closeCursor();

    echo "Row updated successfully";
}

function delete_user($user) {
    global $db;

    //create the query
    $query = "DELETE FROM users WHERE email_address = :email_address";

    //prepare the query
    $statement = $db->prepare($query);
    $statement->bindValue(":email_address", $user->get_email_address());

    //run the query
    $statement->execute();
    $statement->closeCursor();

    echo "Row deleted successfully";
}
