<?php
class ConnexionController
{
    public function __construct()
    {
        $this->index();
    }

    public function index()
    {
        require './models/UserManageModel.php'; // on charge le bon model
        $userManageModel = new UserManageModel(); // on l'instancie
        require './views/connexion.phtml'; // on charge la bonne vue
    }
}
