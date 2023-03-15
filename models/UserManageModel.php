<?php

class UserManageModel
{
    private $pwd;
    private $mail;
    private $nickname;
    public function __construct() // le constrcuteur est lancé automatiquement à l'instanciation
    {
        $this->checkForm(); // on appelle automatiquement la méthode checkform
    }
    public function checkForm()
    {
        // checkform s'occupe de définir si c'est le formulaire d'inscription ou de connexion qui est envoyé
        if (isset($_POST['register'])) { // si c'est l'inscription
            if (isset($_POST['pwd']) && !empty($_POST['pwd']) && isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['nickname']) && !empty($_POST['nickname'])) {
                // on alimente les attributs avec les valeurs du formulaire
                $this->pwd = $_POST['pwd'];
                $this->mail = $_POST['mail'];
                $this->nickname = $_POST['nickname'];
                $this->createUser(); // on appelle la méthode créate user
            } else {
                echo "Il y a des erreurs dans le formulaire, veuillez vérifier les champs";
            }
        }
        if (isset($_POST['login'])) { // si c'est le formulaire de connexion
            if (isset($_POST['pwd']) && !empty($_POST['pwd']) && isset($_POST['mail']) && !empty($_POST['mail'])) {
                // on alimente les attributs avec les valeurs du formulaire
                $this->pwd = $_POST['pwd'];
                $this->mail = $_POST['mail'];
                $this->connectUser(); // on apelle la méthode connectUser                
                if ($this->connectUser()) { // si connectUser renvoie true
                    session_start(); // on lance un session_start
                    $_SESSION['user'] = $this->mail;  // on crée la session user avec l'email
                    header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?page=admin'); // on redirige vers l'interface d'admin
                    echo '<div class="alert alert-success" role="alert">utilisateur connecté</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">utilisateur introuvable</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Il y a des erreurs dans le formulaire, veuillez vérifier les champs</div>';
            }
        }
    }

    public function createUser()
    {
        $db = new DBConnection(); // connexion bdd
        $conn = $db->connect();
        // préparation de la requête d'insertion de l'utilisateur dans la bdd        
        $query = "INSERT INTO users (email, name, password) VALUES (:email, :username, :password)";
        // on hash le mdp, impératif
        $hashed_password = password_hash($this->pwd, PASSWORD_BCRYPT);
        $stmt = $conn->prepare($query);
        // on bind les param de la requête pour éviter les injections sql, impératif
        $stmt->bindParam(':email', $this->mail);
        $stmt->bindParam(':username', $this->nickname);
        $stmt->bindParam(':password', $hashed_password);
        if ($stmt->execute()) { // on execute dans le if. TRUE on success or FALSE on failure
            echo '<div class="alert alert-success" role="alert">inscription réussie, vous pouvez vous connecter</div>';
        } else {
            echo "<div class='alert alert-danger' role='alert'>l'inscription à échouée</div>";
        }
    }

    public function connectUser()
    {
        $db = new DBConnection(); // connexion bdd
        $conn = $db->connect();
        // préparation de la requête
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        // on bind les param de la requête pour éviter les injections sql, impératif
        $stmt->bindParam(':email', $this->mail);
        $stmt->execute();
        // on récupère la data retournée par pdo
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) { // si y'a pas de data on retourne false
            return false;
        }
        if (password_verify($this->pwd, $user['password'])) { // on utilise la fonction php password_verify pour checker le mdp côté form + bdd
            return true;
        } else {
            return false;
        }
        // dans tous les cas on retourne true ou false pour la connexion
    }
}
