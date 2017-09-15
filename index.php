<?php
// Simple GUI for testing
require_once 'database.php';

// Open database
$con = openDB();

include 'guiHeader.php';

$schedule = getScheduleRows($con);

printFooter();

die();


function printFooter() {
    $footer="</body>
</html>";
    echo$footer;     
}


function getScheduleRows($con) {
    $fetchScheduleSQL = "select * from schedule order by dayOfWeek, startTime";
    $result = $con->query($fetchScheduleSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    echo("<table>");
    while($row = $result->fetch()){
        $dayOfWeek = $row['dayOfWeek'];
        $startTime = $row['startTime'];
        $endTime = $row['endTime'];
        $desiredTemp = $row['desiredTemp'];
        
        $strDayOfWeek = date('D', strtotime("Sunday +{$dayOfWeek} days")); // Converts day numbers to day names
        $strStartTime = convertToHoursMins($startTime);
        $strEndTime = convertToHoursMins($endTime);
        echo("<tr><td>$strDayOfWeek</td><td>$strStartTime</td><td>$strEndTime</td><td>$desiredTemp</td></tr>\r\n");
    }
    echo("</table>");
}

function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}