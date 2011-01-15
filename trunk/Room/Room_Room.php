<?php

/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Room
 * @license BSD 
 * room class that holds user in room
 * managing events for room
 * room have multiple RoomItems
 */

class Room_Room extends Events_Dispatcher
{
	/** 
     * users array holder
     * @var array
    */
	private $users;
	/** 
     * name of room
     * @var string
    */
	private $name;
	/** 
     * RoomItems array holder
     * @var array
    */
	private $items;
	
	/** 
     * @param $name
     * @param $item
    */
	public function __construct($name,$item)
	{ 
		$this->setName($name);
		$this->addItem($item);
	} 
	
	/** 
     * @param $user User_User
     * @todo move this from here
    */
	public function addUserToRoom(User_User $user)
	{
		//tracking user by session
		$this->users[$user->getSession()]=$user;
		//dispatching new user event
		$event=new Events_Event($this,"addUser",array("newUser"=>array($user)));
		$this->roomEvent($event);
	} 
	
	/** 
	 * remove user by session name
     * @param $user string 
    */
	public function removeUser($user)
	{
		foreach ($this->getItems() as $i)
		{
			$i->removingUserEvent($user);
		}
		unset($this->users[$user]);
	}
	
	/** 
     * getting user by session name
     * @param $user string
     * @return User_User
    */
	public function getUserByName($user)
	{ 
		return $this->users[$user];
	}
	
	/** 
	 * list of User_User
     * @return array
    */
	public function getUsers()
	{
		return $this->users;
	}
	
	/** 
	 * dispatching Event
     * @param Event_Event
    */
	public function roomEvent(Events_Event $event)
	{
		$this->dispatchEvent($event);
	} 
	
	/** 
	 * return room name
     * @return string
    */
	public function getName()
	{
		return $this->name; 
	}
	
	/** 
	 * getting user name
     * @param string
    */
	public function setName($name)
	{
		$this->name=$name;
	}
	
	/** 
	 * return list of RoomItems
     * @return array
    */
	public function getItems()
	{
		return $this->items;
	}
	
	/** 
	 * return RoomItem by class name
     * @return string
    */ 
	public function getItemsByName($item)
	{
		return $this->items[$item];
	}
	
	/** 
	 * return list of RoomItems
     * @return array
    */
	public function addItem($item)
	{
		$this->items[$this->getClassName($item)]= $item; 
	}
	
	public function remove($item)
	{
		unset($this->items[$item]);
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