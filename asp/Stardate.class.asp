<%
	' ASP Stardate Class
	' 
	' Copyright (c) 2023, Scott Vander Molen; some rights reserved.
	' 
	' This work is licensed under a Creative Commons Attribution 4.0 International License.
	' To view a copy of this license, visit https://creativecommons.org/licenses/by/4.0/
	' 
	' @author  Scott Vander Molen
	' @version 2.0
	' @since   2023-12-30
	'
	' http://TrekGuide.com/Stardates.htm
	class Stardate
		' Value is stored as a floating point.
		private m_value
		
		private m_tos_start
		private m_tos_end
		private m_tos_seconds_per_stardate
		
		private m_tng_start
		private m_tng_end
		private m_tng_seconds_per_stardate
		
		' Constructor
		private sub Class_Initialize()
			' TOS stardates 0000.0 through 9999.9 range from April 25, 2265 to February 8, 2269
			m_tos_start = DateSerial(2265,4,25)
			m_tos_end = DateSerial(2269,2,8)
			m_tos_seconds_per_stardate = 11975.5707
			
			' TNG stardates 00000.0 through 99999.9 range from July 5, 2318 to May 30, 2427.
			m_tng_start = DateSerial(2318,7,5)
			m_tng_end = DateSerial(2427,5,30)
			m_tng_seconds_per_stardate = 34367.0564
		end sub
		
		' Set the value of the stardate.
		' 
		' @param input The desired value of the stardate.
		public property let value(input)
			' Check what type of input we're getting.
			if isNumeric(input) then
				' Store value in member variable without modification.
				m_value = input
			elseif isDate(input) then
				' Convert the date to a floating point and store in the member variable.
				m_value = gregorian_to_stardate(input)
			else
				' Unrecognized input. Throw error "type mismatch".
				Err.Raise 13
			end if
		end property
		
		' Get the value of the stardate
		'
		' @return string The stardate.
		public property get value
			value = m_value
		end property
		
		' Get the Gregorian equivalent of the Stardate
		public property get earthDate
			earthDate = stardate_to_gregorian(m_value)
		end property
		
		' Convert Gregorian dates to stardates.
		'
		' @param gregorian The Gregorian date to be converted.
		' @return float The stardate equivalent.
		private function gregorian_to_stardate(gregorian)
			dim result
			dim tos_valid
			dim tng_valid
			dim interval
			
			' Check if Gregorian date is within a valid range.
			' TNG-era stardates below 10000 have been disallowed to allow blending of the two systems.
			tos_valid = m_tos_start <= gregorian and m_tos_end >= gregorian
			tng_valid = stardate_to_gregorian(10000) <= gregorian and m_tng_end >= gregorian
			
			if tos_valid then
				' TOS era
				interval = DateDiff("s", m_tos_start, gregorian)
				result = Round(interval / m_tos_seconds_per_stardate, 1)
			elseif tng_valid then
				' TNG era
				interval = DateDiff("s", m_tng_start, gregorian)
				result = Round(interval / m_tng_seconds_per_stardate, 1)
			else
				' Outside valid range. Throw error "subscript out of range".
				Err.Raise 9
				exit function
			end if
			
			gregorian_to_stardate = result
		end function
		
		' Convert stardates to Gregorian dates
		'
		' @param stardate The stardate to be converted.
		' @return date The Gregorian equivalent.
		private function stardate_to_gregorian(stardate)
			dim result 
			
			if stardate < 10000 then
				' TOS era
				result = DateAdd("s", stardate * m_tos_seconds_per_stardate, m_tos_start)
			else
				' TNG era
				result = DateAdd("s", stardate * m_tng_seconds_per_stardate, m_tng_start)
			end if
			
			stardate_to_gregorian = result
		end function
	end class
%>