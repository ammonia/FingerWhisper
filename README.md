FingerWhisper
=============

Background
----------
Years ago, I read the science fiction YiTai(Ether).

The author created a world full of tiny robots that can change sound and images in order to shield 'dangerous' thoughts. So, a new communication method was invented: writting letters on palms, as sence of touch is the only way that robots can not change.

Dozens of people in black hoodies - perhaps there were hundreds - sitting on the ground quietly, holding hands with each other. No one spoke.
...
People sit in a circle. Everyone is connected with another two. Write with your left hand, feel with your right hand.
...
The rule of finger-chat-association is to keep information flow in one direction.
                                                              ---- Ether, by Zhuxieduowen.

However, I do not believe this complex method works. It calls for perfect cooperation, but can only transfer little information every time. So I wrote the charting room to see what would happen if we chat like this.

This is the simplest version as I have little time to debug. You can see there is even no javascript. Maybe someday I would complish a PC version.

:)

Environment
-----------
The website is built on WAMP.

Database
--------
There are four tables in the database. Three of them - room, people and talk - are quite simple. The last one, circle, is just like a circular doubly linked list, each of the row is a node.

PHP & HTML
----------
### index.php 

### login.php
### talk.php
### room.php
To see people in the circle
### leave.php
Delete your information in circle and connect your pre and your next to keep the circle smooth, and clear session.

The CSS and JS always drive me crazy. 

TODO
----
