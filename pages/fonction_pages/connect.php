<?php
function connect() {
    
    $host="localhost";
    $dbname="reservation_terrain";
    $username="root";
    $password="";
$conn = new mysqli($host, $username, $password, $dbname);

}
?>