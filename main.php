<?php 
    require_once 'src\mf\utils\ClassLoader.php';
    $loader = new \mf\utils\ClassLoader('src');
    $loader->register();
	//use \mecado\model\Utilisateur as Utilisateur;
	require_once 'vendor/autoload.php';
	$config = parse_ini_file("conf/config.ini");
	$db = new Illuminate\Database\Capsule\Manager();
	$db->addConnection( $config );
	$db->setAsGlobal();
	$db->bootEloquent();
	require_once 'src\mf\router\Router.php';
	session_start();
	$router = new \mf\router\Router();
	
	$router->addRoute('home',    '/home/',         '\mecado\control\MecadoController', 'viewHome');
	$router->addRoute('login',    '/login/',         '\mecado\control\MecadoController', 'viewLogin');
	$router->addRoute('deconnexion',    '/deconnexion/',         '\mecado\control\MecadoController', 'deconnexion');
	$router->addRoute('check_login',    '/check_login/',         '\mecado\control\MecadoController', 'checkLogin');
	$router->addRoute('inscription',    '/inscription/',         '\mecado\control\MecadoController', 'viewSignUp');
	$router->addRoute('check_signup',    '/check_signup/',         '\mecado\control\MecadoController', 'checkSignUp');
	$router->addRoute('dashboard','/dashboard/','\mecado\control\MecadoController','viewUserListes');
	$router->addRoute('ajouterListe','/ajouterListe/','\mecado\control\MecadoController','viewNewListe');
	$router->addRoute('insertListe','/insertListe/','\mecado\control\MecadoController','addListe');
	$router->addRoute('modifierListe','/modifierListe/','\mecado\control\MecadoController','viewModifierListe');
	$router->addRoute('setListe','/setListe/','\mecado\control\MecadoController','setListe');
	$router->addRoute('supprimerListe','/supprimerListe/','\mecado\control\MecadoController','deleteListe');
	$router->addRoute('token',    '/token/',         '\mecado\control\MecadoController', 'insertToken');
	
	$router->addRoute('default', 'DEFAULT_ROUTE',  '\mecado\control\MecadoController', 'viewHome');
	$router->run();