<?php
session_start();
if(!isset($_SESSION["owner"])){
    header("location: ../campground_owner/owner-signin.php");
}
$owner_id = $_SESSION["owner"]["id"];

?>