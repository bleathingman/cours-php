<?php


class Router
{    
    public function __construct()// se lance à l'instanciation de la classe
    {
        $this->init();// on appelle la méthode init
    }

    public function init()
    {
        $controllersBasePath = 'controllers/'; // on défini le chemin du dossier controllers
        $availableRouteNames = array_keys(AVAILABLE_ROUTES);// on récupère les clefs de la constante route (route.php)
        if (!isset($_GET['page']) || !in_array($_GET['page'], $availableRouteNames, true)) { // on vérifie s'il y'a un param page dans l'url et sil est dans les routes disponibles
            
            if(realpath($controllersBasePath . DEFAULT_ROUTE.'.php')){ // si le chemin de la route par défaut existe                           
                require realpath($controllersBasePath . DEFAULT_ROUTE.'.php');// on charge le fichier du controller par défaut
                $controllerName = DEFAULT_ROUTE; // on créer la variable avec le nom de la route par défaut
                $controller =  new $controllerName(); // on instancie le controller par défaut              

            }else{
                echo '404 not found'; // si le chemin du fichier n'existe pas on affiche erreur 404
            }       
        }else{ // sinon si le param page est bon                                
            require realpath($controllersBasePath . AVAILABLE_ROUTES[$_GET['page']].'.php');// on charge le bon fichier en fonction du param page dans l'url et de la constante AVAILABLE_ROUTES
            $controllerName = AVAILABLE_ROUTES[$_GET['page']];// on créer une variable avec le le bon nom de controller en fonction du param page 
            $controller =  new $controllerName();// on instancie le bon controller  
        }
        return $controller; // dans tous les cas on retourne un instance du bon controller
    }
}
