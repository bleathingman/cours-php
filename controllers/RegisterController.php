<?php
class RegisterController
{

    public function __construct() // le constructeur se lance automatiquement
    {
        $this->index(); //il appelle la méthode index
    }

    public function index()
    {
        require './models/UserManageModel.php'; // on charge le bon model
        $registerModel = new UserManageModel(); // on l'instancie
        require './views/register.phtml'; // puis on charge le bonne vue
    }
}
