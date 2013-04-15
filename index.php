<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
define('DS', DIRECTORY_SEPARATOR);
define('_', '_');
define('PHP', '.php');
date_default_timezone_set('America/New_York');

require_once('supa/mediator.php');

$site = new supa_mediator();
$site->getModule('do')->action();
$site->getModule('front')->control();
$site->getModule('response')->send();

//echo $site->view('panels/debug')->toHtml();