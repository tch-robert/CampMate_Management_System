<?php
session_start();

unset($_SESSION["owner"]);

header("location: ../campground_owner/owner-signin.php");