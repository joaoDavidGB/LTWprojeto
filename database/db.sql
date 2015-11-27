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

INSERT INTO User("Contador","boss");
INSERT INTO User("Folha","plog");

INSERT INTO Event("FeupCaffe1","01-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe2","02-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe3","03-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe4","04-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe5","05-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe6","06-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe7","07-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe8","08-01-2016","cool","awesome","AEFEUP");
INSERT INTO Event("FeupCaffe9","09-01-2016","cool","awesome","AEFEUP");

INSERT INTO EventType(0, "cenas");
INSERT INTO EventType(1, "cenas");
INSERT INTO EventType(2, "cenas");
INSERT INTO EventType(3, "cenas");
INSERT INTO EventType(4, "cenas");
INSERT INTO EventType(5, "cenas");
INSERT INTO EventType(6, "cenas");
INSERT INTO EventType(7, "cenas");
INSERT INTO EventType(8, "cenas");
INSERT INTO EventType(9, "cenas");

INSERT INTO Comment(0,0,"oi");
INSERT INTO Comment(1,1,"oi");
INSERT INTO Comment(2,2,"oi");
INSERT INTO Comment(3,3,"oi");
INSERT INTO Comment(4,4,"oi");
INSERT INTO Comment(5,5,"oi");
INSERT INTO Comment(6,6,"oi");
INSERT INTO Comment(7,7,"oi");
INSERT INTO Comment(8,8,"oi");
INSERT INTO Comment(9,9,"oi");

INSERT INTO AdminEvent(0,0);
INSERT INTO AdminEvent(0,1);
INSERT INTO AdminEvent(0,2);
INSERT INTO AdminEvent(0,3);
INSERT INTO AdminEvent(0,4);
INSERT INTO AdminEvent(0,5);
INSERT INTO AdminEvent(0,6);
INSERT INTO AdminEvent(0,7);
INSERT INTO AdminEvent(0,8);
INSERT INTO AdminEvent(0,9);

INSERT INTO AttendEvent(0,0);
INSERT INTO AttendEvent(0,1);
INSERT INTO AttendEvent(0,2);
INSERT INTO AttendEvent(0,3);
INSERT INTO AttendEvent(0,4);
INSERT INTO AttendEvent(0,5);
INSERT INTO AttendEvent(0,6);
INSERT INTO AttendEvent(0,7);
INSERT INTO AttendEvent(0,8);
INSERT INTO AttendEvent(0,9);



