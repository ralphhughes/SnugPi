<?php
require_once 'database.php';

// Check I'm being run from command line else exit with error
if (php_sapi_name() !== "cli") {
    // Not in cli-mode
    //die('Access denied');
}

// Open database
$con = openDB();

// Read sensorPath from database
$sensorPath = getSensorPath($con);

// Read heaterRelayPin from database
$heaterRelayPin = getHeaterRelayPin($con);

// Open sensorPath and get current temperature
$currentTemp = getCurrentTemperature($sensorPath);

// Read database to get desired value
$desiredTemp = getDesiredTemperature($con);

if ($currentTemp > $desiredTemp) {
    // Turn off heaterRelayPin
    setOutputPinState($heaterRelayPin, 0);
} else {
    // Turn on heaterRelayPin
    setOutputPinState($heaterRelayPin, 1);
}

// Log current temperature to database
logTempToDatabase($con, $sensorPath, $currentTemp);

die();

function getSensorPath($con) {
    $desiredTempSQL="select value as value from config where key='primaryTempSensor';";
    $result = $con->query($desiredTempSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $row = $result->fetch();
    return $row['value'];
}

function getHeaterRelayPin($con) {
    $heaterRelayPinSQL = "select value as value from config where key='heaterRelayPin';";
    $result = $con->query($heaterRelayPinSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $row = $result->fetch();
    return $row['value'];
}

function getCurrentTemperature($sensorPath) {
    // Open resource file for thermometer
    $thermometer = fopen("/sys/bus/w1/devices/" . $sensorPath . "/w1_slave", "r");

    // Get the contents of the resource
    $thermometerReadings = fread($thermometer, filesize($sensorPath));

    // Close resource file for thermometer
    fclose($thermometer);

    //TODO: Check for CRC=YES on the first line
    
    // We're only interested in the 2nd line, and the value after the t= on the 2nd line
    preg_match("/t=(.+)/", preg_split("/\n/", $thermometerReadings)[1], $matches);
    $temperature = $matches[1] / 1000;

    // Output the temperature for debugging
    print "Temp: " . $temperature;
    
    return $temperature;
}

function getDesiredTemperature($con) {
    $desiredTempSQL="select value as value from current_state where key='desiredTemp';";
    $result = $con->query($desiredTempSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $row = $result->fetch();
    return $row['value'];
}

function setOutputPinState($heaterRelayPin, $newState) {
    // turn heaterRelayPin on or off
    $gpio_state = shell_exec("/usr/local/bin/gpio -g write " . $heaterRelayPin . " " . $newState); // Requires wiringPi installed
    echo $gpio_state;
}

function logTempToDatabase($con, $sensor, $temp) {
    $saveTempSQL = "insert into temp_log (timestamp, sensor, temperature) values (datetime(), '$sensor', $temp);";
    $con->exec($saveTempSQL);
}