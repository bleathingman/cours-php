<?php

class ProductModel
{
    private $name;
    private $description;
    private $price;

    public function __construct()
    {
        $this->checkForm(); // Vérifie le formulaire lors de la création de l'objet
    }

    public function checkForm()
    {
        if (isset($_POST['add_product'])) { // Si le formulaire est soumis
            if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['description']) && !empty($_POST['description']) && isset($_POST['price']) && !empty($_POST['price'])) { // Si tous les champs requis sont remplis
                $this->name = $_POST['name']; // Récupère le nom du produit
                $this->description = $_POST['description']; // Récupère la description du produit
                $this->price = $_POST['price']; // Récupère le prix du produit
                $this->createProduct(); // Appelle la fonction createProduct pour ajouter le produit à la base de données
            } else {
                echo "Il y a des erreurs dans le formulaire, veuillez vérifier les champs"; // Affiche un message d'erreur si des champs requis sont manquants ou vides
            }
        }
    }

    public function createProduct()
    {
        $db = new DBConnection();
        $conn = $db->connect();
        $query = "INSERT INTO products (name, description, price) VALUES (:name, :description, :price)"; // Prépare la requête SQL pour insérer un produit dans la table products
        $stmt = $conn->prepare($query); // Prépare la requête
        $stmt->bindParam(':name', $this->name); // Lie le nom du produit au paramètre :name dans la requête
        $stmt->bindParam(':description', $this->description); // Lie la description du produit au paramètre :description dans la requête
        $stmt->bindParam(':price', $this->price); // Lie le prix du produit au paramètre :price dans la requête
        if ($stmt->execute()) { // Exécute la requête
            echo '<div class="alert alert-success" role="alert">Produit ajouté avec succès!</div>'; // Affiche un message de succès si l'insertion s'est bien déroulée
        } else {
            echo "<div class='alert alert-danger' role='alert'>Impossible d'ajouter le produit</div>"; // Affiche un message d'erreur si l'insertion a échoué
        }
    }
}
