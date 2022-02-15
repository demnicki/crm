<?php
namespace App;
require_once 'vendor/autoload.php';
session_start();
$obj = new ServicesRouting;
$obj->routing();
