<?php

function openDatabase()
{
	$DB_MAIN_HOST = "cse-cmpsc431";
	$DB_MAIN_NAME = "name";
	$DB_MAIN_USER = "user";
	$DB_MAIN_PASS = "pass";
	if ($connection = mysql_connect($DB_MAIN_HOST, $DB_MAIN_USER, $DB_MAIN_PASS))
		{
			if (!mysql_select_db ($DB_MAIN_NAME))
			{
				$msg = 'MySQL error #' . mysql_errno() . ": " . mysql_error();
				reportError($msg, __FILE__, __LINE__);
			}
		}
	else 
		{
			$msg = 'MySQL error #' . mysql_errno() . ": " . mysql_error(); 
			reportError($msg, __FILE__, __LINE__);
		}
}

function closeDatabase()
{
	mysql_close();
}


function executeCommand($query, $zeroOk = true)
{
	if (!($result = mysql_query($query)))
	{
		$msg = 'MySQL error #' . mysql_errno() . ": " . mysql_error();
		reportError($msg, __FILE__, __LINE__);
	}
	else if ((0 == mysql_affected_rows()) && (!$zeroOk))
	{
		$msg = 'Zero rows affected by command';
		reportError($msg, __FILE__, __LINE__);
	}
	else
	{
		; // everything is ok
	}
}


function terminate($empid) {

	$query = "UPDATE employees SET status = \"T\" WHERE empid = " . $empid;

	if (!($result = mysql_query($query)))
	{
		printf("Sorry! This employee was not properly terminated.");
		return false;
	}

	printf("Successfully terminated employee %s.\n", $empid);
	
	return true;
}

function getData() {

	$query = "select * from employees"; 

	if (!($result = mysql_query($query)))
	{
		$msg = 'MySQL error #' . mysql_errno() . ": " . mysql_error();
		reportError($msg, __FILE__, __LINE__);
	}
	else if (0 == mysql_num_rows($result))
	{
		printf("No data are available!\n");
		return "";
	}
	else
	{
		while ($row = mysql_fetch_array($result))
		{
			$lastname = $row["lastName"];
			$firstname = $row["firstName"];
			printf("%s %s\n", $lastname, $firstname);
		}
	}
}

function printResults($result) {
	while($row = mysql_fetch_row($result))
		{
			print_r($row);
		}
		mysql_free_result($result);
}


function weekend($DoW, $empid, $date) {
	if ($DoW == 1) {
		$query = "SELECT * FROM Schedule WHERE empid = '$empid' AND date = DATE_ADD($date, INTERVAL -1 DAY)";
		$result = mysql_query($query);
		$checkSaturday = mysql_fetch_row($result);
		if ($checkSaturday == false) {
			return false;
		}
		return true;
	}
	else {
		$query = "SELECT * FROM Schedule WHERE empid = '$empid' AND date = DATE_ADD($date, INTERVAL 1 DAY)";
		$result = mysql_query($query);
		$checkSunday = mysql_fetch_row($result);
		if ($checkSunday == false) {
			return false;
		}
		return true;
	}
}

function checkPreviousShift($empid, $date) {
	$query = "SELECT * FROM Schedule WHERE empid = '$empid' AND date = DATE_ADD($date, INTERVAL -1 DAY)";
	$result = mysql_query($query);
	$checkLastShift = mysql_fetch_row($result);
	if ($checkLastShift == false) {
		return false;
	}
	$LastShift = $checkNextShift[4];
	if ($LastShift == '11PM-7AM') {
		return true;
	}
	return false;
}

function checkNumShift($empid, $max) {
	$query = "SELECT COUNT(empid) FROM Schedule WHERE empid = '$empid';";
	$result = mysql_query($query);
	$checkCount = mysql_fetch_row($result);
	$count = $checkCount[0];
	if ($count == $max) {
		return true;
	}
	return false;
}

