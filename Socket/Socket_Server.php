<?php
 
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package    Socket
 * @license BSD
 * @link http://www.php.net/manual/en/ref.sockets.php
 * socket wrapper class for socket functions in php
 */

class Socket_Server extends Socket_A_Socket
{
	/** 
     * constructor  
     */
	public function __construct($domain , $type , $protocol)
	{
		$this->socketInstance=$this->executionResult(socket_create($domain, $type, $protocol)); 
	}

	public function bind($address, $port=0,$forceReconect=true)
	{ 
		if($forceReconect==true);
		{
				socket_set_option($this->socketInstance, SOL_SOCKET, SO_REUSEADDR, 1);
		}
		$result=$this->executionResult(socket_bind($this->socketInstance, $address, $port));
		return $result;
	}

	public function listen($listen=null)
	{ 
		$arguments=array();
		$arguments[]=$this->socketInstance;
		if($listen!=null)
		{
			$arguments[]=$listen;
		}
		return $this->executionResult(call_user_func_array(socket_listen,$arguments));
	}

	public function select(&$read,&$write,&$except,$tv_sec,$tv_usec=null)
	{
		$arguments=array();
		$arguments[]=&$read;
		$arguments[]=&$write;
		$arguments[]=&$except;
		$arguments[]=$tv_sec;
		
		if($tv_usec!=null)
		{
			$arguments[]=$tv_usec;
		}
		return $this->executionResult(call_user_func_array(socket_select,$arguments));
	}
	
	public function accept()
	{
		return $this->executionResult(socket_accept($this->socketInstance)); 
	} 
}

?>