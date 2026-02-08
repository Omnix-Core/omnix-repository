<?php

class Producto
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $image;
    public $category_id;
    public $category_name; // viene de JOIN
    public $created_at;


    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->name;
    }

    public function getDescripcion()
    {
        return $this->description;
    }

    public function getPrecio()
    {
        return $this->price;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getCategoriaId()
    {
        return $this->category_id;
    }

    public function getCategoriaNombre()
    {
        return $this->category_name;
    }

    public function getImagen()
    {
        return $this->image;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }


    public function getPrecioBaseFormateado()
    {
        return number_format($this->price, 2, ',', '.') . ' €';
    }

    public function getPrecioPVP()
    {
        return number_format($this->price * 1.21, 2, ',', '.') . ' €';
    }

    public function hayStock()
    {
        return $this->stock > 0;
    }

    public function getStockTexto()
    {
        if ($this->stock === 0) {
            return 'Agotado';
        }

        if ($this->stock < 5) {
            return 'Últimas unidades';
        }

        return 'En stock';
    }
}
