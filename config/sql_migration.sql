# Relations
# ------------------------------------------------------------

CREATE TABLE clubs (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  description tinytext NOT NULL,
  admin int(10) unsigned default ‘0’,
 PRIMARY KEY  (id),
CONSTRAINT clubs_fk_1  FOREIGN KEY (admin) REFERENCES users (id) 	
 	 ON DELETE CASCADE 
 ON UPDATE CASCADE 
   ) ENGINE=InnoDB;

CREATE TABLE clubs_users (
  club_id int(10) unsigned NOT NULL,
  user_id int(10) unsigned NOT NULL,
  PRIMARY KEY  (club_id, user_id),
  KEY user_id (user_id),
  CONSTRAINT clubs_users_fk_1 FOREIGN KEY (user_id) REFERENCES users (id) 
ON DELETE CASCADE ON UPDATE CASCADE , 
  CONSTRAINT clubs_users_fk_2 FOREIGN KEY (club_id) REFERENCES clubs (id) 
ON DELETE CASCADE ON UPDATE CASCADE 
) ENGINE=InnoDB;

CREATE TABLE forums (
  id int(10) unsigned NOT NULL auto_increment,
  club_id int(10) unsigned NOT NULL,
  name varchar(64) NOT NULL default '',
  description tinytext NOT NULL,
  PRIMARY KEY  (id),
  KEY club_id (club_id),
  CONSTRAINT forums_fk_1 FOREIGN KEY (club_id) REFERENCES clubs (id) ON UPDATE CASCADE ON DELETE CASCADE 
) ENGINE=InnoDB;

CREATE TABLE forums_moderators (
  forum_id int(10) unsigned NOT NULL,
  user_id int(10) unsigned NOT NULL,
  PRIMARY KEY  (forum_id, user_id),
  KEY user_id (user_id),
  CONSTRAINT forums_moderators_fk_2 FOREIGN KEY (user_id) REFERENCES users (id)ON DELETE CASCADE ON UPDATE CASCADE  ,
  CONSTRAINT forums_moderators_fk_1 FOREIGN KEY (forum_id) REFERENCES forums (id) ON DELETE CASCADE ON UPDATE CASCADE 
) ENGINE=InnoDB;

