<?php
//Point d'entrée, chargement des fichiers nécéssaires au démarrage
require './config/Database.php';
require './config/routes.php';
require 'router.php';
require './views/layout.phtml';