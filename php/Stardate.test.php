<?php
	/**
	* PHP Stardate Class Unit Tests
	* 
	* Copyright (c) 2023, Scott Vander Molen; some rights reserved.
	* 
	* This work is licensed under a Creative Commons Attribution 4.0 International License.
	* To view a copy of this license, visit https://creativecommons.org/licenses/by/4.0/
	* 
	* @author  Scott Vander Molen
	* @version 2.0
	* @since   2023-12-30
	*/
	
	// Change debugmode to true if you need to see error messages.
	$debugmode = true;
	if ($debugmode)
	{
		// Allow the display of errors during debugging.
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}
	
	echo "<pre>";
	echo "/***************************************************************************************\\\n";
	echo "| PHP Stardate Class Unit Tests                                                         |\n";
	echo "|                                                                                       |\n";
	echo "| Copyright (c) 2023, Scott Vander Molen; some rights reserved.                         |\n";
	echo "|                                                                                       |\n";
	echo "| This work is licensed under a Creative Commons Attribution 4.0 International License. |\n";
	echo "| To view a copy of this license, visit https://creativecommons.org/licenses/by/4.0/    |\n";
	echo "|                                                                                       |\n";
	echo "\***************************************************************************************/\n";
	echo "</pre>";

	include 'Stardate.class.php';
	use ScottVM\Stardate as Stardate;
	
	if (!class_exists('ScottVM\Stardate'))
	{
		die('Could not find Stardate class! Did you set the path correctly?');
	}
	
	/*
	* Creates a stardate from a numeric value.
	* 
	* @param input The desired value of the stardate.
	* @param expected The expected earth date.
	* @return boolean Whether the result matched the expectation.
	*/
	function testStardateNumeric($input, $expected)
	{
		$testStardate = new Stardate();
		$testStardate->set_value($input);
		
		$actual = $testStardate->get_value_earthdate();
		$result = $actual == $expected;
		
		echo "Unit Test: get_value_earthdate()\n";
		echo "Input:     " . $input . "\n";
		echo "Expected:  " . date_format($expected, "Y-m-d h:i:s A") . "\n";
		echo "Actual:    " . date_format($actual, "Y-m-d h:i:s A") . "\n";
		echo "Result:    Test " . ($result ? "successful" : "failed") . "!\n\n";
		
		return $result;
	}
	
	/*
	* Creates a Stardate from a date value.
	* 
	* @param input The Gregorian date to be converted to a stardate.
	* @param expected The expected stardate.
	* @return boolean Whether the result matched the expectation.
	*/
	function testStardateGregorian($input, $expected)
	{
		$testStardate = new Stardate();
		$testStardate->set_value($input);
		
		$actual = $testStardate->get_value_stardate();
		$result = $actual == $expected;
		
		echo "Unit Test: get_value_stardate()\n";
		echo "Input:     " . date_format($input, "Y-m-d h:i:s A") . "\n";
		echo "Expected:  " . $expected . "\n";
		echo "Actual:    " . $actual . "\n";
		echo "Result:    Test " . ($result ? "successful" : "failed") . "!\n\n";
		
		return $result;
	}
	
	echo "<pre>";
	$test1 = testStardateNumeric(1312.4, date_create("2265-10-23 21:45:38"));
	$test2 = testStardateGregorian(date_create("2265-10-23 21:45:38"), 1312.4);
	$test3 = testStardateNumeric(40759.5, date_create("2362-11-23 18:40:35"));
	$test4 = testStardateGregorian(date_create("2362-11-23 18:40:35"), 40759.5);
	echo "</pre>";
?>