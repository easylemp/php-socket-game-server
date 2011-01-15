<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package  Manager
 * @license BSD 
 * Managing user
 * One socket connection can have multiple users.
 * This class holds all users in server
 */

class Manager_User implements IteratorAggregate 
{
	/** 
     * users array holder
     * @var array
    */
    private $users;
   
    public function __construct()
    {
    	 $this->users = array();
    }
    
  /** 
     * required definition of interface IteratorAggregate
     * @return IteratorAggregate
    */
    public function getIterator() 
    {
        return new ArrayIterator($this->users);
    }
    
    /** 
     * creting new user, and adding this user to user manager
     * return session user public session
     * public session are session visible to other users
     * @param UserItems_I_UserItems  $userItem
     * @param Socket_Client  $socketClient
     * @return string Session_Session::generate();
    */
    public function add(UserItems_A_UserItems $userItem,Socket_Client $socketClient)
    { 
    	$session=Session_Session::generate();
    	while(array_key_exists($session, $this->users))
    	{ 
    		$session=Session_Session::generate();
    	}
    	
    	$this->users[$session]=new User_User($session,$userItem,$socketClient);
    	return $session;
    }
    
   /** 
     * return user by session
     * @param string $session 
     * @return User_User;
    */
    public function getUserBySession($session)
    {
    	return $this->users[$session];
    }  
    
     /** 
     * return list of users 
     * @return array User_User
    */
    public function getUsers()
    {
    	return $this->users;
    }
}
