<?php

namespace mecado\auth;
use \mecado\model\Utilisateur as Utilisateur;

class MecadoAuthentification extends \mf\auth\Authentification {

    /*
     * Classe MecadoAuthentification qui définie les méthodes qui dépendent
     * de l'application (liée à la manipulation du modèle Utilisateur) 
     *
     */

    /* constructeur */
    public function __construct(){
        parent::__construct();
    }

    public function createUtilisateur($pseudo, $mdp, $nom_complet, $mail) 
    {  
        $requete = Utilisateur::select()->where('pseudo', '=', $pseudo);
        $unUtilisateur = $requete->first();
        if(!is_null($unUtilisateur)){
            return "Pseudo déjà utilisé";
        }
        else{
            $u = new Utilisateur();
            $u->pseudo = $pseudo;
            $u->nom_complet = $nom_complet;
            $u->mail = $mail;
            $hash = $this->hashPassword($mdp);
            $u->mdp = $hash;
            $u->save();
        }
    }

    public function login($pseudo, $mdp)
    { 
        $requete = Utilisateur::select()->where('pseudo', '=', $pseudo);
        $unUtilisateur = $requete->first();
        if(is_null($unUtilisateur))
        {
            return "Utilisateur inconnu";
        }
        else{
            $requete = Utilisateur::select()
            ->where('pseudo', '=', $pseudo)
            ;
            $p = $requete->first();
            $check = $this->verifyPassword($mdp, $p->mdp);
              
            if($check == false){
                return "Mot de passe erroné !";
            }
            else{
                $this->updateSession($pseudo);
            }
        }
    }
    public function deconnexion(){
        $this->logout();
    }
}
