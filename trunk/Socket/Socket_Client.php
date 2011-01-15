<?php


/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Socket
 * @license BSD
 * @link http://www.php.net/manual/en/ref.sockets.php
 * socket clients
 */
class Socket_Client extends Socket_A_Socket
{ 
	/** 
     *ip
     * @var string  
    */
	private $ip;	
	
	/** 
     *session client
     * @var string  
    */
	private $session;	
	
	
  

    public function setIP($ip)
    {
    	$this->ip=$ip;
    }
	
    public function getIP()
    {
    	return $this->ip;
    } 
    
    public function getSession()
    {
    	return $this->session;
    }
    
    public function setSession($session)
    {
    	$this->session=$session;
    } 
}