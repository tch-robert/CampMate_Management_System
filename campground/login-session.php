<?php
session_start();

$_SESSION["owner"]=[
    "id"=> 2,
    "name"=>"May",
    "email"=>"123@com",
    "phone"=>"0988000",
];
var_dump($_SESSION["owner"])
?>