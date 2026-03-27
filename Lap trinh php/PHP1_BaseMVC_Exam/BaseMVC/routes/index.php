<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
    'add'  => (new HomeController)->add(),
    'stor' => (new HomeController)->stor(),
};