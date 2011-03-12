<?php
require_once("lib/log4php/Logger.php");
require_once('class/kernel/Application.php');

//initialisation Logger
Logger::configure('resources/Logger.properties');

$app = new Application();

$app->generateHTML();
$app->display("tpl/");