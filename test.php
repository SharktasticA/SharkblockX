<?php
        
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

include($_SERVER["DOCUMENT_ROOT"].'/resources/applets/SharkblockX.php');

$page = new SbXProcessor("Test", "en-gb", "UTF-8", "http://localhost:80/", false, true);

$page->draw();