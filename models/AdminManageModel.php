<?php

class AdminManageModel
{

    public $product;

    public function __construct()
    {
        $this->getProducts();
        $this->checkAction();
    }

    public function getProducts()
    {
        $db = new DBConnection(); // connexion bdd
        $conn = $db->connect();
        // préparation de la requête d'insertion de l'utilisateur dans la bdd  
        $query = "SELECT * FROM products";
        $stmt = $conn->prepare($query);
        if ($stmt->execute()) { // on execute dans le if. TRUE on success or FALSE on failure
            $this->product = $stmt->fetchAll();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erreur : Produits non récupérés</div>";
        }
    }

    public function checkAction()
    {
        if (isset($_POST['delete']) && !empty($_POST['delete'])) {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $id = $_POST['id'];
            }
            $db = new DBConnection(); // connexion bdd
            $conn = $db->connect();
            // préparation de la requête d'insertion de l'utilisateur dans la bdd  
            $query = "DELETE FROM products WHERE id = :id";
            $delete = $conn->prepare($query);
            $params = [
                ":id" => $id
            ];
            if ($delete->execute($params)) { // on execute dans le if. TRUE on success or FALSE on failure
                echo "<div class='alert alert-success' role='alert'>Produit supprimé avec succèes</div>";
                header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?page=admin'); // on redirige vers l'interface d'admin                  
            } else {
                echo "<div class='alert alert-danger' role='alert'>Erreur : Produit non supprimé</div>";
            }
        } else if (isset($_POST['add']) && !empty($_POST['add'])) {
            $name = '';
            $price = 1;
            $description = '';
            $quantity = 1;
            $marque_id = 1;

            // traitement des champs du formulaire
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = $_POST['name'];
            }
            if (isset($_POST['price']) && !empty($_POST['price'])) {
                $price = $_POST['price'];
            }
            if (isset($_POST['description']) && !empty($_POST['description'])) {
                $description = $_POST['description'];
            }
            if (isset($_POST['quantity']) && !empty($_POST['quantity'])) {
                $quantity = $_POST['quantity'];
            }
            if (isset($_POST['marque_id']) && !empty($_POST['marque_id'])) {
                $marque_id = $_POST['marque_id'];
            }

            // connexion bdd
            $db = new DBConnection();
            $conn = $db->connect();

            // préparation de la requête d'insertion de l'utilisateur dans la bdd  
            $addQuery = "INSERT INTO products (name, price, description, quantity, marque_id) VALUES (:name, :price, :description, :quantity, :id_marque)";
            $add = $conn->prepare($addQuery);

            // configuration des params 
            $params = array(
                ':name' => $name,
                ':price' => $price,
                ':description' => $description,
                ':quantity' => $quantity,
                ':id_marque' => $marque_id
            );

            // on execute dans le if. TRUE on success or FALSE on failure
            if ($add->execute($params)) {
                echo "<div class='alert alert-success' role='alert'>Succès</div>";
                header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?page=admin'); // on redirige vers l'interface d'admin                  
            } else {
                echo "<div class='alert alert-danger' role='alert'>Erreur : ça n'a pas fonctionner </div>";
            }
        }
    }
}
