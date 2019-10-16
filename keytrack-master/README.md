# keytrack
keytrack

University Student Apartments Keytrack Database and Checkout System

10.16.19
Sample data and proprietary images removed or altered to allow code for public viewing, and ensure proper secured data is not accessible 

Version 1.0 
(Live date: 7.10.18)

Common Folder -
	All files in this folder are the common shared files for all the other PHP files in the system. Standard scripts for login, session time out, footer, header, and other formatting things are in this folder.
	
	Functions.php is the file that retains all the function scripts for everything in the system, in a single contained location. Each of the functions in the file has been commented to describe what the function does.
	
CSS folder -
	Contains the css styles sheet for the system.
	
img folder -
	This folder contains the graphics used for the format of the user interface.
	
	This folder will also contain the subfolder for all the core diagrams that will be uploaded at later dates. Currently there is an image space holder to verify the pixel size of the graphic that can be displayed. 
	
admin_ files -
	These files are php pages that are accessible to the admin users for admin only functions. Resetting passwords; adding/editing keys/cores, locations, buildings, etc.; disabling records or users from use; and multiple reporting functions available.
	
user files -
	files without an "admin_" prefix are either user/view only level pages or common accessibility files.
	
	common accessibility - 
		logincheck - php file to process login credentials.
		logout - logout landing page after signing out of the session.
		index - main landing page upon login.
		notauth - redirect page for attempting to access a page without authorization.
		updatemyprofile - profile update page to change/update user information.
		signingform - page that precedes the printout form for signature.
		myprofile - view page to see current profile details.
	
	user/view only - 
		landingcheckout - landing page to process a key checkout.
		landingviewkc - landing page to view the keys/cores listings.
		retrievecores - list page that displays all cores in the database.
		retrievekeys - list page that displays all keys in the database.
		retrievelocations - list page that displays all the locations in the database.
		
Database Entry:
	6.18.18: all cores and keys have been entered into the database for the system.
	7.5.18: existing keyholders associated with keys up to date
	
	
