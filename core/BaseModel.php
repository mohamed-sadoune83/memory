<?php
namespace Core;

class BaseModel
{
        protected $db;

        public function __construct()
        {
                $this->db = Database::getPdo();
        }
}
