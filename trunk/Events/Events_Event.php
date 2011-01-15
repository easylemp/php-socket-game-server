<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Events
 * @license BSD 
 * class that holds event
 * currently only for room
 * @todo create this as base class that will extended by other events 
 */

class Events_Event
{
	/** 
	 * room that is bound to this event
	 * for now its only rooms can manipulate with events
     * @var object
    */ 
	 private $target;
	 /** 
	 * event name
     * @var stiring
    */ 
	 private $event;
	 /** 
	 * event params
	 * @todo convert to object
     * @var array
    */ 
	 private $params;
	 /** 
	 * if event is dispatch by user here is place to store session of user
     * @var string
    */ 
	 private $eventUser;
	 
	 /** 
	 * @param $target mixed
	 * @param $event string
	 * @param $params array
	 * @param $eventUser string
    */ 
	 public function __construct($target,$event,$params=array(),$eventUser=null)
	 {
	 	$this->setTarget($target);
	 	$this->setEvent($event);
	 	$this->setParams($params);
	 	$this->eventUser=$eventUser;
	 }
	 
	/**
	 * set target of event  
	 * @param $target object
	 */
	 public function setTarget($target)
	 {
	 	$this->target=$target;
	 }
	 
	/**
	 * return target object
	 * @return object
    */ 
	 public function getTarget()
	 {
	 	return $this->target;
	 }
	 
	/**
	 * return event name
	 * @return string
    */ 
	 public function getEvent()
	 {
	 	return $this->event;
	 }
	 
	/**
	 * @param $event string
    */ 
	 public function setEvent($event)
	 {
	 	$this->event=$event;
	 }
	 
	/**
	 * @param array
	 * @todo convert to object
    */ 
	 public function setParams($params)
	 {
	 	$this->params=$params;
	 }
	 
	/**
	 * @return array
    */ 
	 public function getParams()
	 {
	 	return $this->params;
	 }
	 
	/**
	 * return param by array key
	 * @return mixed
    */ 
	 public function getParamsByName($name)
	 {
	 	return $this->params[$name];
	 }
	 
	 /**
	  * return session of user
	 * @return string
    */ 
	 public function getEventUser()
	 {
	 	return $this->eventUser;
	 }
	 
	/**
	 * setting session of user
	 * @return string
    */ 
	 public function setEventUser($user)
	 {
	 	$this->eventUser=$user;
	 }
}