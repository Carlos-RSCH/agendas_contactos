<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/config/db.php';
require __DIR__ . '/lib/helpers.php';
require __DIR__ . '/lib/ContactRepository.php';

$contactRepo = new ContactRepository($pdo);