CREATE TABLE messages (
  id int(10) unsigned NOT NULL auto_increment,
  sender_id int(10) unsigned NOT NULL,
  recipient_id int(10) unsigned NOT NULL,
  subject varchar(256) NOT NULL default '',
  content text NOT NULL,
	sender_sent tinyint(1) unsigned NOT NULL default '0',
  sender_deleted tinyint(1) unsigned NOT NULL default '0',
  recipient_read tinyint(1) unsigned NOT NULL default '0',
  recipient_deleted tinyint(1) unsigned NOT NULL default '0',
  created_at timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (id),
  KEY sender_id (sender_id),
  KEY recipient_id (recipient_id),
  CONSTRAINT messages_fk_1 FOREIGN KEY (sender_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE ,
  CONSTRAINT messages_fk_2 FOREIGN KEY (recipient_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB;

CREATE TABLE threads (
  id int(10) unsigned NOT NULL auto_increment,
  forum_id int(10) unsigned default NULL,
  parent_id int(10) unsigned default NULL,
  subject varchar(128) default NULL,
  content text NOT NULL,
  user_id int(10) unsigned NOT NULL,	
  created_at timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (id),
  KEY forum_id (forum_id),
  KEY parent_id (parent_id),
  CONSTRAINT threads_fk_1 FOREIGN KEY (forum_id) REFERENCES forums (id) ON DELETE CASCADE ON UPDATE CASCADE  ,
  CONSTRAINT threads_fk_2 FOREIGN KEY (parent_id) REFERENCES threads (id) ON DELETE CASCADE ON UPDATE CASCADE  ,
	CONSTRAINT threads_fk_3 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION
) ENGINE=InnoDB;

CREATE TABLE users (
  id int(10) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password_digest varchar(64) NOT NULL default '',
  full_name varchar(64) NOT NULL default '',
  banned tinyint(1) unsigned NOT NULL default '0',
  admin tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB;

# Insert test records
# ------------------------------------------------------------

# Users
insert into users values (null, 'tester', 'testing', 'Chester Tester', 0, 1);
insert into users values (null, 'debug', 'testing', 'Lady Debug', 0, 0);
insert into users values (null, 'test_anxiety', 'testing', 'Mr. Testanxious', 0, 0);

# Clubs
INSERT INTO 'clubs' VALUES (NULL, 'Club 1', 'Club 1 is the first',);
INSERT INTO 'clubs' VALUES (NULL, 'Club 2', 'Club 2 is after Club 1');

# Forums
INSERT INTO 'forums' VALUES (NULL, '1', 'Test Forum 1', 'Testing Test Forum 1');
INSERT INTO 'forums' VALUES (NULL, '2', 'Test Forum 2', 'Testing Test Forum 2');

# Threads
INSERT INTO 'threads' VALUES (NULL, '1', NULL, 'ROOT Thread 1', 'Thread Root', '1', NULL); # Root
INSERT INTO 'threads' VALUES (NULL, '1', '1', 'Thread 2', 'Just another thread.', '1', NULL);
INSERT INTO 'threads' VALUES (NULL, '1', '1', 'Thread 3', 'Just another thread.', '1', NULL);
INSERT INTO 'threads' VALUES (NULL, '1', '1', 'Thread 4', 'Just another thread.', '2', NULL);
INSERT INTO 'threads' VALUES (NULL, '1', NULL, 'ROOT Thread 5', 'Thread Root', '2', NULL); # Root
INSERT INTO 'threads' VALUES (NULL, '1', '5', 'Thread 6', 'Just another thread.', '1', NULL);
INSERT INTO 'threads' VALUES (NULL, '1', '5', 'Thread 7', 'Just another thread.', '1', NULL);
INSERT INTO 'threads' VALUES (NULL, '1', '5', 'Thread 8', 'Just another thread.', '2', NULL);
INSERT INTO 'threads' VALUES (NULL, '2', NULL, 'ROOT Thread 9', 'Thread Root', '2', NULL); # Root
INSERT INTO 'threads' VALUES (NULL, '2', '9', 'Thread 10', 'Just another thread.', '1', NULL);
INSERT INTO 'threads' VALUES (NULL, '2', '9', 'Thread 11', 'Just another thread.', '2', NULL);
INSERT INTO 'threads' VALUES (NULL, '2', NULL, 'ROOT Thread 12', 'Thread Root', '2', NULL); # Root
INSERT INTO 'threads' VALUES (NULL, '2', '12', 'Thread 13', 'Just another thread.', '2', NULL);
INSERT INTO 'threads' VALUES (NULL, '2', '12', 'Thread 14', 'Just another thread.', '1', NULL);
INSERT INTO 'threads' VALUES (NULL, '2', '12', 'Thread 15', 'Just another thread.', '2', NULL);

# Messages
insert into messages values (null, 1, 2, 'Great party!', 'Hey, thank you for the invite.  I had a great time last night.  Happy Birthday again!', 1, 0, 1, 0, null); # Sent message for 1
insert into messages values (null, 2, 1, 'Re: Great party!', 'It was my pleasure.  Thank you so much for coming.  I loved the gift, thank you.', 1, 0, 0, 0, null); # Sent message for 2, unread
insert into messages values (null, 1, 3, 'Meeting next Wednesday', 'Don\'t forget, we have our quarterly meeting on Wednesday.  Sara is bringing refreshments this time.', 1, 0, 1, 0, null); # Sent message for 1, read 3
insert into messages values (null, 3, 1, 'Re: Meeting next Wednesday', 'I will be there.  I hope Sara brings those delicious pastries!', 1, 0, 0, 0, null); # Sent message for 3, unread 1

# Project queries
# ------------------------------------------------------------

TBD
# For dropping foreign keys use
 alter table table_name drop foreign key foreign_key_name;

# For dropping table (once constraints are removed)
drop table table_name;