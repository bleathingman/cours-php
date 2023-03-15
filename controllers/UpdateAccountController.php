<?php
class UpdateAccountController
{

    public function __construct()
    {
        $this->index();
    }

    public function index()
    {
        require './models/UpdateAccountManageModel.php';
        require './models/UserManageModel.php';
        $registerModel = new UpdateAccountManageModel();
        require './views/updateAccount.phtml';
    }
}
