<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Manager
 * @license BSD 
 * Class that holds all rooms in server
 */
class Manager_Room implements IteratorAggregate 
{
	/** 
     * room array holder
     * @var array
    */
    private $rooms = array();
   /** 
     * room events holder
     * @var array
    */
    private $roomEvents=array();
  
    /** 
     * required definition of interface IteratorAggregate
     * @return ArrayIterator
    */
    public function getIterator() 
    {
        return new ArrayIterator($this->rooms);
    }
     /** 
     * adding new room
     * @param $name string room name
     * @param $roomItem RoomItems_A_RoomItems room item to add
    */
    public function add($name,RoomItems_A_RoomItems $roomItem)
    {
    	if($name=="")
    	{
    		return false;
    	}
    	$this->rooms[$name]=new Room_Room($name,$roomItem);
    }
    
     /** 
     * adding new room
     * @param $name string room name
     * @return RoomItems_A_RoomItems 
    */
    public function getRoom($name)
    { 
    	return $this->rooms[$name];
    } 
    
    /** 
     * adding new user to room
     * @param $user User_User 
     * @param $name string room name
     * @todo better implementation to check room
     * @todo check if this kind of user can be added to rooom
    */
    public function addUserToRoom($user,$room)
    {
    	if($room=="")
    	{
    		return;
    	}
    	$this->getRoom($room)->addUserToRoom($user);   
    }
    
	/**
	 *@todo set room permission on action,user and root lever but to have in mind to not get to complex
	 *@todo creating new event outside of here
	 *@param $room string 
	 *@param $eventString string name of event
	 *@param $params $array 
	 */
    private function roomEvent($room,$eventString,$params)
    {
    	if(!is_array($params))
    	{
    		$params=array();
    	}
    	$event=new Events_Event($this->getRoom($room), $eventString, $params);
    	$this->getRoom($room)->roomEvent($event); 
    } 
    
   /**
	 *dispaching room events
	 *@param $roomEvents array
	 */
    public function dispatchRoomEvents($roomEvents)
    {
    	if(!is_array($roomEvents))
    	{
    		return false;
    	}
    	$this->roomEvents=$roomEvents;
    	if(!is_array($this->roomEvents))
    	{
    		return false;
    	}
    	foreach($this->roomEvents as $r)
    	{
    		$this->roomEvent($r['name'],$r['event'],$r['params']);
    	}
    }
}
