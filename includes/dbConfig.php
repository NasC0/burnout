<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'burnout_poll');

$conn->set_charset('utf8');

mb_internal_encoding('UTF-8');