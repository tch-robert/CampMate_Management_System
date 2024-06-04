<?php
$sqlOwner = "SELECT * FROM campground_owner WHERE id = $owner_id";
$resultOwner = $conn->query($sqlOwner);
$rowOwner = $resultOwner->fetch_assoc();

?>

<div class="title d-flex justify-content-between align-items-center">
    <div class="d-flex ms-3">
        <i class="fa-solid fa-tower-observation m-1"></i>
        <h5>Campground Management System</h5>
    </div>
    <div class="me-3">
    <a href="session-unset.php" class="btn btn-warning">Log Out</a>
    </div>
    
</div>
