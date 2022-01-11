<?php

include($_SERVER["DOCUMENT_ROOT"].'/resources/applets/SharkblockX.php');

$page = new SbXProcessor("Test", "en-GB", "UTF-8", "http://localhost:80/", false, true);

$page->draw();