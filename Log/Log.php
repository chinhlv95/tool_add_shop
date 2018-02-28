<?php

class Log
{

	public static function appendToLogFile($filepath, $message) {

		// Append to the log file
	  	$fp = @fopen($filepath, "a");
	    flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	public static function writeCreateFolderLog($commandLine) {

		$filepath = './logs/log-'.date("Y-m-d").'.txt';
		$message = '[' . date("Y-m-d h:i:s") . '] --> Execute command: ' . $commandLine . "\r\n";
		self::appendToLogFile($filepath, $message);
		return true;
	}

	public static function writeMajorLog($majorName) {

	  	// Get time of request
	  	if( ($time = $_SERVER['REQUEST_TIME']) == '') {
	    	$time = time();
	  	}

	 	 // Format the date and time
	  	$datetime 	= date("Y-m-d H:i:s", $time);
	  	$date 		= date("Y-m-d");

	  	$filepath = './logs/log-' . $date . '.php';
	  	$message  = '';

		if ( ! file_exists($filepath))
		{
			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

	 	$message .= '[' . $datetime . '] --> ['. $majorName . ']' ."\n";

	  	self::appendToLogFile($filepath, $message);
		return true;
	}

	public static function writeQueryLog($function, $data) {

		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
	  	// Get time of request
	  	if( ($time = $_SERVER['REQUEST_TIME']) == '') {
	    	$time = time();
	  	}
	 
	 	 // Format the date and time
	  	$datetime 	= date("Y-m-d H:i:s", $time);
	  	$date 		= date("Y-m-d");

	  	$filepath = './logs/log-' . $date . '.php';
	  	$message  = '';

		if ( ! file_exists($filepath))
		{
			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

	 	$message .= '------------------------> '. $function . ' ' . $data . "\n";

	  	self::appendToLogFile($filepath, $message);
		return true;
	}
}
