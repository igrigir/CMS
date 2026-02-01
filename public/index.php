<?php
require_once __DIR__ . '/../vendor/autoload.php';

use CMS\Controllers\TestController;
use CMS\Services\Database;

Database::getConnection();

echo "DB je konektovan";
