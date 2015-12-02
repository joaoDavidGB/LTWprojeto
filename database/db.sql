DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Event;
DROP TABLE IF EXISTS EventType;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS AdminEvent;
DROP TABLE IF EXISTS AttendEvent;
 
 
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

INSERT INTO User Values(0, "master", "abc");
INSERT INTO Event(idEvent, name, dateBegin,description, location, image) Values (1,"LOL","01-01-2012","cenas","porto","http://cdn.appstorm.net/mac.appstorm.net/files/2012/07/icon4.png");
INSERT INTO Event(idEvent, name, dateBegin,description, location, image) Values (2,"PPPPP","01-03-2012","cenas12","lisbon","https://lh3.googleusercontent.com/5oh994t2XLUThXYZQgeH3lv7Zv0cAHh8qJPuK82tqES6oFDASv4j43D0Hsps84_IhjM=w300");