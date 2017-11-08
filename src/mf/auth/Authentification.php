<?php

namespace mf\auth;

class Authentification extends AbstractAuthentification{
	/* Le constructeur: 
	* 
	* Faire le lien entre la variable de session et les attributs de la classe
	*
	*   La variables de session sont les suivante : 
	*    - $_SESSION['user_login'] 
	*    - $_SESSION['access_level'] 
	*    
	*  Algorithme :
	* 
	*  Si la variable de session 'user_login' existe 
	* 
	*     - renseigner l'attribut $this->user_login avec sa valeur 
	*     - renseigner l'attribut $this->access_level avec la valeur de 
	*       la variable de session 'access_level'
	*     - mettre l'attribut $this->logged_in a vrai
	*
	*  sinon 
	*     - mettre les valeurs null, ACCESS_LEVEL_NONE et false respectivement 
	*       dans les trois attribut.
	*
	*/
	public function __construct(){
		if(isset($_SESSION['user_login'])){
			$this->user_login=$_SESSION['user_login'];
			$this->logged_in=true;
		}else{
			$this->user_login=null;
			$this->logged_in=false;
		}
	}


	/* La mÃ©thode updateSession : 
	*
	* MÃ©thode pour enregistrer la connexion d'un utilisateur dans la session 
	*
	* ATTENTION : cette mÃ©thode n'est appelÃ©e uniquement quand la connexion 
	*             rÃ©ussie
	*
	* @param String : $username, le login de l'utilisateur  
	* @param String : $level, le niveau d'accÃ¨s
	*
	*  Algorithme:
	*    - renseigner l'attribut $this->user_login avec le paramÃ¨tre $username 
	*    - renseigner l'attribut $this->access_level avec $level
	*
	*    - renseigner $_SESSION['user_login']  $username
	*    - renseigner $_SESSION['access_level'] $level

	*    - mettre l'attribut $this->logged_in Ã  vrai
	*
	*/

	public function updateSession($username){
		$this->user_login=$username;
		$_SESSION['user_login']=$username;
		$this->logged_in=true;
	}

	/* la mÃ©thode logout :
	* 
	* MÃ©thode pour effectuer la dÃ©connexion : 
	*
	* Algorithme :
	*
	*  - Effacer les variables $_SESSION['user_login'] et 
	*    $_SESSION['access_right']
	*  - RÃ©initialiser les attributs $this->user_login, $this->access_level
	*  - Mettre l'attribut $this->logged_in a faux
	* 
	*/

	public function logout(){
		$_SESSION['user_login']=null;
		$this->logged_in=false;
	}


	/* MÃ©thode hashPassword :
	*
	* MÃ©thode pour hacher un mot de passe
	*  
	* @param  string : $password, le mots de passe en clair
	* @return string : mot de passe hachÃ©
	* 
	* Algorithme : 
	*  
	*   Retourner le rÃ©sultat de la fonction password_hash
	*
	*/

	protected function hashPassword($password){
		return password_hash($password, PASSWORD_DEFAULT);
	}

	/* La MÃ©thodes verifyPassword : 
	* 
	* MÃ©thode pour vÃ©rifier si un mot de passe est Ã©gale a un hache  
	*  
	* @param string : $password, mot de passe non hachÃ© (depuis un formulaire)
	* @param string : $hash, le mot de passe hachÃ© (depuis BD)
	* @return bool  : vrai si concordance faut sinon
	* 
	*
	* Algorithme :
	* 
	*  Retourner le rÃ©sultat de la fonction password_verify
	*/

	protected function verifyPassword($password, $hash){
		return password_verify($password, $hash);
	}
}
