<?php
/**
 * Setting error log file to store errors
 */
ini_set("log_errors",TRUE);
$log_file="../tests/error.log";
ini_set("error_log",$log_file);

date_default_timezone_set("Asia/Kolkata");      //Setting default timezone
?>