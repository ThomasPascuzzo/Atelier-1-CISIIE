<?php

namespace mecado\control;
use \mecado\view\MecadoView as MecadoView;
use \mecado\auth\MecadoAuthentification as MecadoAuth;
use \mecado\model\Liste as Liste;
use \mecado\model\Utilisateur as Utilisateur;

class MecadoController extends \mf\control\AbstractController {

    public function __construct(){
        parent::__construct();
    }

    public function viewHome(){
        $v = new MecadoView($t = $_SESSION); 
        $v ->render('viewHome');
    }
    
    public function viewLogin($erreur = null){
        $v = new MecadoView($erreur);
        $v ->render('viewLogin');
    }
    
    public function checkLogin(){
        if(!empty($_POST['pseudo']) and !empty($_POST['mdp']))
        {
            $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_SPECIAL_CHARS);
            $auth = new MecadoAuth();
            $co = $auth->login($pseudo, $mdp);
            if(empty($co))
            {
                $this->viewHome();
            }
            else
            {
                $this->viewLogin($co);
            }
        }
    }
    
    public function deconnexion(){
        $auth = new MecadoAuth();
        $auth->deconnexion();
        return $this->viewHome();
    }
    
    public function viewSignUp($erreur = null){
        $v = new MecadoView($erreur);
        $v ->render('viewSignUp');
    }
    
    public function checkSignUp(){
        if(!empty($_POST['nom_complet']) and !empty($_POST['pseudo']) and !empty($_POST['mdp'])and !empty($_POST['remdp']) and !empty($_POST['mail']))
        {
			$mail = filter_var($_POST['mail'], FILTER_SANITIZE_SPECIAL_CHARS);
            $nom_complet = filter_var($_POST['nom_complet'], FILTER_SANITIZE_SPECIAL_CHARS);
            $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_SPECIAL_CHARS);
            $remdp = filter_var($_POST['remdp'], FILTER_SANITIZE_SPECIAL_CHARS);
            $auth = new MecadoAuth();
            if($mdp == $remdp)
            {
                $co = $auth->createUtilisateur($pseudo, $mdp, $nom_complet, $mail);
                if(empty($co))
                {
                    $this->viewHome();
                }
                else
                {
                    $this->viewSignUp($co);
                }
            }
            else 
            {
                $this->viewSignUp("Les mots de passe ne sont pas identiques !");
            }
        }
    }
    public function viewUserListes(){
        
        var_dump($_SESSION["user_login"]);
        
        if (isset ($_SESSION["user_login"]))
        {
            $pseudo = $_SESSION["user_login"];
            $req = Utilisateur::select()->where('pseudo', '=', $pseudo);
            $unUtilisateur = $req->first();
            
            $req2 = Liste::select()->where('id_UTILISATEUR', '=',$unUtilisateur->id);
            
            $lesListes = $req2->get();
            
            
            $v = new \mecado\view\MecadoView($lesListes);
            $v->render('viewUserListes');
        }
        else
        {
            $this->viewHome();
            
        }
    }
    public function viewNewListe(){
        $vue = new MecadoView('');
        return $vue->render('viewNewListe');
    }
    
    public function addListe(){
        if (isset ($_SESSION["user_login"]))
        {
            $pseudo = $_SESSION["user_login"];
            $req = Utilisateur::select()->where('pseudo', '=', $pseudo);
            $unUtilisateur = $req->first();
            if(isset($this->request->post['nom'])){
                $form=$this->request->post;
            }
            $vue = new MecadoView('');
            if(isset($form)){
                $liste = new Liste();
                $liste->nom=$form['nom'];
                $liste->description=$form['description'];
                $liste->date_limite=$form['date_limite'];
                $liste->pour_soi=$form['pour_soi'];
                $liste->destinataire=$form['destinataire'];
                $liste->id_UTILISATEUR=$unUtilisateur->id;
                $liste->save();                        
                $vue = new MecadoView($liste);
                return $vue->render('viewListe');
            }
            else{
                return $this->viewNewListe();
            }
        }
        else{
            return $this->viewHome();
        }
    }
    public function viewModifierListe()
    {
        $id = $_GET['id'];
        $requete = Liste::select()->where('id', '=', $id);
        $uneListe = $requete->first();
        $v = new MecadoView($uneListe);
        $v ->render('viewModifierListe');
    }
    public function setListe(){
        if (isset ($_SESSION["user_login"]))
        {
            $pseudo = $_SESSION["user_login"];
            $req = Utilisateur::select()->where('pseudo', '=', $pseudo);
            $unUtilisateur = $req->first();
            if(isset($this->request->post['nom'])){
                $form=$this->request->post;
            }
            $vue = new MecadoView('');
            if(isset($form)){
                $req = Liste::select()->where('id', '=', $_GET['id']);
                $liste = $req->first();
                $liste->nom=$form['nom'];
                $liste->description=$form['description'];
                $liste->date_limite=$form['date_limite'];
                $liste->pour_soi=$form['pour_soi'];
                $liste->destinataire=$form['destinataire'];
                $liste->id_UTILISATEUR=$unUtilisateur->id;
                $liste->save();
                $vue = new MecadoView($liste);
                return $vue->render('viewListe');
            }
            else{
                return $this->viewModifierListe();
            }
        }
        else{
            return $this->viewHome();
        }
    }
}