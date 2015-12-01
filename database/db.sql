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

INSERT INTO Event(idEvent, name, dateBegin,description, location, image) Values (1,"LOL","01-01-2012","cenas","porto","https://www.google.pt/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwj7tciq5rjJAhWCQBoKHYt2DGEQjRwIBw&url=https%3A%2F%2Fstancarey.wordpress.com%2F2013%2F03%2F05%2Fthe-dramatic-grammatic-evolution-of-lol%2F&psig=AFQjCNHA0NEVbuNJuBB6s7ExKNgzmQXOlg&ust=1448995315083619");
INSERT INTO Event(idEvent, name, dateBegin,description, location, image) Values (2,"PPPPP","01-03-2012","cenas12","lisbon","https://www.google.pt/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwj7tciq5rjJAhWCQBoKHYt2DGEQjRwIBw&url=https%3A%2F%2Fstancarey.wordpress.com%2F2013%2F03%2F05%2Fthe-dramatic-grammatic-evolution-of-lol%2F&psig=AFQjCNHA0NEVbuNJuBB6s7ExKNgzmQXOlg&ust=1448995315083619");