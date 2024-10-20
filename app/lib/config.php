<?php
//config.php

require_once "database.php";
require_once('app/models/user.php');
require_once('app/models/log.php');
require_once('session.php');
require_once('app/models/post.php');

$db = new Database();
$userModel = new User($db);
$postModel = new Post($db);
$log = new Log($db);
$session = new Session();