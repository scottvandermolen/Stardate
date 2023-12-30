<?php
	namespace ScottVM; 
	
	/**
	* PHP Stardate Class
	* 
	* Copyright (c) 2023, Scott Vander Molen; some rights reserved.
	* 
	* This work is licensed under a Creative Commons Attribution 4.0 International License.
	* To view a copy of this license, visit https://creativecommons.org/licenses/by/4.0/
	* 
	* @author  Scott Vander Molen
	* @version 2.0
	* @since   2023-12-30
	*
	* http://TrekGuide.com/Stardates.htm
	*/
	
	// Change debugmode to true if you need to see error messages.
	$debugmode = true;
	if ($debugmode)
	{
		// Allow the display of error during debugging.
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}
	else
	{
		// Display a 404 error if the user attempts to access this file directly.
		if (__FILE__ == $_SERVER['SCRIPT_FILENAME'])
		{
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
			exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
		}
	}
	
	class Stardate
	{
		// Value is stored as a floating point.
		private $m_value;
		
		private $m_tos_start;
		private $m_tos_end;
		private $m_tos_seconds_per_stardate;
		
		private $m_tng_start;
		private $m_tng_end;
		private $m_tng_seconds_per_stardate;
		
		/**
		* Constructor
		*/
		function __construct()
		{
			$this->m_tos_start = date_create_immutable("2265-04-25");
			$this->m_tos_end = date_create_immutable("2269-02-08");
			$this->m_tos_seconds_per_stardate = 11975.5707;
			
			$this->m_tng_start = date_create_immutable("2318-07-05");
			$this->m_tng_end = date_create_immutable("2427-05-30");
			$this->m_tng_seconds_per_stardate = 34367.0564;
		}
		
		/**
		* Set the value of the stardate.
		* 
		* @param value The desired value of the stardate.
		*/
		public function set_value($value)
		{
			// Check what type of input we're getting.
			if (is_numeric($value))
			{
				// Store value in member variable without modification.
				$this->m_value = $value;
			}
			elseif (is_a($value, 'DateTime'))
			{
				// Convert the date to a floating point and store in the member variable.
				$this->m_value = $this->gregorian_to_stardate($value);
			}
			else
			{
				// Unrecognized input. Throw error "type mismatch".
				trigger_error('Type mismatch on set_value()!', E_USER_ERROR);
			}
		}
		
		/**
		* Get the value of the stardate.
		*
		* @return float The stardate.
		*/
		public function get_value_stardate()
		{
			return $this->m_value;
		}
		
		/*
		* Get the Earthdate equivalent of the stardate.
		*
		* @return DateTime The Earthdate equivalent.
		*/
		public function get_value_earthdate()
		{
			return $this->stardate_to_gregorian($this->m_value);
		}
		
		/*
		* Convert Gregorian dates to stardates.
		*
		* @param gregorian The Gregorian date to be converted.
		* @return float The stardate equivalent.
		*/
		private function gregorian_to_stardate($gregorian)
		{
			// Check if Gregorian date is within a valid range.
			// TNG-era stardates below 10000 have been disallowed to allow blending of the two systems.
			$tos_valid = $this->m_tos_start <= $gregorian && $this->m_tos_end >= $gregorian;
			$tng_valid = $this->stardate_to_gregorian(10000) <= $gregorian && $this->m_tng_end >= $gregorian;
			
			if ($tos_valid)
			{
				// TOS era
				$interval = $gregorian->getTimeStamp() - $this->m_tos_start->getTimeStamp();
				$result = round($interval / $this->m_tos_seconds_per_stardate, 1);
			}
			elseif ($tng_valid)
			{
				// TNG era
				$interval = $gregorian->getTimeStamp() - $this->m_tng_start->getTimeStamp();
				$result = round($interval / $this->m_tng_seconds_per_stardate, 1);
			}
			else
			{
				// Outside valid range. Throw error "subscript out of range".
				trigger_error('Subscript out of range on gregorian_to_stardate()!', E_USER_ERROR);
			}
			
			return $result;
		}
		
		/*
		* Convert stardates to Gregorian dates
		*
		* @param stardate The stardate to be converted.
		* @return date The Gregorian equivalent.
		*/
		private function stardate_to_gregorian($stardate)
		{
			if ($stardate < 10000)
			{
				// TOS era
				$interval = date_interval_create_from_date_string(floor($stardate * $this->m_tos_seconds_per_stardate) . " seconds");
				$result = $this->m_tos_start->add($interval);
			}
			else
			{
				// TNG era
				$interval = date_interval_create_from_date_string(floor($stardate * $this->m_tng_seconds_per_stardate) . " seconds");
				$result = $this->m_tng_start->add($interval);
			}
			
			return $result;
		}
	}
?>