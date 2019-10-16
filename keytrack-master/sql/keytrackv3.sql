
# create database keytrack - version 3 with mailbox column added - JPI - 5/17/2018

create database keytrack;
use keytrack;

# create tables (using InnoDB engine so it enforces foreign keys.)


# core table, holds the information for key cores
create table core (
	core_id int unsigned not null auto_increment primary key,
	core_num varchar(16) not null unique,
	core_cut varchar(32),
	core_desc varchar(128),
	core_manf varchar(32),
	core_insertdt datetime default CURRENT_TIMESTAMP,
	core_notes text,
	core_diagram tinytext,
	core_is_act tinyint default 1,
	core_type varchar(32) not null
)
ENGINE InnoDB;

# keyholder table holds info on keyholders that receive keys
create table keyholder (
	hold_id int unsigned not null auto_increment primary key, 
	hold_name varchar(128),
	hold_fname varchar(32),
	hold_lname varchar(32),
	hold_ident varchar(32),
	hold_desc varchar(128),
	hold_insertdt datetime default CURRENT_TIMESTAMP,
	hold_email varchar(128),
	hold_phone varchar(20),
	hold_notes text,
	hold_is_act tinyint default 1,
	hold_type varchar(32) not null
)
ENGINE InnoDB;

#  key table holds all data related to physical keys and also connects to the core table when the key is related to a USA core.
create table ktkey (
	key_id int unsigned not null auto_increment primary key,
	key_name varchar(64),
	key_number varchar(8) not null unique,
	key_insertdt datetime default CURRENT_TIMESTAMP,
	key_notes text,
	key_is_act tinyint default 1,
	key_type varchar(32) not null,
	core_id int unsigned,
	foreign key (core_id)
	references core(core_id)
	on update cascade
	on delete set null
)
ENGINE InnoDB;

# building table used to store buildings and property data for that building
create table building (
	bldg_id int unsigned not null auto_increment primary key,
	bldg_num varchar(16) not null unique,
	bldg_desc varchar(128),
	bldg_prop varchar(32) not null,
	bldg_notes text,
	bldg_is_act tinyint default 1
)
ENGINE InnoDB;

# user table contains all info on users of keytrack
create table ktuser (
	user_id int unsigned not null auto_increment primary key,
	user_name varchar(16) unique,
	user_pass varchar(128),
	user_fname varchar(32),
	user_lname varchar(32),
	user_email varchar(128),
	user_phone varchar(20),
	user_unid char(8),
	user_type varchar(32) not null default 'User',
	user_insertdt datetime default CURRENT_TIMESTAMP,
	user_is_act tinyint default 1
)
ENGINE InnoDB;

#  location table holds all data related to locations that a key gets assigned to
create table location (
	loc_id int unsigned not null auto_increment primary key,
	loc_unit_num varchar(16),
	loc_desc varchar(128),
	loc_insertdt datetime default CURRENT_TIMESTAMP,
	loc_notes text,
	loc_is_act tinyint default 1,
	loc_type varchar(32) not null,
	bldg_id int unsigned,
	foreign key (bldg_id)
	references building(bldg_id)
	on update cascade
	on delete set null,
	loc_mailbox varchar(32),
	loc_mail_core varchar(32)
)
ENGINE InnoDB;

#  key_loc table connects keys and users to locations for core-key-location relationships
create table key_loc (
	key_loc_id int unsigned not null auto_increment primary key,
	key_loc_startdt datetime not null,
	key_loc_enddt datetime,
	key_loc_qty tinyint,
	key_loc_lost_qty tinyint,
	key_loc_lostdt datetime,
	key_loc_lost_return tinyint,
	key_id int unsigned,
	foreign key (key_id)
	references ktkey(key_id)
	on update cascade
	on delete set null,
	loc_id int unsigned,
	foreign key (loc_id)
	references location(loc_id)
	on update cascade
	on delete set null,
	user_id int unsigned,
	foreign key (user_id)
	references ktuser(user_id)
	on update cascade
	on delete set null
)
ENGINE InnoDB;

#  key_bldg table connects keys and users to buildings for key-building level relationships
create table key_bldg (
	key_bldg_id int unsigned not null auto_increment primary key,
	key_bldg_startdt datetime not null,
	key_bldg_enddt datetime,
	key_bldg_qty tinyint,
	key_bldg_lost_qty tinyint,
	key_bldg_lostdt datetime,
	key_bldg_lost_return tinyint,
	key_id int unsigned,
	foreign key (key_id)
	references ktkey(key_id)
	on update cascade
	on delete set null,
	bldg_id int unsigned,
	foreign key (bldg_id)
	references building(bldg_id)
	on update cascade
	on delete set null,
	user_id int unsigned,
	foreign key (user_id)
	references ktuser(user_id)
	on update cascade
	on delete set null
)
ENGINE InnoDB;

#  checkout table creates checkout baskets and connects key checkout records and users to keyholders 
create table checkout (
	checkout_id int unsigned not null auto_increment primary key,
	checkout_startdt datetime not null,
	checkout_enddt datetime,
	checkout_duedt datetime,
	hold_id int unsigned,
	foreign key (hold_id)
	references keyholder(hold_id)
	on update cascade
	on delete set null,
	user_id int unsigned,
	foreign key (user_id)
	references ktuser(user_id)
	on update cascade
	on delete set null
)
ENGINE InnoDB;

#  key_checkout table connects keys to checkout baskets for key checkouts
create table key_checkout (
	key_check_id int unsigned not null auto_increment primary key,
	key_check_qty tinyint,
	key_check_lost_qty tinyint,
	key_check_lostdt datetime,
	key_check_lost_return datetime,
	key_id int unsigned,
	foreign key (key_id)
	references ktkey(key_id)
	on update cascade
	on delete set null,
	checkout_id int unsigned,
	foreign key (checkout_id)
	references checkout(checkout_id)
	on update cascade
	on delete set null
)
ENGINE InnoDB;
