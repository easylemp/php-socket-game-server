<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package  Communication
 * @license BSD 
 * Handling user message
 */
class Communication_Recive
{
	/** 
	 * xml from client
     * @var SimpleXMLElement
    */
	private $xml;
	/** 
	 *error in user message
     * @var boolean
    */
	private $xmlError;
	/** 
	 *array of data to be dispached to Rooms
	 *@todo convert to object
     * @var array
    */		 
	private $rooms;
	
	/**  
	 * $message xml from user message
	 * if $suppressError set to true, xml will not dispatch errors
     *@param $message string
     *@param $suppresError boolean
    */		
	public function __construct($message=null,$suppressError=true)
	{ 
		$this->suppressError($suppressError);
		$this->parseMessage($message);
	} 
	
	/**  
	 * if $suppressError set to true, xml will not dispatch errors
     *@param $value boolean
    */
	public function suppressError($suppressError=true)
	{
		libxml_use_internal_errors ( $suppressError );
	}
	
	/**  
	 * parsing user xml messages 
     *@param $message string
     *@todo create variable to handle xml error messages 
    */		
	private function parseMessage($message)
	{
		/*
		 * must use functional approach because OOP dont return false;
		 * $this->xml = new SimpleXMLElement($message);  
		 *@todo look for alternative, sometimes its bad to use funcional apporach and then do OOP manipulation
		 * but this function return object so I suppose it will OK!
		 */
		
		  $this->xml = simplexml_load_string($message);
		  if($this->xml===false)
		  {
		  	$this->xmlError=true;
		  	return;
		  }; 
		  $this->creatingRoomMessages($this->xml->rooms);
	}
	
	/**  
	 * creating user room actions
	 * @todo convert this to object 
     *@param $message SimpleXMLElement
    */	
	private function creatingRoomMessages(SimpleXMLElement $rooms)
	{
		foreach ($rooms->room as $r)
		{
			$tempArray=array("name"=>(string)$r->name,"event"=>(string)$r->event); 
			foreach ($r->params->children() as $paramAttribute => $p)
			{
				foreach ($p->children() as $key=>$pInner)
				{
					$tempArray['params'][$paramAttribute][]=array($key=>(string)$pInner); 
				} 
			}
			$parsedEvents[]=$tempArray; 
		}
		  $this->rooms=$parsedEvents;
	}
	
	/**  
	 * returning user room actions
	 * @todo convert this to object 
     * @return array
    */	
	public function getParsedRoomsEvents()
	{
		return $this->rooms;
	}
}