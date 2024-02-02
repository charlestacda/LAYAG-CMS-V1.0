<?php 

$connect = mysqli_connect('mysql.db.mdbgo.com', 'charlestacda_layag', 'L@Y@G1s0pen', 'charlestacda_layagdb');

if (mysqli_connect_errno()){
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}