<?php
$db_conn = new mysqli("localhost","root","tps123","api_assignment");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$method = $_SERVER['REQUEST_METHOD'];
$input = file_get_contents('php://input');


