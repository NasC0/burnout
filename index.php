<?php
require 'includes/functions.php';

$content = array();

$content['title'] = "Има ли burnout в IT сектора?";

$content['body'] = 'templates/index_default.php';

renderHTML($content, 'templates/layout/default_layout.php');