<?php

/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Events
 * @license BSD
 * Event listener for RoomItems
 * @create this as base class for other events listeners
 */

class Events_Listener
{
	/** 
	 *event listener holder
     * @var array
    */
	private $events=array();
	
	public function __construct()
	{
		$this->events=array();
	}

	/** 
	 *adding event listener
	 *$listner is metod that is listening for event
     * @param $eventName string
     * @param $listener string 
    */
	public function addEventListener($eventName,$listener)
	{
		$this->events[$eventName]=$listener;
	}
	/** 
	 * return subscribed events
     * @return array
    */
	public function getSubscribedEvents()
	{
		return $this->events;
	}
	
	/** 
	 *returning subscribed event by name
     * @param $eventName string
    */
	public function getSubscribedEventByName($eventName)
	{
		return $this->events[$eventName];
	}
}