<?php
session_start();
if(!isset($_SESSION["owner"])){
    header("location: pleaseLogin.php");
}
$owner_id = $_SESSION["owner"]["id"];

?>