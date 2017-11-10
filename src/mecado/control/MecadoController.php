<?php

namespace mecado\control;
use \mecado\view\MecadoView as MecadoView;
use \mecado\auth\MecadoAuthentification as MecadoAuth;
use \mecado\model\Liste as Liste;
use \mecado\model\Utilisateur as Utilisateur;
use \mecado\model\Item as Item;
use \mecado\model\Photo as Photo;
use \mecado\model\Message as Message;
use Illuminate\Support\MessageBag;

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
                $this->viewUserListes();
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
        if (isset ($_SESSION["user_login"]))
        {
            $pseudo = $_SESSION["user_login"];
            $req = Utilisateur::select()->where('pseudo', '=', $pseudo);
            $unUtilisateur = $req->first();
            if(!empty($unUtilisateur)){
				$req2 = Liste::select()->where('id_UTILISATEUR', '=',$unUtilisateur->id);
				$lesListes = $req2->get();
				$v = new \mecado\view\MecadoView($lesListes);
				$v->render('viewUserListes');
			}
            else{
				return $this->viewHome();
			}
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
                if(isset($form['pour_soi'])){
					$liste->pour_soi=$form['pour_soi'];
				}
                $liste->destinataire=$form['destinataire'];
                $liste->id_UTILISATEUR=$unUtilisateur->id;
                $liste->save();                        
                return $this->viewUserListes();
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
    public function deleteListe(){
        if (isset ($_SESSION["user_login"]))
        {
            $pseudo = $_SESSION["user_login"];
            $req = Utilisateur::select()->where('pseudo', '=', $pseudo);
            $unUtilisateur = $req->first();
            $id_liste= $_GET['id'];
            $req = Liste::select()->where('id', '=', $id_liste);
            $liste = $req->first();
            if(!empty($liste)){
                if($liste->id_UTILISATEUR == $unUtilisateur->id){
                    $liste->delete();
                }
            }
            return $this->viewUserListes();
        }
        else{
            return $this->viewHome();
        }
    }
    public function insertToken()
    {
        if(isset($_GET["id"])){
            $id=$_GET["id"];
            $req = Liste::select()->where('id', '=',$id);
            $liste = $req->first();
            $liste->url=bin2hex(random_bytes(20));
            $liste->save();
        }
        return $this->viewUserListes();
    }
    
    public function viewDetails($id_liste = NULL){
        if(isset($_SESSION["user_login"]) and (isset($_GET["id"]) or !is_null($id_liste)))
        {
            $pseudo = $_SESSION["user_login"];
            $req = Utilisateur::select()->where('pseudo', '=', $pseudo);
            $unUtilisateur = $req->first();
            if(!is_null($id_liste)){
                $id = $id_liste;
            }
            else{
                $id=$_GET["id"];
            }
            $req=Liste::select()->where('id_UTILISATEUR', '=', $unUtilisateur->id)->where('id', '=', $id);
            $uneListe = $req->first();
            if(!empty($uneListe)){
                $req=Item::select()->where('id_LISTE', '=', $id);
                $lesItems = $req->get();
                $req=Message::select()->where('id_LISTE', '=', $id);
                $lesMessages = $req->get();
                $v = new \mecado\view\MecadoView(['items' => $lesItems, 'messages' => $lesMessages]);
                $v-> render('viewListeItems');
            }
            else{
                return $this->viewUserListes();
            }
        }
        elseif(isset($_GET['token'])){
            $req=Liste::select()->where('url', '=', $_GET['token']);
            $uneListe = $req->first();
            if(empty($uneListe)){
                return $this->viewHome();
            }
            else{
                $req=Item::select()->where('id_LISTE', '=', $uneListe->id);
                $lesItems = $req->get();
                $req=Message::select()->where('id_LISTE', '=', $uneListe->id);
                $lesMessages = $req->get();
                $v = new \mecado\view\MecadoView(['items' => $lesItems, 'messages' => $lesMessages]);
                $v-> render('viewListeInvite');
            }
        }
        else{
            return $this->viewHome();
        }
    }
    public function viewDetailsItem(){
        if(isset($_GET["id"]) and isset($_SESSION['user_login'])){
            $id=$_GET["id"];
            $pseudo = $_SESSION["user_login"];
            $req = Utilisateur::select()->where('pseudo', '=', $pseudo);
            $unUtilisateur = $req->first();
            $req=Item::select()->where('id', '=', $id);
            $monItem = $req->first();
            $req=Liste::select()->where('id', '=', $monItem->id_LISTE)->where('id_UTILISATEUR', '=', $unUtilisateur->id);
            $uneListe = $req->first();
            if(!empty($uneListe)){
                $req=Message::select()->where('id_ITEM', '=', $monItem->id);
                $message = $req->first();
                $req=Photo::select()->where('id_ITEM', '=', $monItem->id);
                $lesPhotos = $req->get();
                $v = new \mecado\view\MecadoView(['item' => $monItem, 'message' => $message, 'liste' => $uneListe, 'photos' => $lesPhotos]);
                $v-> render('viewInformationItem');
            }
            else{
                return $this->viewUserListes();
            }
        }
        elseif(isset($_GET['token']) and isset($_GET['id'])){
            $req=Liste::select()->where('url', '=', $_GET['token']);
            $uneListe = $req->first();
            if(empty($uneListe)){
                return $this->viewHome();
            }
            else{
                $req=Item::select()->where('id', '=', $_GET['id']);
                $item = $req->first();
                if(!empty($item)){
                    $req=Message::select()->where('id_ITEM', '=', $item->id);
                    $message = $req->first();
                    $req=Photo::select()->where('id_ITEM', '=', $item->id);
                    $lesPhotos = $req->get();
                    $v = new \mecado\view\MecadoView(['item' => $item, 'message' => $message, 'liste' => $uneListe, 'photos' => $lesPhotos]);
                    $v-> render('viewItemInvite');
                }
                else{
                    return $this->viewHome();
                }
            }
        }
        else{
            return $this->viewHome();
        }
    }
    public function viewAddCadeau(){
        if(isset($_GET["id"])){
            $id_liste=$_GET["id"];
            $v = new MecadoView($id_liste);
            $v->render('addCadeau');
        }
    }
    
    public function createCadeau()
    {
        $item = new \mecado\model\Item();
        $item->nom=$_POST['nomCadeau'];
        $item->description=$_POST['descriptionCadeau'];
        if(!empty($_POST['tarifCadeau'])){
            $item->tarif=$_POST['tarifCadeau'];
        }
        else{
            $item->tarif=NULL;
        }
        $item->url_ecommerce=$_POST['urlCadeau'];
        $item->reserve = 0;
        $item->id_LISTE = $_POST['idListe'];
        $item->save();
        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
        //var_dump($_FILES);
        for($i = 1; $i <= $_POST['nbImages']; $i++){
            if(!empty($_POST['image'.$i])){
                $photo = new Photo();
                $photo->url = $_POST['image'.$i];
                $photo->nom = $_POST['nomImage'.$i];
                $photo->id_ITEM = $item->id;
                $photo->save();             
            }
        }
        return $this->viewDetails($_POST['idListe']);
    }
    public function viewModifierItem()
    {
        $id = $_GET['id'];
        $requete = Item::select()->where('id', '=', $id);
        $unItem = $requete->first();
        $v = new MecadoView($unItem);
        $v ->render('viewModifierItem');
    }
    public function setItem(){
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
                $req = Item::select()->where('id', '=', $_GET['id']);
                $item = $req->first();
                $item->nom=$form['nom'];
                $item->description=$form['description'];
                $item->tarif=$form['tarif'];
                $item->url_ecommerce=$form['url_ecommerce'];
                $item->save();
                $vue = new MecadoView($item);
                return $vue->render('viewListe');
            }
            else{
                return $this->viewModifierItem();
            }
        }
        else{
            return $this->viewHome();
        }
    }    
    public function deleteItem(){
        $id_ITEM= $_GET['id'];
        $req = Item::select()->where('id', '=', $id_ITEM);
        $item = $req->first();
        $liste = $item->id_LISTE;
        $req = Photo::select()->where('id_ITEM', '=', $item->id);
        $lesPhotos = $req->get();
        foreach ($lesPhotos as $unePhoto){
            $unePhoto->delete();
        }
        $item->delete();
        return $this->viewDetails($liste);
    }
    
    public function reserverItem(){
        if (isset($_GET["token"]) and isset($_GET["id"]))
        {
            $token = $_GET["token"];
            $req=Liste::select()->where('url', '=', $token);
            $uneListe = $req->first();
            if(empty($uneListe)){
                return $this->viewHome();
            }
            else{
                $req = Item::select()->where('id', '=', $_GET['id'])->where('id_LISTE', '=', $uneListe->id);
                $item = $req->first();
                if(!empty($item)){
                    $item->reserve=1;
                    $item->save();
                    if(!empty($_POST['messageItem']) or !empty($_POST['messageItem'])){
                        if(!empty($_POST['messageItem'])){
                            $message = new Message();
                            $message->contenu = $_POST['messageItem'];
                            $message->id_ITEM = $item->id;
                            if(!empty($_POST['auteur'])){
                                $message->auteur = $_POST['auteur'];
                            }
                            $message->save();
                        }
                        if(!empty($_POST['messageListe'])){
                            $message = new Message();
                            $message->contenu = $_POST['messageListe'];
                            $message->id_LISTE = $item->id_LISTE;
                            if(!empty($_POST['auteur'])){
                                $message->auteur = $_POST['auteur'];
                            }
                            $message->save();
                        }
                    }
                }
                return $this->viewDetails($uneListe->id);
            }
        }
        else{
            return $this->viewHome();
        }
    }    
}