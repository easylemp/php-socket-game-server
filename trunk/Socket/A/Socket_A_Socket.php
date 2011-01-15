<?php

/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package    Socket
 * @license BSD
 * @link http://www.php.net/manual/en/ref.sockets.php
 * abstract socket wrapper class for socket functions in php
 */

abstract class Socket_A_Socket
{
	/**
	 * socket_create or socket_accept result instance
	 */
	protected  $socketInstance;
	/**
	 * $blockStatus - if socket is blocking or nonblocking
	 * @var boolean
	 */
	protected  $blockStatus;
	
	/*
	 * error code
	 * @var int
	 * */
	protected $socketErrorCode;

	public function getSocketInstance()
	{
		return $this->socketInstance;
	}
	
	public function setSocketInstance($socket)
	{
		$this->socketInstance=$socket;
	}
	
	public function write($write,$length=null)
	{
		$arguments=array();
		$arguments[]=$this->socketInstance;
		$arguments[]=$write;
		
		if($length!=null)
		{
			$arguments[]=$length;
		}
		return $this->executionResult(call_user_func_array(socket_write,$arguments)); 
	}

	public function read($length,$type=PHP_BINARY_READ)
	{
		return $this->executionResult(socket_read($this->socketInstance ,$length,$type));
	}
	
	public function close()
	{
		$this->executionResult(socket_close($this->socketInstance));
		$this->socketInstance=null; 
	}

	public function __destruct() 
 	{
       $this->close(); 
   	}
	
   	public function setToNonBlock()
   	{
   		$this->blockStatus=false;
   		socket_set_nonblock($this->socketInstance);
   	}
   	
   	public function setToBlock()
   	{
   		$this->blockStatus=true;
   		socket_set_nonblock($this->socketInstance);
   	}
   	
   	 /** 
     * return block status of socket; 
     * @param mixe $result  
     * @return boolean
     */
   	public function blockStatus()
   	{
   		return $blockStatus;
   	}
   	
	 /** 
     * check if error exist of function execution, if exist then log it; 
     * @param mixed $result  
     * @return mixed
     */
	protected  function executionResult($result)
	{
		if($result===false)
		{
			$this->socketErrorCode=socket_last_error();
			echo socket_strerror(socket_last_error()); 
			echo $this->socketErrorCode;
			return false;
		}
		return $result;
	}
	
	protected  function getSocketErrorCode()
	{
		return $this->socketErrorCode;	
	}	
}

?>