<?php
        
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

include($_SERVER["DOCUMENT_ROOT"].'/resources/applets/SharkblockX.php');

$page = new SbXProcessor("Test Page", "en-gb", "UTF-8", "http://localhost:80/", false, true);

$page->add_favicon("https://sharktastica.co.uk/favicon.png");

$page->add_twitter_card(
    "summary",
    "Test Page",
    "A test page for SbXProcessor",
    "https://sharktastica.co.uk/favicon.png",
    "@AdmSharksKeebs",
    "@AdmSharksKeebs"
);

$page->add_open_graph(
    "website",
    "Test Page",
    "Test Site",
    "A test page for SbXProcessor",
    "en_gb",
    "https://sharktastica.co.uk/favicon.png",
    "http://localhost:80/"
);

$page->add_stylesheet("test.css");
$page->add_inline_style("* { color: #DDD; }");
$page->add_ext_script("test.js");
$page->add_int_script("console.log('Internal page script test!');");

$page->draw();