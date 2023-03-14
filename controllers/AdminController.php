<?php
class AdminController
{
    public function __construct()
    {
        $this->index();
    }

    public function index()
    {
        require './models/AdminManageModel.php'; // on charge le bon model
        $adminManager = new AdminManageModel(); // on l'instancie
        if (!empty($_SESSION['user'])) { // si la session n'est pas vide
            require './views/admin.phtml'; // on charge la vue admin
        } else { // sinon on renvoie un message d'erreur
            echo "Vous n'êtes pas autorisés à accéder à cette page sans être connecté";
        }
    }
}
