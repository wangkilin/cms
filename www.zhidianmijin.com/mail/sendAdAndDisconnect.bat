@ECHO OFF

ECHO.
ECHO #######  Restarting Sending Ad  #######
ECHO.

php -f ./sendHtmlEmail.php

ECHO.
ECHO #######  Finish Sending Ad  #######
ECHO.

ECHO.
ECHO ....... Starting disconnect network 
ECHO.

rasdial /disconnect

ECHO. quit sending AD

@ECHO ON