<?php
require_once 'database.php';

// Open database
$con = openDB();

// TODO: login cookie check

// API (POST variables only)
if (!isset($_GET['action'])) {
    die("ERROR: Missing variable");
} else {
    // Test only, remove in production!
    echo('<pre>');
    var_dump($_POST);
    
    $action = filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING);
    if ($action === "add") {
        $dayOfWeek = filter_input(INPUT_POST, 'dayOfWeek', FILTER_SANITIZE_NUMBER_INT);
        $startTime = filter_input(INPUT_POST, 'startTime', FILTER_SANITIZE_NUMBER_INT);
        $endTime = filter_input(INPUT_POST, 'endTime', FILTER_SANITIZE_NUMBER_INT);
        $desiredTemp = filter_input(INPUT_POST, 'desiredTemp', FILTER_SANITIZE_NUMBER_FLOAT);
        $isTemporaryBoost = filter_input(INPUT_POST, 'isTemporaryBoost', FILTER_SANITIZE_NUMBER_INT);
        
        $stmt = $con->prepare("insert into schedule (dayOfWeek, startTime, endTime, desiredTemp, isTemporaryBoost"
                                       . ") values (:dayOfWeek,:startTime,:endTime,:desiredTemp,:isTemporaryBoost);");
        $stmt->bindParam(':dayOfWeek', $dayOfWeek);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        $stmt->bindParam(':desiredTemp', $desiredTemp);
        $stmt->bindParam(':isTemporaryBoost', $isTemporaryBoost);
        $stmt->execute();
        
        echo ("Added Successfully.");
    } elseif ($action === "edit") {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        
        $dayOfWeek = filter_input(INPUT_POST, 'dayOfWeek', FILTER_SANITIZE_NUMBER_INT);
        $startTime = filter_input(INPUT_POST, 'startTime', FILTER_SANITIZE_NUMBER_INT);
        $endTime = filter_input(INPUT_POST, 'endTime', FILTER_SANITIZE_NUMBER_INT);
        $desiredTemp = filter_input(INPUT_POST, 'desiredTemp', FILTER_SANITIZE_NUMBER_FLOAT);
        $isTemporaryBoost = filter_input(INPUT_POST, 'isTemporaryBoost', FILTER_SANITIZE_NUMBER_INT);
        
        
        //TODO: Needs coding
    } elseif ($action === "delete") {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $stmt->prepare("delete from schedule where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}