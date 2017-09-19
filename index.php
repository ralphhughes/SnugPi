<?php
// Simple GUI for testing
require_once 'database.php';

// Open database
$con = openDB();

include 'guiHeader.php';

$dayOfWeek = getCurrentDayOfWeek();

$arrSchedule = getScheduleRowsFor($con, $dayOfWeek);
printScheduleToJSArray($con, $arrSchedule);

printSchedule($con);

printFooter();

die();


function printFooter() {
    $footer="</body>
</html>";
    echo $footer;     
}

function printScheduleToJSArray($con, $arrSchedule) {
    $setbackTemp = getSetbackTemp($con);
    echo("<script>\r\n");
    echo("var scheduled_temps = [\r\n");
    echo("[timeToMillis(0,0), $setbackTemp],\r\n");
    for ($i = 0; $i < count($arrSchedule); $i++) {
        $startTime = $arrSchedule[$i]['startTime'];
        $startHour = floor($startTime / 60);
        $startMin = ($startTime % 60);
        
        $endTime = $arrSchedule[$i]['endTime'];
        $endHour = floor($endTime / 60);
        $endMin = ($endTime % 60);
        
        $desiredTemp = $arrSchedule[$i]['desiredTemp'];
        
        // setbackTemp up to desiredTemp at start of period
        echo("[timeToMillis($startHour, $startMin), $setbackTemp],\r\n");
        echo("[timeToMillis($startHour, $startMin)+1, $desiredTemp],\r\n");
        
        // Desired temp back down to setbackTemp at the end of time period
        echo("[timeToMillis($endHour, $endMin), $desiredTemp],\r\n");
        echo("[timeToMillis($endHour, $endMin)+1, $setbackTemp],\r\n");
    }
    echo("[timeToMillis(23,59), $setbackTemp],\r\n");
    echo("];\r\n");
    echo ("</script>\r\n");
}

function getScheduleRowsFor($con, $dayOfWeek) {
    $fetchScheduleSQL = "select * from schedule where dayOfWeek = $dayOfWeek order by startTime";
    $result = $con->query($fetchScheduleSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    
    $arrSchedule = array();
    $i=0;
    while($row = $result->fetch()){
        $dayOfWeek = $row['dayOfWeek'];
        $startTime = $row['startTime'];
        $endTime = $row['endTime'];
        $desiredTemp = $row['desiredTemp'];
        
        $arrSchedule[$i]['dayOfWeek'] = $dayOfWeek;
        $arrSchedule[$i]['startTime'] = $startTime;
        $arrSchedule[$i]['endTime'] = $endTime;
        $arrSchedule[$i]['desiredTemp'] = $desiredTemp;
        
        $i++;
    }
    return $arrSchedule;
}
function printSchedule($con) {
    $fetchScheduleSQL = "select * from schedule order by dayOfWeek, startTime";
    $result = $con->query($fetchScheduleSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    echo('<table border="0">');
    echo("<tr><td>dayOfWeek</td><td>startTime</td><td>endTime</td><td>desiredTemp</td></tr>");
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