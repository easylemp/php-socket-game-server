<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package  Communication
 * @license BSD 
 * Class for hanling message that comes from rooms
 * This class create xml that will send to user
 */
class Communication_SendRoomMessages  
{
	/** 
	 * list of rooms to handle message
     * @var array
    */  
	private $rooms;
	 
	public function __construct()
	{
		$this->rooms=array();
	}
	/** 
	 * Room, key is room name, and array will populated with room data
	 * @todo convert room messages data to object
	 * @param $room string
    */  
	public function addRoom($room)
	{
		$this->rooms[$room]=array(); 
	}
	/** 
	 * Room, key is room name, and array will populated with room data
	 * xml:
	 * <room>
	 * <name>$room</name>
	 * <$elementName>$value</$elementName>
	 * <room>
	 * @todo convert room messages data to object
	 * @param $room string
	 * @param $elementName string
	 * @param $value array 
    */ 
	public function addRoomItem($room,$elementName,$value)
	{
		if(!is_array($value))
		{
			return false;
		}
		$this->rooms[$room][$elementName]=$value;
	}
	/** 
	 * removing room from rooms array
 	*@param $room string
    */ 
	public function removeRoom($room)
	{
		unset($this->rooms[$room]);
	}
	/** 
	 * removing $element from room 
 	 *@param $room string
 	 *@param $elementName string
    */ 
	public function removeRoomItem($room,$elementName)
	{
		unset($this->rooms[$room][$elementName]);
	}
	/** 
	 * get room elements values from room 
 	 *@param $room string
 	 *@param $elementName string
    */ 
	public function getRoomItem($room,$elementName)
	{
		return $this->rooms[$room][$elementName];
	} 
	
	/** 
	 * creating xml from rooms array
	 * <rooms>
	 * <room>
	 * <name>$room</name>
	 * <$elementName>$value</$elementName>
	 * <room>
	 * <room>
	 * <name>$room</name>
	 * <$elementName>$value</$elementName>
	 * <room>
	 * </rooms>
	 * @return SimpleXMLElement 
    */ 
	public function getXml()
	{
		$rooms=new SimpleXMLElement("<rooms></rooms>"); 
		
		foreach($this->rooms as $roomKey=>$r)
		{
			$room=$rooms->addChild("room");
			$room->addChild('name',$roomKey);
			foreach($r as $rInnerKey=>$rInner)
			{
				foreach($rInner as $rInner2)
				{
					$room->addChild($rInnerKey,$rInner2);
				}
			} 
		}
		return $rooms;
	}
}