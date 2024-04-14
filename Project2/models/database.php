<?php

//set up Data Source Name
$dsn = 'mysql:host=localhost;dbname=stock';

//set up username and password
$username = 'stockuser';
$password = 'test';

//create PDO object
 $db = new PDO($dsn, $username, $password);

