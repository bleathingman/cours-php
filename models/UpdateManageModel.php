<?php

class UpdateManageModel
{

    public $products;

    public function __construct()
    {
        $this->getproducts();
        $this->checkAction();
    }

    public function getproducts()
    {

        // Récupération de l'ID
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
        }

        // connexion bdd
        $db = new DBConnection();
        $conn = $db->connect();

        // préparation de la requête d'insertion de l'utilisateur dans la bdd  
        $query = "SELECT * FROM products WHERE id = :id";
        $getproducts = $conn->prepare($query);

        $param = array(
            ":id" => $id
        );

        if ($getproducts->execute($param)) { // on execute dans le if. TRUE on success or FALSE on failure
            $this->products = $getproducts->fetchAll();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erreur : Produits non récupérés</div>";
        }
    }

    public function checkAction()
    {
        // connexion bdd
        $db = new DBConnection();
        $conn = $db->connect();

        if (isset($_POST['update']) && !empty($_POST['update'])) {

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id = $_GET['id'];
            }

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



            // préparation de la requête d'insertion de l'utilisateur dans la bdd 
            $updateQuery = "UPDATE productss SET name=:name, price=:price, description=:description, quantity=:quantity, marque_id=:marque_id WHERE id = :id";
            $update = $conn->prepare($updateQuery);

            // configuration des params 
            $params = array(
                ':name' => $name,
                ':price' => $price,
                ':description' => $description,
                ':quantity' => $quantity,
                ':marque_id' => $marque_id,
                ':id' => $id
            );

            // on execute dans le if. TRUE on success or FALSE on failure
            if ($update->execute($params)) {
                echo "<div class='alert alert-success' role='alert'>Produit ajouté  avec succèes</div>";
                header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?page=admin'); // on redirige vers l'interface d'admin                  
            } else {
                echo "<div class='alert alert-danger' role='alert'>Erreur : Produit non ajouté</div>";
            }
        }
    }
}
