<?php
/**
 * 
 * COMMENT PART IS FOR RUNNING UNDER SYSTEM_DEAMON
 * @see http://pear.php.net/package/System_Daemon
 * @license BSD
 * @author Goran Sambolić  gsambolic@gmail.com
 * */

/*
 * put this at start of file outside <?php tag
 * #!/usr/local/bin/php -q 
 */
/*

set_include_path(".:/usr/local/lib/php");
//set your reporting preferences
error_reporting(E_ALL);
require_once "System/Daemon.php";

// Bare minimum setup
System_Daemon::setOption("appName", "server");
System_Daemon::setOption("authorEmail", "gsambolic@gmail.com");
System_Daemon::setOption("authorName","goran sambolic a.k.a gorrc");
System_Daemon::setOption("appDescription","socket world server");
//System_Daemon::setOption("appDir", dirname(__FILE__));
System_Daemon::log(System_Daemon::LOG_INFO, "Daemon not yet started");
//System_Daemon::writeAutoRun();
// Spawn Deamon!
System_Daemon::start();
System_Daemon::log(System_Daemon::LOG_INFO, "Daemon started");
*/
define('SERVER_DIR', "D:\wamp\www\zendworkspace\SocketServer");

/**
 * @todo need to test will autoload run while PHP is compilied as CGI or CLI
 * @see http://php.net/manual/en/language.oop5.autoload.php
 * naming convection for file is Folder_Class name
 * naming convection for class is same as Class name
 * folder A stands for Abstract
 * folder I stand for Interface
 * */
function __autoload($className) 
{ 
	$pathExploaded=explode("_",$className);
	$classParsedLocation=SERVER_DIR;
	unset($pathExploaded[sizeof($pathExploaded)-1]);
	foreach ($pathExploaded as $p)
	{
		$classParsedLocation.=DIRECTORY_SEPARATOR.$p;
	}
	$classParsedLocation.=DIRECTORY_SEPARATOR.$className.".php"; 
	if(!file_exists($classParsedLocation))
	{
		return false;
	}
	require_once $classParsedLocation;
}

require_once "D:\wamp\www\zendworkspace\SocketServer\Server.php";

$server = new Server_Server();
$server->run(); 
//System_Daemon::stop();