function scheduleSomeone($reqid, $dept, $date, $shift, $emptype, $numrequested, $DoW) {
	
	$query = "CREATE TRIGGER num_zero AFTER UPDATE ON Needs FOR EACH ROW DELETE FROM Needs WHERE numrequested = 0 )";
	mysql_query($query);
	
	$query = "SELECT * FROM Employees a WHERE FTorPT = 'FT' AND ShiftPref = '$shift' AND DeptCertification LIKE '%$dept%' AND position = '$emptype' AND a.empid NOT IN (SELECT empid FROM Schedule WHERE date = '$date') AND a.empid NOT IN (SELECT empid FROM Employees c, DayOff d WHERE DateRequested = '$date' AND c.LastName = d.LastName GROUP BY empid);
";
	$result = mysql_query($query);
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
   		 $rows[] = $row;
   		 $empid = $row[0];
   		 $test2 = false;
   		 $test3 = checkNumShift($empid, 10);
   		 if ($shift == '7AM-3PM') {
   		 	$test2 = checkPreviousShift($empid, $date);
   		 }			 
   		 
   		 if ($DoW == 1 || $DoW == 7) {
   		 	$test = weekend($DoW, $empid, $date); 
   		 	 		 		 	
   		 	if ($test == false && $test2 == false && $test3 == false) {
   				// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   			}

   		 }
   		 
   		 else {
   		 	if ($test2 == false && $test3 == false) {
   		 		// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   		 	}
   		 }
   	}
   	
   	$query = "SELECT * FROM Employees a WHERE FTorPT = 'FT' AND DeptCertification LIKE '%$dept%' AND position = '$emptype' AND a.empid NOT IN (SELECT empid FROM Schedule WHERE date = '$date') AND a.empid NOT IN (SELECT empid FROM Employees c, DayOff d WHERE DateRequested = '$date' AND c.LastName = d.LastName GROUP BY empid);
";
	$result = mysql_query($query);
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
   		 $rows[] = $row;
   		 $empid = $row[0];
   		 $test2 = false;
   		 $test3 = checkNumShift($empid, 10);
   		 if ($shift == '7AM-3PM') {
   		 	$test2 = checkPreviousShift($empid, $date);
   		 }			 
   		 
   		 if ($DoW == 1 || $DoW == 7) {
   		 	$test = weekend($DoW, $empid, $date); 
   		 	 		 		 	
   		 	if ($test == false && $test2 == false && $test3 == false) {
   				// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   			}

   		 }
   		 
   		 else {
   		 	if ($test2 == false && $test3 == false) {
   		 		// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   		 	}
   		 }
   	}
   	
   	//echo"There are no more available full time employees\n";
  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$query = "SELECT * FROM Employees a WHERE FTorPT = 'PT' AND ShiftPref = '$shift' AND DeptCertification LIKE '%$dept%' AND position = '$emptype' AND a.empid NOT IN (SELECT empid FROM Schedule WHERE date = '$date') AND a.empid NOT IN (SELECT empid FROM Employees c, DayOff d WHERE DateRequested = '$date' AND c.LastName = d.LastName GROUP BY empid);
";
	$result = mysql_query($query);
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
   		 $rows[] = $row;
   		 $empid = $row[0];
   		 $test2 = false;
   		 $test3 = checkNumShift($empid, 6);
   		 if ($shift == '7AM-3PM') {
   		 	$test2 = checkPreviousShift($empid, $date);
   		 }			 
   		 
   		 if ($DoW == 1 || $DoW == 7) {
   		 	$test = weekend($DoW, $empid, $date); 
   		 	 		 		 	
   		 	if ($test == false && $test2 == false && $test3 == false) {
   				// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   			}

   		 }
   		 
   		 else {
   		 	if ($test2 == false && $test3 == false) {
   		 		// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   		 	}
   		 }
   	}
   	
   	$query = "SELECT * FROM Employees a WHERE FTorPT = 'PT' AND DeptCertification LIKE '%$dept%' AND position = '$emptype' AND a.empid NOT IN (SELECT empid FROM Schedule WHERE date = '$date') AND a.empid NOT IN (SELECT empid FROM Employees c, DayOff d WHERE DateRequested = '$date' AND c.LastName = d.LastName GROUP BY empid);
";
	$result = mysql_query($query);
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
   		 $rows[] = $row;
   		 $empid = $row[0];
   		 $test2 = false;
   		 $test3 = checkNumShift($empid, 6);
   		 if ($shift == '7AM-3PM') {
   		 	$test2 = checkPreviousShift($empid, $date);
   		 }			 
   		 
   		 if ($DoW == 1 || $DoW == 7) {
   		 	$test = weekend($DoW, $empid, $date); 
   		 	 		 		 	
   		 	if ($test == false && $test2 == false && $test3 == false) {
   				// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   			}

   		 }
   		 
   		 else {
   		 	if ($test2 == false && $test3 == false) {
   		 		// schedule person
   		 		$query = "INSERT INTO Schedule VALUES ('$empid', '$dept', '$date', '$shift', '$emptype')";
				$result = mysql_query($query);
				//echo"Employee scheduled successfully\n";
				$query = "UPDATE Needs SET numrequested = numrequested - 1 WHERE reqid = '$reqid'";
				$result = mysql_query($query);
				//echo"Updated needs table\n";
   		 		return;
   		 	}
   		 }
   	}
	return -1;
}

function fillPositions() {
	$query = "SELECT *, DAYOFWEEK(date) FROM Needs WHERE numrequested != 0";
	$result = mysql_query($query);
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
		if ($result == false) {
			return;
		}
   		$rows[] = $row;
   		$reqid = $row[0];
		$dept = $row[1];
		$date = $row[2];
		$shift = $row[3];
		$emptype = $row[4];
		$numrequested = $row[5];
		$DoW = $row[6];
	
		for ($x = 0; $x < $numrequested; $x++) {
			$num = scheduleSomeone($reqid, $dept, $date, $shift, $emptype, $numrequested, $DoW);
			if ($num == -1) {
				break;
			}
		}
	}
}

$connection = openDatabase();
echo"LOADING...\n";
fillPositions();

$query = "SELECT ROUND(SUM(HourlyWage * num_shifts * 8), 2) as 'TOTAL COST' FROM ( SELECT HourlyWage, COUNT(b.empid) as 'num_shifts' FROM Employees a, Schedule b WHERE a.empid = b.empid GROUP BY b.empid)a";
$result = mysql_query($query);
$totalcost = mysql_fetch_row($result);
echo"TOTAL SCHEDULE COSTS: $ ".$totalcost[0]."\n";

$query = "CREATE VIEW TotalHappy AS SELECT c.empid, COUNT(c.empid) as 'happy_shifts' FROM Schedule c, Employees d WHERE d.empid = c.empid AND shift = ShiftPref GROUP BY c.empid";
$result = mysql_query($query);
$query = "CREATE VIEW TotalShifts AS SELECT a.empid, COUNT(a.empid) as 'total_shifts' FROM Schedule a, Employees b WHERE b.empid = a.empid GROUP BY a.empid";
$result = mysql_query($query);
$query = "SELECT ROUND((HTotal/COUNT(Employees.empid)*100), 1) as 'OVERALL HAPPINESS' FROM Employees, (SELECT SUM(happy_shifts/total_shifts)+(10*.5) as 'HTotal' FROM TotalShifts a, TotalHappy b WHERE a.empid = b.empid)a";
$result = mysql_query($query);
$happiness = mysql_fetch_row($result);
echo"AVERAGE EMPLOYEE HAPPINESS: ".$happiness[0]."%\n";

$query = "SELECT SUM(f) as 'FULL TIME UNUSED SHIFTS' FROM (SELECT 10-COUNT(b.empid) as 'f' FROM Employees a, Schedule b  WHERE a.empid = b.empid AND FTorPT = 'FT' GROUP BY b.empid HAving COUNT(b.empid)<10)a";
$result = mysql_query($query);
$unusedFT = mysql_fetch_row($result);
$query = "SELECT SUM(f) as 'PART TIME UNUSED SHIFTS' FROM (SELECT 6-COUNT(b.empid) as 'f' FROM Employees a, Schedule b  WHERE a.empid = b.empid AND FTorPT = 'PT' GROUP BY b.empid HAving COUNT(b.empid)<6)a";
$result = mysql_query($query);
$unusedPT = mysql_fetch_row($result);
echo"NUMBER OF UNUSED SHIFTS: ".$unusedFT[0]." full time and ".$unusedPT[0]." part time\n";



$query = "SELECT ROUND(SUM((num_scheduled/num_emp)*100), 2) as 'PERCENT UTILIZATION' FROM (SELECT COUNT(DISTINCT y.empid) AS 'num_scheduled' FROM Schedule x, Employees y WHERE x.empid = y.empid AND y.FTorPT = 'FT')c, (SELECT COUNT(a.empid) AS 'num_emp' FROM Employees a WHERE FTorPT = 'FT')d";
$result = mysql_query($query);
$ultFT = mysql_fetch_row($result);
$query = "SELECT ROUND(SUM((num_scheduled/num_emp)*100), 2) as 'PERCENT UTILIZATION' FROM (SELECT COUNT(DISTINCT y.empid) AS 'num_scheduled' FROM Schedule x, Employees y WHERE x.empid = y.empid AND y.FTorPT = 'PT')c, (SELECT COUNT(a.empid) AS 'num_emp' FROM Employees a WHERE FTorPT = 'PT')d";
$result = mysql_query($query);
$ultPT = mysql_fetch_row($result);
echo"UTILIZATION: ".$ultFT[0]."% FULL TIME, ".$ultPT[0]."% PART TIME\n";


closeDatabase();

?>

