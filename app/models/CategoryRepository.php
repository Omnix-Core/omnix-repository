<?php

require_once __DIR__ . '/../libs/Model.php';
require_once __DIR__ . '/Category.php';

class CategoryRepository extends Model
{
    public function findAll()
    {
        $sql = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM categories WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject('Category');
    }
}
