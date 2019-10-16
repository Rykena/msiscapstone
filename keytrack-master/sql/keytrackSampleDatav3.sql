
# keytrack sample data with checkout table data, run after DB create script - version 3 - JPI - 5/17/2018 - Sample data altered for public viewing RKN 10/16/19

use keytrack;


# insert sample data into core table
INSERT INTO core(core_num,core_cut,core_desc,core_manf,core_notes,core_diagram,core_type) 
VALUES('ABC901','3746-7-918',NULL,NULL,NULL,NULL,'Apartment');
INSERT INTO core(core_num,core_cut,core_desc,core_manf,core_notes,core_diagram,core_type) 
VALUES('XYZ123','5894-423-9',NULL,NULL,NULL,NULL,'Apartment');
INSERT INTO core(core_num,core_cut,core_desc,core_manf,core_notes,core_diagram,core_type) 
VALUES('678VWX','7-5736-093',NULL,NULL,NULL,NULL,'Pet/Office');
INSERT INTO core(core_num,core_cut,core_desc,core_manf,core_notes,core_diagram,core_type) 
VALUES('345CDE','58-2942-17',NULL,NULL,NULL,NULL,'Building');


# insert sample data into keyholder table
INSERT INTO keyholder(hold_name,hold_fname,hold_lname,hold_ident,hold_desc,hold_email,hold_phone,hold_notes,hold_type) 
VALUES('Building Staff','George','Clooney',NULL,NULL,NULL,NULL,NULL,'Employee');
INSERT INTO keyholder(hold_name,hold_fname,hold_lname,hold_ident,hold_desc,hold_email,hold_phone,hold_notes,hold_type) 
VALUES('Grounds Department','Michael','Keaton',NULL,NULL,NULL,NULL,NULL,'Employee');
INSERT INTO keyholder(hold_name,hold_fname,hold_lname,hold_ident,hold_desc,hold_email,hold_phone,hold_notes,hold_type) 
VALUES('Contractor','Val','Kilmer',NULL,NULL,NULL,NULL,NULL,'Vendor');


# insert sample system users into ktuser table
INSERT INTO ktuser(user_name,user_pass,user_fname,user_lname,user_email,user_phone,user_unid,user_type) 
VALUES('u0374544','920688bd88d6a1ba0e177f17bdf6dddd','Ryan','Nakamura','ryan.nakamura@utah.edu','8015552652','00374544','Admin');
INSERT INTO ktuser(user_name,user_pass,user_fname,user_lname,user_email,user_phone,user_unid,user_type) 
VALUES('admin','920688bd88d6a1ba0e177f17bdf6dddd','Test','Admin','rykena@liamgtest.com','8015552652','10000000','Admin');
INSERT INTO ktuser(user_name,user_pass,user_fname,user_lname,user_email,user_phone,user_unid,user_type) 
VALUES('user','920688bd88d6a1ba0e177f17bdf6dddd','Test','User','nakaryke@testuser.com','8015552652','90000000','User');

	
# insert sample data into building table
INSERT INTO building(bldg_num,bldg_desc,bldg_prop,bldg_notes) 
VALUES('500B','500 Court B Building','Aspen',NULL);
INSERT INTO building(bldg_num,bldg_desc,bldg_prop,bldg_notes) 
VALUES('1000A','1000 Court A Building','Cedar West',NULL);
INSERT INTO building(bldg_num,bldg_desc,bldg_prop,bldg_notes) 
VALUES('1100D','1100 Court D Building','Cedar East',NULL);
INSERT INTO building(bldg_num,bldg_desc,bldg_prop,bldg_notes) 
VALUES('700A','700 Court A Building','Cedar West',NULL);
INSERT INTO building(bldg_num,bldg_desc,bldg_prop,bldg_notes) 
VALUES('775','775 Building','Cedar West',NULL);

	
# insert sample data into ktkey table
INSERT INTO ktkey(key_name,key_number,key_notes,key_type,core_id)
VALUES('XYZ123','XYZ123',NULL,'Apartment',2);
INSERT INTO ktkey(key_name,key_number,key_notes,key_type,core_id)
VALUES('345CDE','345CDE',NULL,'Building',4);


# insert sample data into location table
INSERT INTO location(loc_unit_num,loc_desc,loc_notes,loc_type,bldg_id,loc_mailbox,loc_mail_core)
VALUES('0713','Cedar West Apartment 713',NULL,'Apartment',4,'08-05','4375XR');

	
# insert sample data into key_bldg table
INSERT INTO key_bldg(key_bldg_startdt,key_bldg_enddt,key_bldg_qty,key_bldg_lost_qty,key_bldg_lostdt,key_bldg_lost_return,key_id,bldg_id,user_id)
VALUES('2001-05-11 11:57:09',NULL,NULL,NULL,NULL,NULL,2,5,1);

# insert sample data into checkout table
INSERT INTO checkout(checkout_startdt,checkout_enddt,checkout_duedt,hold_id,user_id)
VALUES('2001-12-13 12:00:00',NULL,NULL,3,1);

# insert sample data into key_checkout table
INSERT INTO key_checkout(key_check_qty,key_check_lost_qty,key_check_lostdt,key_check_lost_return,key_id,checkout_id)
VALUES(1,NULL,NULL,NULL,2,1);

# insert sample data into key_loc table
INSERT INTO key_loc(key_loc_startdt,key_loc_enddt,key_loc_qty,key_loc_lost_qty,key_loc_lostdt,key_loc_lost_return,key_id,loc_id,user_id)
VALUES('2015-10-01 12:00:00',NULL,2,NULL,NULL,NULL,1,1,1);
