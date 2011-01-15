<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package  User
 * @license BSD 
 * Managing user
 * This is base class for user
 * Users class can be expand with UserItems classes
 */
class User_User
{
	/** 
	 * socket client instance 
     * @var Socket_Client
    */
	private $socketClient; 
	/** 
	 * holder for UserItems 
     * @var UserItems_I_UserItems
    */
    private $items;
    /** 
	 * public user session
	 * public session are visible to other users
	 * use it as personal ID between users
     * @var string
    */
    private $session;
     /** 
	 * ip of user  
     * @var string
    */
    private $ip;
    
    /** 
     * class for creting new user 
     * @param string $session
     * @param UserItems_I_UserItems  $userItem
     * @param Socket_Client $socketClient
    */
	public function __construct($session,UserItems_A_UserItems $userItem,Socket_Client $socketClient)
	{
		if($session=="")
		{
			return false;
		}
		$this->setSession($session);
		$this->setSocketClient($socketClient);
		$this->addItem($userItem);
	}
	 
	/** 
     * return socket connection for this user
     * internaly usage
     * @return Socket_Client;
    */
	private function getSocketClient()
	{
		return $this->socketClient;
	}
	
	/** 
     * return user public session
     * @return string;
    */
	public function getSession()
	{
		return $this->session;
	}
	
	/** 
     * set user session
     * @param string $session;
    */
	public function setSession($session)
	{
		$this->session=$session;
	}

	/** 
     * writing to user throught socket connection
	 * private session is added to message
     * @param Communication_SendRoomMessages $message;
    */
	public function write($message)
	{   
		$message->getXml()->addChild("private_session",$this->getSocketClient()->getSession());
	    $this->getSocketClient()->write($message->getXml()->asXML());
	} 

	/** 
     * setting socket client
     * @param Socket_Client $socketClient;
    */
	public function setSocketClient($socketClient)
	{
		$this->socketClient=$socketClient;
	}  

	/** 
     * return list of users items 
     * @return array UserItems_I_UserItems
    */
	public function getItems()
	{
		return $this->items;
	}
	
	/** 
  	 * getting user items by class name
     * @param string $userItem;
     * @return UserItems_I_UserItems
     * 
    */
	public function getItemsByName($userItem)
	{
		return $this->items[$userItem];
	}
	
	/** 
 	 * adding user item
     * @param UserItems_I_UserItems $userItem;
    */
	public function addItem(UserItems_A_UserItems $userItem)
	{
		$this->items[$this->getClassName($userItem)]= $userItem ;
	}
	
	/** 
     * removing user item
     * @param string $userItem;
    */
	public function remove($userItem)
	{
		unset($this->items[$userItem]);
	}
	
	/** 
	 * getting class name from object
     * @param object $object;
    */
	private function getClassName($object)
	{
		return strtolower(get_class($object));
	}
}