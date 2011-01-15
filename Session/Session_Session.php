<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Session
 * @license BSD 
 * Class for creating session
 * @todo maybe session manger to manage all session that exist
 */
class Session_Session
{
	/** 
     *random string that is used as session
     * @return string
    */
    public static function generate()
    {
    	$number=rand(100000, 10000000);
    	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    	$length=strlen($chars); 
	    // Start our string
	    $string = ""; 
	    // Generate random string
	    for ($i = 1; $i <  $length-4; $i++)
	    {
	        // Grab a random character from our list
	        $string .= $chars[rand(0,$length)]; 
	    }
    	return md5($string.number);
    }   
}