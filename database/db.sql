DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Event;
DROP TABLE IF EXISTS EventType;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS AdminEvent;
DROP TABLE IF EXISTS GoToEvent;
 
 
CREATE TABLE User(
idUser INTEGER PRIMARY KEY,
username VARCHAR UNIQUE,
password VARCHAR NOT NULL
);
 
CREATE TABLE Event(
idEvent INTEGER PRIMARY KEY,
name VARCHAR UNIQUE,
dateBegin DATE,
description VARCHAR NOT NULL,
location VARCHAR NOT NULL,
image VARCHAR NOT NULL
);
 
CREATE TABLE EventType(
idEventType INTEGER PRIMARY KEY,
idEvent INTEGER REFERENCES Event(idEvent),
type VARCHAR NOT NULL
);

CREATE TABLE Comment(
 idComment INTEGER PRIMARY KEY,
 idUser INTEGER REFERENCES User(idUser),
 idEvent INTEGER REFERENCES Event(idEvent),
 commentary VARCHAR NOT NULL
);
 
CREATE TABLE AdminEvent(
 idUser INTEGER REFERENCES User(idUser),
 idEvent INTEGER REFERENCES Event(idEvent),
 PRIMARY KEY(idUser,idEvent)
);
 
CREATE TABLE AttendEvent(
 idUser INTEGER REFERENCES User(idUser),
 idEvent INTEGER REFERENCES Event(idEvent),
 PRIMARY KEY(idUser,idEvent)
);
