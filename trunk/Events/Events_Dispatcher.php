<?php

/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Events
 * @license BSD
 * events dispatcher for Rooms
 * user send events from client and this class dispatch evetns to all RoomItems 
 * that have listener
 * events are dispatched from Room itself
 * room class extends this class
 */

class Events_Dispatcher
{ 
	/** 
	 * this method is iterating over RoomItems and execute methods that are set
	 * for listeners in RoomItems
	 * @todo maybe another approach, this is very simple
	 * @param $event string
    */  
	public function dispatchEvent($event)
	{
		//get all RoomItems
		$subsribers=$event->getTarget()->getItems();
		//iterating over RoomItems 
		foreach($subsribers as $s)
		 {
		 	 //getting event name
		 	 $method=$s->getSubscribedEventByName($event->getEvent());
		 	 //executing event name
		 	 $s->$method($event);
		 };
	}  
}