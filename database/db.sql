CREATE TABLE users
(
id INTEGER PRIMARY KEY,
username VARCHAR,
password VARCHAR NOT NULL
);

CREATE TABLE events
(
id INTEGER PRIMARY KEY,
name VARCHAR,
day INTEGER NOT NULL,
month INTEGER NOT NULL,
year INTEGER NOT NULL,
type VARCHAR NOT NULL
);

INSERT INTO users VALUES(1,'mieic', 'mieic13feup');
INSERT INTO users VALUES(2,'Contador', 'Baiao');
INSERT INTO users VALUES(3,'F0lha', 'Castro');
