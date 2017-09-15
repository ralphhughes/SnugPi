@echo off
rem Executes thermostat.php every 10 minutes
rem Executes scheduler.php every minute
set /a i=0

:loop
if %i% lss 10 (
	time /t
	set /a i+=1
	echo Executing scheduler.php ...
	php -f scheduler.php
	timeout /t 60
	goto loop
)
set /a i=0
echo Executing thermostat.php ...
php -f thermostat.php
goto loop