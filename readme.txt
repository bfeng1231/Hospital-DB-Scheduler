Boris Feng	bbf5057
Matthew Ludwig  mal5971

All of the work submitted here was done by me/us and/or my partner (if applicable). I understand that if I/we submit work from other sources that I/we am subjecting myself/ourselves to academic integrity charges.

ORDER TO EXECUTE PROGRAM

1. Open terminal
2. mysql -h cse-cmpsc431 -u bbf5057 -p
3. import employee_final.csv
4. import needs_final.csv
5. import daysoffrequests_final.csv
//Commands to import these files are provided below, you may have to change the file locations
6. Open a new terminal
7. php mysql.php
//You may have to change the opendatabase function to work properly

COMMANDS TO IMPORT CSV FILES

LOAD DATA LOCAL INFILE '/home/ugrads/bbf5057/Documents/employee_final.csv' INTO TABLE Employees FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (FirstName, LastName, @HourlyWage, position, homephone, cellphone, FTorPT, ShiftPref, DeptCertification) SET HourlyWage = SUBSTR(@HourlyWage,2);

LOAD DATA LOCAL INFILE '/home/ugrads/bbf5057/Documents/needs_final.csv' INTO TABLE Needs FIELDS TERMINATED
BY ',' LINES TERMINATED BY '\n' (department, @date, shift, position, numrequested) SET date = STR_TO_DATE(@date, '%b %d %Y');

LOAD DATA LOCAL INFILE '/home/ugrads/bbf5057/Documents/daysoffrequests_final.csv' INTO TABLE DayOff FIELDS
TERMINATED BY ',' LINES TERMINATED BY '\n' (FirstName, LastName, @DateRequested) SET DateRequested =
STR_TO_DATE(@DateRequested, '%b %d %Y');

-------------------------------------------------------------------------------------------------------------------------------------------------------

REPORT OF UNFILLED NEEDS

