<?php
class UpdateController
{

    public function __construct() // le constructeur se lance automatiquement
    {
        $this->index(); //il appelle la méthode index
    }

    public function index()
    {
        require './models/UpdateManageModel.php'; // on charge le bon model
        $updateModel = new UpdateManageModel(); // on l'instancie
        if (!empty($_SESSION['user'])) { // si la session n'est pas vide
            require './views/updateProduct.phtml'; // puis on charge le bonne vue
        } else { // sinon on renvoie un message d'erreur
            echo "Vous n'êtes pas autorisés à accéder à cette page sans être connecté";
        }
    }
}
