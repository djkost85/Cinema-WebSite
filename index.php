<?php

require_once('class/kernel/Application.php');

$app = new Application();

$app->generateHTML();
$app->display("tpl/");