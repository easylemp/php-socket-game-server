# PGS - PHP Game Server #
## Game server in php using System\_Deamon Library. ##

## Full OOP. ##
Trying to be full OOP because we wont to deal with objects in virtual world:)

## Sockets ##
Its wrapper around PHP socket function but with little extension.

## Goal ##
To easly create new objects and users and have simple manipulation between users and objects

## Room ##
Objects are now called rooms, because desing goal was to imitate simple multiuser chat but we dont wont to have chat.
There was another problem with object its to similarly to object in programming.
Rooms can be easily upgradable and created with diffrent parts of RoomItems.

## User ##
Users are part of socket client. One socket client can have multiple users.
Users can be easily upgradable.
Users are created with diffrent parts of UserItems

## So where is frikin world!? ##
Well if U have User object that consists of diffrent parts of User items and if you have Rooms that consists of diffrent parts od RoomItems then you ready to go to create own game world on server.
Is that simple? I dont know this is 0.1 Alpha pre-release.

## Why 0.1 Alpha pre-release ##
Because release often release early.

## How is stable ##
Its not:)

## Future request? ##
Complete socket wrapper.
Better event managmet.
Better protocol for communication.
Documentation.
ACL
Etc....
