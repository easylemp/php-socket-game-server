package
{
	public class SocketServerEncoder
	{ 
		private var message:XML; 
		private var session:XML; 
		private var room:Array;
		
		public function SocketServerEncoder()
		{
			room=new Array();
		}
		 
		public function encodedMessage(clearXml=true)
		{
			var send:XML = <send></send>;   
			send.appendChild(session);
			send.appendChild(getRoomEventXml());
			if(clearXml)
			{
				room=new Array();
			}
			return send.toXMLString(); 
		}
		
		public function decodeMessage()
		{
			
		}
		
		
		
		public function getSession()
		{
			return session;
		}
		
		
		
		public function getRoomEvent()
		{
			return room;	
		}
		
		public function getRoomEventXml()
		{
			var convertedToString:String="<rooms>";
			for(var i:uint=0;i<room.length;i++)
			{
				convertedToString+="<room>";
				convertedToString+="<name>"+room[i]['name']+"</name>";	
				convertedToString+="<event>"+room[i]['event']+"</event>";
				convertedToString+="<params>"; 
				convertedToString+="<message><text>"+room[i]['message']+"</text></message>";
				convertedToString+="</params>";	 
				convertedToString+="</room>";
			}
			convertedToString+="</rooms>";
			return new XML(convertedToString);
		}
		
		public function setRoomEvent(roomName,roomEvent,roomParams)
		{
			var roomItems:Array=new Array();
			roomItems['name']=roomName;
			roomItems['event']=roomEvent;
			roomItems['message']=roomParams;
			room.push(roomItems);
		}
		
		public function setSession(sessionParam)
		{
			session=new XML("<private_session>"+sessionParam+"</private_session>")
		} 
		
		public function getMethod()
		{
		 
		}
	}
}