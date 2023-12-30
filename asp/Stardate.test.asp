<%@ CodePage=65001 Language="VBScript"%>
<% Option Explicit %>
<!--#include file="Stardate.class.asp"-->
<%
	' Ensure that UTF-8 encoding is used instead of Windows-1252
	Session.CodePage = 65001
	Response.CodePage = 65001
	Response.CharSet = "UTF-8"
	Response.ContentType = "text/html"
	
	' Creates a stardate from a numeric value.
	' 
	' @param input The desired value of the stardate.
	' @param expected The expected earth date.
	' @return boolean Whether the result matched the expectation.
	function testStardateNumeric(input, expected)
		dim testStardate
		set testStardate = new Stardate
		testStardate.value = input
		
		dim actual
		actual = testStardate.earthDate
		
		dim result
		dim resultText
		if actual = expected then
			result = true
			resultText = "successful"
		else
			result = false
			resultText = "failed"
		end if
		
		Response.Write "Unit Test: value(stardate)" & vbCrLf
		Response.Write "Input:     " & input & vbCrLf
		Response.Write "Expected:  " & expected & vbCrLf
		Response.Write "Actual:    " & actual & vbCrLf
		Response.Write "Result:    Test " & resultText &  "!" & vbCrLf & vbCrLf
		
		testStardateNumeric = result
		set testStardate = nothing
	end function
	
	' Creates a Stardate from a date value.
	' 
	' @param input The Gregorian date to be converted to a stardate.
	' @param expected The expected stardate.
	' @return boolean Whether the result matched the expectation.
	function testStardateGregorian(input, expected)
		dim testStardate
		set testStardate = new Stardate
		testStardate.value = input
		
		dim actual
		actual = testStardate.value
		
		dim result
		dim resultText
		if actual = expected then
			result = true
			resultText = "successful"
		else
			result = false
			resultText = "failed"
		end if
		
		Response.Write "Unit Test: value(gregorian)" & vbCrLf
		Response.Write "Input:     " & input & vbCrLf
		Response.Write "Expected:  " & expected & vbCrLf
		Response.Write "Actual:    " & actual & vbCrLf
		Response.Write "Result:    Test " & resultText &  "!" & vbCrLf & vbCrLf
		
		testStardateGregorian = result
		set testStardate = nothing
	end function
	

	' Create an HTML container for our output.
	Response.Write "<!DOCTYPE html>" & vbCrLf
	Response.Write "<html lang=""en"">" & vbCrLf
	Response.Write "<meta http-equiv=""Content-Type"" content=""text/html;charset=UTF-8"" />" & vbCrLf
	Response.Write "<body>" & vbCrLf
	
	' Display code header
	Response.Write "<pre>"
	Response.Write "/***************************************************************************************\" & vbCrLf
	Response.Write "| ASP Stardate Class Unit Tests                                                         |" & vbCrLf
	Response.Write "|                                                                                       |" & vbCrLf
	Response.Write "| Copyright (c) 2023, Scott Vander Molen; some rights reserved.                         |" & vbCrLf
	Response.Write "|                                                                                       |" & vbCrLf
	Response.Write "| This work is licensed under a Creative Commons Attribution 4.0 International License. |" & vbCrLf
	Response.Write "| To view a copy of this license, visit https://creativecommons.org/licenses/by/4.0/    |" & vbCrLf
	Response.Write "|                                                                                       |" & vbCrLf
	Response.Write "\***************************************************************************************/" & vbCrLf
	Response.Write "</pre>"
	
	' Run unit tests
	Response.Write "<pre>"
	
	dim test1
	test1 = testStardateNumeric(1312.4, DateSerial(2265,10,23) + TimeSerial(21,45,38))
	
	dim test2
	test2 = testStardateGregorian(DateSerial(2265,10,23) + TimeSerial(21,45,38), 1312.4)
	
	dim test3
	test3 = testStardateNumeric(40759.5, DateSerial(2362,11,23) + TimeSerial(18,40,35))
	
	dim test4
	test4 = testStardateGregorian(DateSerial(2362,11,23) + TimeSerial(18,40,35), 40759.5)
	
	Response.Write "</pre>" & vbCrLf
	
	' Close the HTML container.
	Response.Write "</body>" & vbCrLf
	Response.Write "</html>"
%>