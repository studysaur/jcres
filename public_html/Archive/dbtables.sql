#
#  dbtables.sql
#
#  Simplifies the task of creating all the database tables
#  used by the login system.
#
#  Can be run from command prompt by typing:
#
#  mysql -u yourusername -D yourdatabasename < dbtables.sql
#
#  That's with dbtables.sql in the mysql bin directory, but
#  you can just include the path to dbtables.sql and that's
#  fine too.

#
#  Table structure for users table
#
DROP TABLE IF EXISTS users;

CREATE TABLE users (
 username varchar(30) primary key,
 password varchar(32),
 userid varchar(32),
 userlevel tinyint(1) unsigned not null,
 unit_num varchar(3),
 rank varchar(15),
 name varchar(50),
 phone_home varchar(12),
 phone_work varchar(12),
 phone_cell varchar(12),
 email varchar(50),
 timestamp int(11) unsigned not null
);


#
#  Table structure for active users table
#
DROP TABLE IF EXISTS active_users;

CREATE TABLE active_users (
 username varchar(30) primary key,
 timestamp int(11) unsigned not null
);


#
#  Table structure for active guests table
#
DROP TABLE IF EXISTS active_guests;

CREATE TABLE active_guests (
 ip varchar(15) primary key,
 timestamp int(11) unsigned not null
);


#
#  Table structure for banned users table
#
DROP TABLE IF EXISTS banned_users;

CREATE TABLE banned_users (
 username varchar(30) primary key,
 timestamp int(11) unsigned not null
);


