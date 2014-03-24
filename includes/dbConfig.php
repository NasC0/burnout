<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'burnout_poll');

error_reporting(E_ALL);

$conn->set_charset('utf8');

mb_internal_encoding('UTF-8');