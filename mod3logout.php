<?php
	session_start();
	//deletes session
	session_unset();
	session_destroy();
	//logged out page with link to return to log in page
	echo "<!DOCTYPE HTML>
        <html lang=\"en\">
        <head>
            <title>
                Logged Out
            </title>
        </head>
        <p>
			You Are Now Logged Out.
        </p>
        <p>
        	<a href=\"unregistered.php\">Return To Home Page</a>
        </p>
        </html>";
?>