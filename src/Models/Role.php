<?php

declare(strict_types=1);

namespace CMS\Models;

use PDO;

class Role extends BaseModel
{
    public function getByName(string $name): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM roles WHERE name = :name LIMIT 1');
        $stmt->execute([':name' => $name]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
