<?php

require_once __DIR__ . '/../libs/Model.php';
require_once __DIR__ . '/Product.php';

class ProductRepository extends Model
{
    /**
     * Obtiene todos los productos con su categoría
     * (listado principal)
     */
    public function findAll()
    {
        $sql = "
            SELECT 
                p.*, 
                c.name AS category_name
            FROM products p
            INNER JOIN categories c ON c.id = p.category_id
            ORDER BY p.created_at DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    /**
     * Obtiene un producto por ID
     */
    public function findById(int $id)
    {
        $sql = "
            SELECT 
                p.*, 
                c.name AS category_name
            FROM products p
            INNER JOIN categories c ON c.id = p.category_id
            WHERE p.id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject('Producto');
    }

    /**
     * Productos por categoría
     * (filtros y navegación)
     */
    public function findByCategory(int $categoryId)
    {
        $sql = "
            SELECT 
                p.*, 
                c.name AS category_name
            FROM products p
            INNER JOIN categories c ON c.id = p.category_id
            WHERE p.category_id = :category
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':category' => $categoryId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    /**
     * Búsqueda por texto (buscador)
     */
    public function search(string $text)
    {
        $sql = "
            SELECT 
                p.*, 
                c.name AS category_name
            FROM products p
            INNER JOIN categories c ON c.id = p.category_id
            WHERE p.name LIKE :text
               OR p.description LIKE :text
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':text' => '%' . $text . '%']);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    /**
     * Inserta producto (admin)
     */
    public function create(Producto $p)
    {
        $sql = "
            INSERT INTO products
            (name, description, price, stock, image, category_id)
            VALUES
            (:name, :description, :price, :stock, :image, :category)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name'        => $p->getNombre(),
            ':description' => $p->getDescripcion(),
            ':price'       => $p->getPrecio(),
            ':stock'       => $p->getStock(),
            ':image'       => $p->getImagen(),
            ':category'    => $p->getCategoriaId()
        ]);
    }

    /**
     * Actualiza producto
     */
    public function update(Producto $p)
    {
        $sql = "
            UPDATE products SET
                name = :name,
                description = :description,
                price = :price,
                stock = :stock,
                image = :image,
                category_id = :category
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name'        => $p->getNombre(),
            ':description' => $p->getDescripcion(),
            ':price'       => $p->getPrecio(),
            ':stock'       => $p->getStock(),
            ':image'       => $p->getImagen(),
            ':category'    => $p->getCategoriaId(),
            ':id'          => $p->getId()
        ]);
    }

    /**
     * Elimina producto
     */
    public function delete(int $id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM products WHERE id = :id"
        );

        return $stmt->execute([':id' => $id]);
    }

    /**
     * Comprueba stock (carrito)
     */
    public function hasStock(int $productId, int $cantidad)
    {
        $stmt = $this->db->prepare(
            "SELECT stock FROM products WHERE id = :id"
        );
        $stmt->execute([':id' => $productId]);

        $stock = $stmt->fetchColumn();
        return $stock !== false && $stock >= $cantidad;
    }
}
