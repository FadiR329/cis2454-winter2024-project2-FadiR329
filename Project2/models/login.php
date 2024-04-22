<?php

function login($email_address, $password) {
    global $db;

    $query = 'SELECT email_address, password_hash FROM users WHERE email_address = :email_address';

    $statement = $db->prepare($query);
    $statement->bindValue(":email_address", $email_address);

    $statement->execute();

    $user = $statement->fetch();
    $statement->closeCursor();
    
    if($user == NULL) {
        return false;
    }
    
    $password_hash = $user['password_hash'];
    
    return password_verify($password, $password_hash);

    
}

