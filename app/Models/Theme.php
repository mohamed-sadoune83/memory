<?php
namespace app\Models;

use Core\Database;

class Theme
{
        public function all(): array
        {
                $sql = "SELECT * FROM themes";
                return Database::getPdo()->query($sql)->fetchAll();
        }
}
