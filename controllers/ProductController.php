

<?php

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addProduct($name, $description, $price, $quantity, $marque_id)
    {
        $sql = "INSERT INTO products (name, description, price, quantity, marque_id) VALUES (?, ?, ?, ?, ?)";
        $product = $this->conn->prepare($sql);
        $product->bind_param("ssdii", $name, $description, $price, $quantity, $marque_id);
        $product->execute();
        return $product->insert_id;
    }
}
