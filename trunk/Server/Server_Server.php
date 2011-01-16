<?php
/**
 * @author Goran Sambolić <gsambolic@gmail.com>
 * @version 0.1
 * @package  Server
 * @license BSD 
 * Server Class
 */
class Server_Server
{
	/**
	 * running new server
	 * */
	public function run()
	{ 
		//creating new socket server
		$socket = new Socket_Server(AF_INET, SOCK_STREAM, 0);  
		$socket->bind("127.0.0.1", 9001); 
		$socket->listen(); 
		//setting to block or nonblock, depends on your testing
		//$socket->setToNonBlock(); 
		$this->startApplication($socket);
	}
	/**
	 * staring application
	 * creating rooms and handling socket connections
	 * @param $socket Socket_Server
	 * */
	public function startApplication(Socket_Server $socket) 
	{
		$userManager=new Manager_User();
		$clientManager=new Manager_Client();
		$roomManager=new Manager_Room();
		$roomManager->add("main",new RoomItems_DefaultRoom()); 
	    $clientManager->setMaxCount(10);
		$sock=$socket->getSocketInstance(); 
	 	//this is loop that runs server
		while (true) 
		{ 
		    // Setup clients listen socket for reading
			$read=array();
			//adding server at first place in read array
			array_push($read, $sock);
			//looping throught all socket connections
		    foreach ($clientManager as $c)
		    {
		       array_push( $read, $c->getSocketInstance()) ; 
		  	}
	
		    $value=null;
			//wraper for socket_select
		    $ready = $socket->select($read,$value,$value,100); 
	 
		    //if new socket is added
		    if (in_array($sock, $read)) 
		    {
		    	//create Socket_Client instance
		   		$clientObject=new Socket_Client();
		   		//set socket resource to Socket_Client
		        $clientObject->setSocketInstance($socket->accept());
		        //adding Socket_Client to clientManager 
				$clientManager->add($clientObject); 
				//creating new user with Default_User object
				$userSession=$userManager->add(new UserItems_DefaultUser(), $clientObject);  
			 	//adding new user to main room 
				$roomManager->addUserToRoom($userManager->getUserBySession($userSession),"main"); 
			 	$key = array_search($sock, $read);
            	//unset this key from read
			 	unset($read[$key]);
		    }  

		    // loop through all the clients that have data to read from
	        foreach ($read as $readSock) 
	        {
	            //read sockets
	            $client=$clientManager->getItemByResource($readSock);
	            //read message
	            $data=$client->read(1024);
	            // check if the client is disconnected
	            if ($data === false) 
	            { 
	                unset($c); 
	                continue;
	            }
           
	            // trim off the trailing/beginning white spaces
	            $data = trim($data);  
	            //parse data and dispatch events to rooms
	            if (!empty($data)) 
	            {
	                $recive=new Communication_Recive($data); 
		            $roomEvents=$recive->getParsedRoomsEvents();
		            $roomManager->dispatchRoomEvents($roomEvents);
	            }  
        	}  
		} 
	} 
}
?>