<?php

class Server_Server
{
	
	public function run()
	{ 
		
		$socket = new Socket_Server(AF_INET, SOCK_STREAM, 0);  
		$socket->bind("127.0.0.1", 9001); 
		//$socket->bind("173.203.113.55", 9000);
		$socket->listen(); 
		$socket->setToNonBlock(); 
		$this->startApplication($socket);
		
	}

	public function startApplication(Socket_Server $socket) 
	{
		
		$userManager=new Manager_User();
		$clientManager=new Manager_Client();
		$roomManager=new Manager_Room();
		
		$roomManager->add("main",new RoomItems_DefaultRoom()); 
	    $clientManager->setMaxCount(10);
		$sock=$socket->getSocketInstance(); 
	 	
		while (true) 
		{ 
		    // Setup clients listen socket for reading
			$read=array();
			array_push($read, $sock);
			 
		    foreach ($clientManager as $c)
		    {
		       array_push( $read, $c->getSocketInstance()) ; 
		  	}
	
		    $value=null;
		    // Set up a blocking call to socket_select()
		    $ready = $socket->select($read,$value,$value,100); 
	 
		    if (in_array($sock, $read)) 
		    {
		   		$clientObject=new Socket_Client();
		        $clientObject->setSocketInstance($socket->accept()); 
				$clientManager->add($clientObject); 
				$userSession=$userManager->add(new UserItems_DefaultUser(), $clientObject);  
			 	$roomManager->addUserToRoom($userManager->getUserBySession($userSession),"main"); 
			 	$key = array_search($sock, $read);
            	unset($read[$key]);
		    }  

		    // loop through all the clients that have data to read from
        foreach ($read as $readSock) 
        {
            // read until newline or 1024 bytes
            // socket_read while show errors when the client is disconnected, so silence the error messages
            //---$data = @socket_read($readSock, 1024, PHP_NORMAL_READ);
            $client=$clientManager->getItemByResource($readSock);
            $data=$client->read(1024);
            // check if the client is disconnected
            if ($data === false) 
            { 
                unset($c); 
                continue;
            }
           
            // trim off the trailing/beginning white spaces
            $data = trim($data);
            
           
            // check if there is any data after trimming off the spaces
            if (!empty($data)) 
            {
                $recive=new Communication_Recive($data); 
	            $roomEvents=$recive->getParsedRoomsEvents();
	            $roomManager->dispatchRoomEvents($roomEvents);
            }  
        } // end of reading foreach 
		
		} 
	} 
}
?>