SELECT * FROM Needs WHERE numrequested != 0;
+-------+------------+------------+----------+----------+--------------+
| reqid | department | date       | shift    | position | numrequested |
+-------+------------+------------+----------+----------+--------------+
|  4954 | ER         | 2018-12-31 | 11PM-7AM | SW       |            1 |
|  4955 | MORG       | 2018-12-31 | 11PM-7AM | RN       |            1 |
|  4967 | MORG       | 2019-01-01 | 11PM-7AM | RN       |            1 |
|  4973 | ER         | 2019-01-02 | 3PM-11PM | SW       |            1 |
|  4983 | ER         | 2019-01-03 | 3PM-11PM | SW       |            1 |
|  4988 | ER         | 2019-01-04 | 7AM-3PM  | PHLEB    |            1 |
|  4991 | ER         | 2019-01-04 | 3PM-11PM | PHLEB    |            1 |
|  5008 | ER         | 2019-01-06 | 7AM-3PM  | SW       |            1 |
|  5011 | ER         | 2019-01-06 | 3PM-11PM | SW       |            1 |
|  5028 | ER         | 2019-01-08 | 3PM-11PM | SW       |            1 |
|  5035 | ER         | 2019-01-09 | 7AM-3PM  | PHARM    |            1 |
|  5039 | ER         | 2019-01-09 | 11PM-7AM | PHLEB    |            1 |
|  5049 | ER         | 2019-01-10 | 11PM-7AM | SW       |            1 |
|  5063 | ER         | 2019-01-12 | 3PM-11PM | SW       |            1 |
|  5065 | ER         | 2019-01-12 | 11PM-7AM | PHLEB    |            1 |
|  5067 | ER         | 2019-01-12 | 11PM-7AM | SW       |            1 |
|  5071 | ER         | 2019-01-13 | 7AM-3PM  | SW       |            1 |
|  5073 | ER         | 2019-01-13 | 3PM-11PM | PHLEB    |            2 |
|  5074 | ER         | 2019-01-13 | 3PM-11PM | PHARM    |            1 |
|  5076 | ER         | 2019-01-13 | 11PM-7AM | PHLEB    |            1 |
|  5079 | MAT        | 2018-12-31 | 7AM-3PM  | PHLEB    |            1 |
|  5082 | MAT        | 2019-01-01 | 7AM-3PM  | PHARM    |            1 |
|  5084 | MAT        | 2019-01-01 | 7AM-3PM  | PHLEB    |            1 |
|  5086 | MAT        | 2019-01-01 | 7AM-3PM  | SW       |            1 |
|  5088 | MAT        | 2019-01-01 | 3PM-11PM | PHLEB    |            1 |
|  5090 | MAT        | 2019-01-01 | 3PM-11PM | SW       |            1 |
|  5101 | MAT        | 2019-01-02 | 11PM-7AM | PHLEB    |            1 |
|  5112 | MAT        | 2019-01-03 | 11PM-7AM | SW       |            1 |
|  5117 | MAT        | 2019-01-04 | 3PM-11PM | SW       |            1 |
|  5131 | MAT        | 2019-01-05 | 11PM-7AM | SW       |            1 |
|  5138 | MAT        | 2019-01-06 | 3PM-11PM | SW       |            1 |
|  5139 | MAT        | 2019-01-06 | 11PM-7AM | PHLEB    |            1 |
|  5142 | MAT        | 2019-01-06 | 11PM-7AM | SW       |            1 |
|  5147 | MAT        | 2019-01-07 | 3PM-11PM | PHLEB    |            2 |
|  5149 | MAT        | 2019-01-07 | 3PM-11PM | SW       |            1 |
|  5166 | MAT        | 2019-01-09 | 11PM-7AM | SW       |            1 |
|  5168 | MAT        | 2019-01-10 | 7AM-3PM  | SW       |            1 |
|  5175 | MAT        | 2019-01-11 | 7AM-3PM  | PHLEB    |            1 |
|  5176 | MAT        | 2019-01-11 | 7AM-3PM  | SW       |            1 |
|  5179 | MAT        | 2019-01-11 | 3PM-11PM | PHLEB    |            1 |
|  5183 | MAT        | 2019-01-11 | 11PM-7AM | PHLEB    |            1 |
|  5187 | MAT        | 2019-01-12 | 7AM-3PM  | PHLEB    |            1 |
|  5195 | MAT        | 2019-01-13 | 7AM-3PM  | PHLEB    |            1 |
|  5200 | MAT        | 2019-01-13 | 11PM-7AM | PHLEB    |            1 |
|  5202 | MAT        | 2019-01-13 | 11PM-7AM | SW       |            1 |
|  5211 | SUR        | 2018-12-31 | 11PM-7AM | SW       |            1 |
|  5222 | SUR        | 2019-01-01 | 11PM-7AM | PHLEB    |            1 |
|  5259 | SUR        | 2019-01-06 | 7AM-3PM  | SW       |            1 |
|  5263 | SUR        | 2019-01-06 | 11PM-7AM | SW       |            1 |
|  5266 | SUR        | 2019-01-07 | 7AM-3PM  | SW       |            1 |
|  5272 | SUR        | 2019-01-07 | 11PM-7AM | SW       |            1 |
|  5275 | SUR        | 2019-01-08 | 7AM-3PM  | SW       |            1 |
|  5291 | SUR        | 2019-01-10 | 7AM-3PM  | SW       |            1 |
|  5300 | SUR        | 2019-01-11 | 3PM-11PM | SW       |            1 |
|  5306 | SUR        | 2019-01-12 | 7AM-3PM  | PHLEB    |            1 |
|  5314 | SUR        | 2019-01-13 | 7AM-3PM  | PHARM    |            1 |
|  5318 | SUR        | 2019-01-13 | 3PM-11PM | PHLEB    |            1 |
|  5319 | SUR        | 2019-01-13 | 3PM-11PM | SW       |            1 |
|  5330 | OBS        | 2018-12-31 | 3PM-11PM | SW       |            1 |
|  5339 | OBS        | 2019-01-01 | 3PM-11PM | SW       |            1 |
|  5347 | OBS        | 2019-01-02 | 7AM-3PM  | SW       |            1 |
|  5356 | OBS        | 2019-01-03 | 7AM-3PM  | SW       |            1 |
|  5373 | OBS        | 2019-01-05 | 7AM-3PM  | SW       |            1 |
|  5380 | OBS        | 2019-01-05 | 11PM-7AM | SW       |            1 |
|  5392 | OBS        | 2019-01-07 | 7AM-3PM  | SW       |            1 |
|  5399 | OBS        | 2019-01-08 | 7AM-3PM  | SW       |            1 |
|  5406 | OBS        | 2019-01-08 | 11PM-7AM | SW       |            1 |
|  5427 | OBS        | 2019-01-11 | 3PM-11PM | SW       |            1 |
|  5438 | OBS        | 2019-01-12 | 3PM-11PM | SW       |            1 |
|  5450 | OBS        | 2019-01-13 | 11PM-7AM | SW       |            1 |
|  5453 | PED        | 2018-12-31 | 7AM-3PM  | PHARM    |            1 |
|  5458 | PED        | 2018-12-31 | 3PM-11PM | PHLEB    |            1 |
|  5479 | PED        | 2019-01-02 | 3PM-11PM | SW       |            1 |
|  5483 | PED        | 2019-01-02 | 11PM-7AM | XRAY     |            1 |
|  5493 | PED        | 2019-01-04 | 7AM-3PM  | SW       |            1 |
|  5495 | PED        | 2019-01-04 | 3PM-11PM | SW       |            1 |
|  5499 | PED        | 2019-01-04 | 11PM-7AM | SW       |            1 |
|  5513 | PED        | 2019-01-06 | 11PM-7AM | XRAY     |            1 |
|  5523 | PED        | 2019-01-07 | 11PM-7AM | SW       |            1 |
|  5540 | PED        | 2019-01-09 | 11PM-7AM | XRAY     |            1 |
|  5541 | PED        | 2019-01-09 | 11PM-7AM | SW       |            1 |
|  5546 | PED        | 2019-01-10 | 3PM-11PM | PHLEB    |            1 |
|  5549 | PED        | 2019-01-10 | 11PM-7AM | NA       |            2 |
|  5556 | PED        | 2019-01-11 | 7AM-3PM  | SW       |            1 |
|  5559 | PED        | 2019-01-11 | 3PM-11PM | NA       |            2 |
|  5563 | PED        | 2019-01-11 | 11PM-7AM | XRAY     |            1 |
|  5564 | PED        | 2019-01-12 | 7AM-3PM  | NA       |            1 |
|  5565 | PED        | 2019-01-12 | 7AM-3PM  | XRAY     |            1 |
|  5567 | PED        | 2019-01-12 | 7AM-3PM  | SW       |            1 |
|  5569 | PED        | 2019-01-12 | 3PM-11PM | NA       |            1 |
|  5570 | PED        | 2019-01-12 | 3PM-11PM | XRAY     |            1 |
|  5572 | PED        | 2019-01-12 | 11PM-7AM | NA       |            1 |
|  5573 | PED        | 2019-01-13 | 7AM-3PM  | RN       |            1 |
|  5574 | PED        | 2019-01-13 | 3PM-11PM | RN       |            2 |
|  5578 | PED        | 2019-01-13 | 3PM-11PM | SW       |            1 |
|  5579 | PED        | 2019-01-13 | 11PM-7AM | RN       |            2 |
|  5581 | PED        | 2019-01-13 | 11PM-7AM | PHLEB    |            1 |
|  5583 | ONC        | 2018-12-31 | 7AM-3PM  | PHLEB    |            2 |
|  5585 | ONC        | 2018-12-31 | 7AM-3PM  | SW       |            1 |
|  5592 | ONC        | 2018-12-31 | 11PM-7AM | PHLEB    |            2 |
|  5597 | ONC        | 2019-01-01 | 7AM-3PM  | SW       |            1 |
|  5605 | ONC        | 2019-01-02 | 3PM-11PM | PHLEB    |            2 |
|  5610 | ONC        | 2019-01-02 | 11PM-7AM | PHLEB    |            1 |
|  5614 | ONC        | 2019-01-03 | 7AM-3PM  | PHLEB    |            1 |
|  5618 | ONC        | 2019-01-03 | 11PM-7AM | LPN      |            2 |
|  5621 | ONC        | 2019-01-04 | 7AM-3PM  | PHLEB    |            1 |
|  5623 | ONC        | 2019-01-04 | 11PM-7AM | SW       |            1 |
|  5626 | ONC        | 2019-01-05 | 7AM-3PM  | PHLEB    |            2 |
|  5627 | ONC        | 2019-01-05 | 7AM-3PM  | SW       |            1 |
|  5629 | ONC        | 2019-01-05 | 3PM-11PM | PHLEB    |            1 |
|  5631 | ONC        | 2019-01-05 | 11PM-7AM | RN       |            1 |
|  5632 | ONC        | 2019-01-05 | 11PM-7AM | LPN      |            1 |
|  5637 | ONC        | 2019-01-06 | 7AM-3PM  | SW       |            1 |
|  5643 | ONC        | 2019-01-07 | 3PM-11PM | RN       |            4 |
|  5648 | ONC        | 2019-01-07 | 11PM-7AM | RN       |            6 |
|  5651 | ONC        | 2019-01-07 | 11PM-7AM | PHLEB    |            1 |
|  5653 | ONC        | 2019-01-07 | 11PM-7AM | SW       |            1 |
|  5657 | ONC        | 2019-01-08 | 3PM-11PM | RN       |            2 |
|  5660 | ONC        | 2019-01-08 | 11PM-7AM | RN       |            2 |
|  5670 | ONC        | 2019-01-09 | 11PM-7AM | RN       |            1 |
|  5673 | ONC        | 2019-01-10 | 7AM-3PM  | RN       |            2 |
|  5675 | ONC        | 2019-01-10 | 3PM-11PM | RN       |            4 |
|  5677 | ONC        | 2019-01-10 | 3PM-11PM | PHLEB    |            2 |
|  5678 | ONC        | 2019-01-10 | 11PM-7AM | RN       |            2 |
|  5680 | ONC        | 2019-01-11 | 7AM-3PM  | RN       |            3 |
|  5682 | ONC        | 2019-01-11 | 3PM-11PM | RN       |            4 |
|  5685 | ONC        | 2019-01-11 | 11PM-7AM | RN       |            4 |
|  5687 | ONC        | 2019-01-11 | 11PM-7AM | PHLEB    |            1 |
|  5688 | ONC        | 2019-01-12 | 7AM-3PM  | RN       |            1 |
|  5689 | ONC        | 2019-01-12 | 7AM-3PM  | LPN      |            2 |
|  5691 | ONC        | 2019-01-12 | 7AM-3PM  | SW       |            1 |
|  5692 | ONC        | 2019-01-12 | 3PM-11PM | LPN      |            1 |
|  5694 | ONC        | 2019-01-12 | 3PM-11PM | PHLEB    |            1 |
|  5695 | ONC        | 2019-01-12 | 11PM-7AM | RN       |            4 |
|  5697 | ONC        | 2019-01-12 | 11PM-7AM | SW       |            1 |
|  5698 | ONC        | 2019-01-13 | 7AM-3PM  | RN       |            4 |
|  5699 | ONC        | 2019-01-13 | 3PM-11PM | LPN      |            1 |
|  5702 | ONC        | 2019-01-13 | 3PM-11PM | SW       |            1 |
|  5703 | ONC        | 2019-01-13 | 11PM-7AM | RN       |            2 |
|  5704 | ONC        | 2019-01-13 | 11PM-7AM | LPN      |            1 |
|  5705 | ONC        | 2019-01-13 | 11PM-7AM | PHLEB    |            1 |
|  5713 | ICU        | 2018-12-31 | 11PM-7AM | SW       |            1 |
|  5718 | ICU        | 2019-01-01 | 11PM-7AM | SW       |            1 |
|  5725 | ICU        | 2019-01-02 | 3PM-11PM | SW       |            1 |
|  5732 | ICU        | 2019-01-03 | 3PM-11PM | RN       |            2 |
|  5735 | ICU        | 2019-01-03 | 11PM-7AM | RN       |            2 |
|  5740 | ICU        | 2019-01-04 | 11PM-7AM | SW       |            1 |
|  5745 | ICU        | 2019-01-05 | 3PM-11PM | RN       |            2 |
|  5749 | ICU        | 2019-01-05 | 3PM-11PM | SW       |            1 |
|  5750 | ICU        | 2019-01-05 | 11PM-7AM | RN       |            4 |
|  5751 | ICU        | 2019-01-05 | 11PM-7AM | LPN      |            1 |
|  5756 | ICU        | 2019-01-06 | 3PM-11PM | RN       |            2 |
|  5757 | ICU        | 2019-01-06 | 3PM-11PM | LPN      |            2 |
|  5759 | ICU        | 2019-01-06 | 11PM-7AM | RN       |            2 |
|  5760 | ICU        | 2019-01-06 | 11PM-7AM | LPN      |            2 |
|  5768 | ICU        | 2019-01-07 | 11PM-7AM | RN       |            1 |
|  5773 | ICU        | 2019-01-08 | 7AM-3PM  | SW       |            1 |
|  5774 | ICU        | 2019-01-08 | 3PM-11PM | RN       |            3 |
|  5777 | ICU        | 2019-01-08 | 11PM-7AM | LPN      |            2 |
|  5779 | ICU        | 2019-01-08 | 11PM-7AM | SW       |            1 |
|  5781 | ICU        | 2019-01-09 | 7AM-3PM  | SW       |            1 |
|  5787 | ICU        | 2019-01-10 | 7AM-3PM  | ULTRA    |            1 |
|  5788 | ICU        | 2019-01-10 | 3PM-11PM | RN       |            2 |
|  5789 | ICU        | 2019-01-10 | 3PM-11PM | LPN      |            1 |
|  5792 | ICU        | 2019-01-10 | 11PM-7AM | LPN      |            2 |
|  5794 | ICU        | 2019-01-11 | 7AM-3PM  | RN       |            2 |
|  5797 | ICU        | 2019-01-11 | 7AM-3PM  | SW       |            1 |
|  5798 | ICU        | 2019-01-11 | 3PM-11PM | RN       |            4 |
|  5799 | ICU        | 2019-01-11 | 3PM-11PM | LPN      |            1 |
|  5801 | ICU        | 2019-01-11 | 11PM-7AM | NA       |            1 |
|  5802 | ICU        | 2019-01-11 | 11PM-7AM | SW       |            1 |
|  5803 | ICU        | 2019-01-12 | 7AM-3PM  | LPN      |            1 |
|  5805 | ICU        | 2019-01-12 | 7AM-3PM  | SW       |            1 |
|  5806 | ICU        | 2019-01-12 | 3PM-11PM | RN       |            1 |
|  5808 | ICU        | 2019-01-12 | 3PM-11PM | SW       |            1 |
|  5809 | ICU        | 2019-01-12 | 11PM-7AM | RN       |            2 |
|  5810 | ICU        | 2019-01-12 | 11PM-7AM | NA       |            1 |
|  5812 | ICU        | 2019-01-13 | 7AM-3PM  | RN       |            4 |
|  5814 | ICU        | 2019-01-13 | 3PM-11PM | LPN      |            3 |
|  5816 | ICU        | 2019-01-13 | 11PM-7AM | RN       |            2 |
|  5817 | ICU        | 2019-01-13 | 11PM-7AM | NA       |            1 |
+-------+------------+------------+----------+----------+--------------+
181 rows in set (0.00 sec)

TOTAL NUMBER OF UNFILLED NEEDS: 181

-----------------------------------------------------------------------------------

RAW OUTPUT

cse-p204inst29.cse.psu.edu 61% php mysql.php
LOADING...
TOTAL SCHEDULE COSTS: $ 296602.64
AVERAGE EMPLOYEE HAPPINESS: 67.1%
NUMBER OF UNUSED SHIFTS: 117 full time and 43 part time
UTILIZATION: 100.00% FULL TIME, 79.17% PART TIME


