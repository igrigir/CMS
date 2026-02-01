<?php

declare(strict_types=1);

namespace CMS\Models;

use PDO;
use CMS\Services\Database;

abstract class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}
