<?php
//   Reads schedule table in SQLite and sets currentState.desiredTemp value based on it
require_once 'database.php';

// Check I'm being run from command line else exit with error
if (php_sapi_name() !== "cli") {
    // Not in cli-mode
    //die('Access denied');
}

// Open database
$con = openDB();


// get the current day of week (day number integer as 0-6)
$dayOfWeek = getCurrentDayOfWeek();
echo "dayofweek: " . $dayOfWeek . "\r\n";

// get the current time of day (minutes since midnight)
$timeOfDay = getCurrentTimeOfDay();
echo "time of day: " . $timeOfDay . "\r\n";

// get the corresponding row in the schedule table for right now
$desiredTemp = getDesiredTempFor($con, $dayOfWeek, $timeOfDay);

$setbackTemp = getSetbackTemp($con);
if (is_null($setbackTemp)) {
    die("ERROR: Missing config value: 'setbackTemp'");
}

if (is_null($desiredTemp)) {
    $desiredTemp = $setbackTemp;
}
echo "desiredTemp: " . $desiredTemp . "\r\n";
setDesiredTemp($con, $desiredTemp);

// delete any schedule rows where isTemporaryBoost is true and time is earlier than now
deleteTodaysExpiredBoostSchedules($con, $dayOfWeek, $timeOfDay);

function deleteTodaysExpiredBoostSchedules($con, $dayOfWeek, $timeOfDay) {
    //TODO: finish coding this
    $findExpiredSchedulesSQL = "select * from schedule where dayOfWeek = " . $dayOfWeek
            . " and endTime < " . $timeOfDay
            . " and isTemporaryBoost = 1;";
    
}


function getCurrentTimeOfDay() {
    return (int)((time() - strtotime("today")) / 60);
}


function getDesiredTempFor($con, $dayOfWeek, $timeOfDay) {
    $getScheduleSQL = "select max(desiredTemp) as desiredTemp from schedule where dayOfWeek='". $dayOfWeek 
            . "' and startTime <= '" . $timeOfDay 
            . "' and endTime > '" . $timeOfDay . "';";
    $result = $con->query($getScheduleSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $row = $result->fetch();
    return $row['desiredTemp'];
}

function setDesiredTemp($con, $desiredTemp) {
    $desiredTempSQL = "insert or replace into current_state (key, value) values ('desiredTemp', " . $desiredTemp . ");";
    echo("desiredTempSQL: " . $desiredTempSQL);
    $con->exec($desiredTempSQL);
}