<?php
/*
Performing DB Connection using user "root" and password ""
*/

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'placement');

// Establishing connection with the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Checking the connection
if($conn == false){
    dir('Connection not possible');
}

?>