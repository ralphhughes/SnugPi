<?php
error_reporting(-1);
function openDB() {
    try{    
        //open the database
        $con = new PDO('sqlite:SnugPi.sqlite');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check the tables we expect actually exist, if not then re-create the default database
        $checkSchemaSQL = "SELECT count(name) as num FROM sqlite_master WHERE type='table' AND name in ('config','current_state','schedule','temp_log');";
        $result = $con->query($checkSchemaSQL);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        if ($row['num'] != 4) { // The number of tables we expect if they are all found
            echo ("Recreating default database...\r\n");
            dropAllTables($con);
            createSchemaTables($con);
            insertDefaultConfig($con);
            echo ("Done.\r\n");
        }
        
    } catch(PDOException $e) {
        die ("Error " . $e->getMessage());
    }
    return $con;
}

function dropAllTables($con) {
    $dropTablesSQL="drop table if exists config;
            drop table if exists current_state;
            drop table if exists schedule;
            drop table if exists temp_log";
    echo($dropTablesSQL . "\r\n");
    $con->exec($dropTablesSQL);    
}
function createSchemaTables($con) {
    // Config table
    $createConfigTableSQL = "create table if not exists config (
            key string(255) not null primary key,
            value string (4096) null
        );";
    echo($createConfigTableSQL . "\r\n");
    $con->exec($createConfigTableSQL);

    $createCurrentStateTableSQL = "create table if not exists current_state (
                key string(255) not null primary key,
                value string (4096) null
        );";
    echo($createCurrentStateTableSQL . "\r\n");
    $con->exec($createCurrentStateTableSQL);
    
    $createScheduleTableSQL="create table if not exists schedule (
            id integer primary key autoincrement,
            dayOfWeek integer not null,         -- 1=Mon, 2=Tue, 3=Wed, 4=Thu, 5=Fri, 6=Sat, 0=Sun
            startTime integer not null,         --minutes since midnight
            endTime integer not null,           --minutes since midnight
            desiredTemp real not null,          --degrees C
            isTemporaryBoost integer default 0	--1 or 0 for true or false
        );";
    echo($createScheduleTableSQL . "\r\n");
    $con->exec($createScheduleTableSQL);
    
    $createTempLogTableSQL = "create table if not exists temp_log (
            id integer primary key autoincrement,
            timestamp string not null,	--ISO8601
            sensor string not null,	--InsideTemp, [OutsideTemp, DesiredTemp]
            temperature real not null	--degrees C
        );";
    echo($createTempLogTableSQL . "\r\n");
    $con->exec($createTempLogTableSQL);
}

function insertDefaultConfig($con) {
    $insertDefaultConfigSQL = "insert into config (key, value) values ('setbackTemp','12.5');
        insert into config (key, value) values ('occupiedTemp','19.0');
        insert into config (key, value) values ('heaterRelayPin','4');
        insert into config (key, value) values ('primaryTempSensor','28-00cd45e');";
    echo($insertDefaultConfigSQL . "\r\n");
    $con->exec($insertDefaultConfigSQL);


    $insertDefaultStateSQL = "insert into current_state (key, value) values ('desiredTemp',17);";
    echo($insertDefaultStateSQL . "\r\n");
    $con->exec($insertDefaultStateSQL);
    
    $insertDefaultScheduleSQL = "
        insert into schedule (dayOfWeek, startTime, endTime, desiredTemp) values (0,700,800,15.0);
        insert into schedule (dayOfWeek, startTime, endTime, desiredTemp) values (1,700,800,16.0);
        insert into schedule (dayOfWeek, startTime, endTime, desiredTemp) values (2,1000,1200,19.0);
        insert into schedule (dayOfWeek, startTime, endTime, desiredTemp) values (5,700,800,15.5);
        insert into schedule (dayOfWeek, startTime, endTime, desiredTemp) values (5,800,900,16.5);";
    echo($insertDefaultScheduleSQL . "\r\n");
    $con->exec($insertDefaultScheduleSQL);
    

}


//--------------------------------------------

function getSetbackTemp($con) {
    $heaterRelayPinSQL = "select value as value from config where key='setbackTemp';";
    $result = $con->query($heaterRelayPinSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $row = $result->fetch();
    return $row['value'];
}


function getCurrentDayOfWeek() {
    return date('w');
}
