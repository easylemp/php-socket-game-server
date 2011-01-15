<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package  Room
 * @license BSD  
 * Default room, in this room all user are
 * this is example implementation of RoomItems
 */

class RoomItems_DefaultRoom extends RoomItems_A_RoomItems
{
	/*
	 * adding room listeners
	 * */
	public function __construct()
	{
		$this->addEventListener("addUser","responseToAddUser");
		$this->addEventListener("message","responseToMessage");
	}
	/*
	 * response to addUser
	 * */
	public function responseToAddUser($event)
	{
		//getting room users
		$roomUsers=$event->getTarget()->getUsers(); 
		//create new communication object
		$message=new Communication_SendRoomMessages();
		//adding new message 
		$message->addRoomItem($event->getTarget()->getName(), "message", array("newUser"));
		//writing message to users
		foreach($roomUsers as $r)
		{
			$r->write($message);
		}
	}
	/*
	 * response to message
	 * */
	public function responseToMessage($event)
	{
		$roomUsers=$event->getTarget()->getUsers(); 
		$message=new Communication_SendRoomMessages();
		foreach($event->getParamsByName("message") as $e)
		{
			$message->addRoomItem($event->getTarget()->getName(), "message", array($e["text"]));
		}
		
		foreach($roomUsers as $r)
		{ 
			$r->write($message);
		}
	}
}