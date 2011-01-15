<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package   Manager
 * @license BSD
 * class that holds Client Socket Connections
 */
class Manager_Client implements IteratorAggregate
{
	/** 
     * socket client array holder
     * @var array
    */
    private $items = array();
     
    /** 
     *maximum size of $this->items array
     *this can be set when socket server is creating but then is set for socket server
     * @var string  
    */
	private $maxCount;
    
     /** 
     * required definition of interface IteratorAggregate
     * @return ArrayIterator
    */
    public function getIterator() 
    {
        return new ArrayIterator($this->items);
    }
    
   /** 
     * adding new socket client
     * @param $socketClient Socket_Client
    */
    public function add(Socket_Client $socketClient) 
    {	
    	$unique=false;
    	while ($unique==false)
    	{
    		$session=Session_Session::generate();
    		foreach($this->items as $items)
    		{
    			if($items->getSession()==$session)
    			{
    				continue;
    			}
    		}
    		$unique=true;
    	}
    	
    	$socketClient->setSession($session);
    	$this->items[$socketClient->getSocketInstance()]=$socketClient; 
    }
    
    /**  
     * return list of  Socket_Client
     * @return array 
    */
    public function getItems()
    {
    	return $this->items;
    }
     
     /**  
     * return maximun count in $this->items array
     * @return int 
    */
    public function getMaxCount()
    {
    	return $this->maxCount;
    }
    /**  
     * setting maximun count in $this->items array
     * @param $integer int 
    */
    public function setMaxCount($integer)
    {
    	$this->maxCount=$integer;
    }
    
    /**  
     * size of $this->items array
     * @return int 
    */
    public function getCount()
    {
    	return sizeof($this->items);
    }

    /**  
     * can new socket connection be added
     * @return boolean
    */
    public function isAddAllowed()
    {
    	if($this->getCount()<$this->getMaxCount())
    	{
    		return true;
    	}
    	return false;
    }
    
    /**  
     * return Socket_Client by socket resource id
     * @param $resource string resource id
     * @return Socket_Client 
    */
    public function getItemByResource($resource)
    {
    	return $this->items[$resource];
    }
    
 	/**  
     * unset Socket_Client by socket resource id
     * @param $resource string resource id
    */
    public function removeItemByResource($resource)
    {
    	unset($this->items[$resource]);
    }
}
