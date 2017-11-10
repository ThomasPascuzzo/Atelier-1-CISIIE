<?php

namespace mecado\view;

class MecadoView extends \mf\view\AbstractView {
  
    public function __construct( $data ){
        parent::__construct($data);
    }
     
    private function renderHeader(){
        $html = '<div id="bloc_page">
        <nav id="navigation" role="navigation"> <!--Bloc header qui concerne le menu -->
        <input type="checkbox" id="toggle-nav" aria-label="open/close navigation">
        <label for="toggle-nav" class="nav-button"></label>
        <div class="nav-inner">
        <ul class="GrilleMenu" id="menu"> <!--Liste des onglets-->
        <li><a href="index.html"><img src="'.$this->app_root.'/src/mf/html/logo3.png" class="img" href="#" alt="logo"></a></li>
        <li><a href="'. $this->script_name . '/home/" title="Home">Accueil</a></li>';

        if (isset ($_SESSION["user_login"]))
        {
            $html.='<li><a href="'. $this->script_name . '/dashboard/" title="Listes">Mes Listes</a></li>
            <li><a href="'. $this->script_name . '/deconnexion/" title="Connexion">Déconnexion</a></li>';
        }else{
           $html .= '<li><a href="'. $this->script_name . '/inscription/" title="FormInscription">Inscription</a></li>
        <li><a href="'. $this->script_name . '/login/" title="Connexion">Connexion</a></li>'; 
        }
        $html .='</ul>
        </div>
        </nav>
        </div>';
        return $html;
    }
    
   private function renderFooter(){
        return 'Mecado &copy; Thomas PASCUZZO - Corentin LUX - Florent PUPPO - Benjamin NAUDIN - Alan BEUGRE';
    }

private function renderHome()
    { 
        $html ='<article class="GrilleResume">  <!--Texte du site-->
        <p class="info">Voici Mecado.net<br>
        Vos amis n\'ont pas d\'idées de cadeaux pour vous ?<br>
        N\'ayez crainte ! Mecado.net est fait pour vous !<br>
          Avec Mecado.net, vous pouvez créer des listes rempli de cadeaux que vous aurez choisi.<br>
          Pas de limite ! Votre liste peut contenir autant de cadeaux que vous voulez !<br>
          Il ne vous reste plus qu\'à envoyer votre liste à tous vos amis qui auront<br> une idée de ce que vous voudrez lors de votre anniversaire ou d\'autres événements importants !<br></p>
        </article>
        
        ';
        $html .= "</div>";
        return $html;
    }
    
    private function renderLogin()
    {
        $html = "<form action='".$this->script_name."/check_login/' method='post'>";
        if($this->data)
        {
            $html .= $this->data."<br/>";
        }
        $html .= "<table class='form'>";
        $html .= "<caption class='tuto3'>Veuillez vous connecter :</caption>";
        $html .="<tr>";
        $html .= "<td><label for='login' class='text'>Pseudo : </label></td>";
        $html .= "<td><input type='text' name='pseudo' id='pseudo'/></td>";
        $html .="</tr>
                    <tr>";
        $html .= "<td><label for ='pass' class ='text'>Mot de passe : </label></td>";
        $html .= "<td><input type='password' name='mdp' id='mdp'/></td>";
        
        $html .= "</tr>
                    </table>";
        $html .= "<input class='btn' type='submit' name='connexion' value='Connexion'/>";
        $html .= "</form>";
        return $html;
    }

    private function renderSignUp()
    {
        $html = "<form action='".$this->script_name."/check_signup/' method='post'>";
        if($this->data)
        {
            $html .= $this->data."<br/>";
        }
        $html .= "<table class='table_inscription'>
                  <caption class='tuto2' >Inscription</caption>
                  <tr>

               <td><label for='nom' class='text'>Pseudo:</label>
               <input type='text' name='pseudo' id='pseudo' /></td>
               <td><label for='Prenom' class='text'>Nom(complet):</label>
               <input type='text' name='nom_complet' id='nom_complet'/></td>
               <td><label for='login' class='text'>Adresse mail:</label>
               <input type='text' name='mail' id='mail'/></td>
            </tr>
            <tr>
            <td><label for='pass' class='text'>Mot de passe :</label>
               <input type='password' name='mdp' id='mdp'/>
             </td>
             <td><label for='pass' class='text'>Retapez votre mot de passe :</label>
               <input type='password' name='remdp' id='remdp'/>
             </td>

            </tr>
         </table>
         <div >
        <input class='btn' type='submit' name='valider' id='valider' value='Inscription'/>
        ";

       
        $html .= "</form>";
        return $html;
    }
    private function renderUserListes()
    {
        $html = "";
        $html .= "<a href='".$this->script_name."/ajouterListe/'>
            <img src = '".$this->app_root."/images/add.png' height='14pt'>Ajouter une liste</a>";
        $lesListes = $this->data;
        $urlform = $this->script_name."/token/";
        if($lesListes->first()){
            $html .= "
            <div class='tuto2'>Mes listes</div>
            <table class='listes_cadeau'";
            $html .="<tr>";
            $html .="<td>Nom</td>";
            $html .="<td>Description</td>";
            $html .="<td>Date Limite</td>";
            $html .="<td>Destinataire</td>";
            $html .="<td>Perso</td>";
            $html .="<td>URL</td>";
            $html .="<td>Options</td>";
            $html .="</tr>";
            
            foreach ($lesListes as $uneListe){
                $html .="<tr>";
                $html .= "<th><a href='".$this->script_name."/liste/?id=".$uneListe->id."'>".$uneListe->nom."</a></th>";
                $html .= "<td>".$uneListe->description."</td>";
                $html .= "<td>".$uneListe->date_limite."</td>";
                $html .= "<td>".$uneListe->destinataire."</td>";
                $html .= "<td>".$uneListe->pour_soi."</td>";
                if(is_null($uneListe->url))
                {
                    $html .= "<td><a href = '".$this->script_name."/token/?id=".$uneListe->id."'>Générer l'URL</a></td>";
                }
                else
                {
                    $html .= "<td><a href = 'https://webetu.iutnc.univ-lorraine.fr".$this->script_name."/liste/?token=".$uneListe->url."'>https://webetu.iutnc.univ-lorraine.fr".$this->script_name."/liste/?token=".$uneListe->url."</a></td>";
                }
                $html .="<td>
                <a href='".$this->script_name."/modifierListe/?id=".$uneListe->id."'>
                <img src = '".$this->app_root."/images/edit.png' height='12pt'></a>
                <a href ='#' onclick='ConfirmSuppression(); return false;'>
                <img src = '".$this->app_root."/images/suppr.png' height='12pt'></a>
                </td>";
                $html .= '<script type="text/javascript">
            function ConfirmSuppression() {
                if (confirm("Voulez-vous vraiment supprimer cette liste ?")) { // Clic sur OK
                    document.location.href ="'.$this->script_name.'/supprimerListe/?id='.$uneListe->id.'";
                }
            }
            </script>';
                $html .="</tr>";
            }
            $html .= "</table></form>";
        }
        return $html;
    }
    private function renderNewListe(){
        $chaine ="<div>";
        $linkform = $this->script_name."/insertListe/";
        $chaine.='<form id="formInsertListe" action="'.$linkform.'" method="POST">';
        $chaine.="<table class='table_inscription'>
                    <tr>";
        $chaine.="<td><label for='nom'>Nom de la liste</label></td>";
        $chaine.="<td><input type='text' id='nom' name='nom' maxlength='25' /></td>";
        $chaine.="<td><label for='description'>Description de la liste</label></td>";
        $chaine.="<td><textarea id='description' name='description' maxlength='140'></textarea></td>";
        $chaine.="<td><label for='date_limite'>Date limite de validité</label></td>";
        $chaine.="<td><input type='date' id='date_limite' name='date_limite' /></td>";
        $chaine.="<td><label for='destinataire'>Destinataire de la liste</label></td>";
        $chaine.="<td><input type='text' id='destinataire' name='destinataire' maxlength='25' /></td>";
        $chaine.="<td><label for='pour_soi'>La liste est-elle pour vous ?</label></td>";
        $chaine.="<td><label for='pour_soi_1'>Oui</label>";
        $chaine.="<input type='radio' id='pour_soi_1' name='pour_soi' value='1' />";
        $chaine.="<label for='pour_soi_2'>Non</label>";
        $chaine.="<input type='radio' id='pour_soi_2' name='pour_soi' value='0' /></td>
        </tr>
        <tr>";

        $chaine.="<td><input type='submit' value='Créer'/></td>";
        $chaine.="</table>";
        $chaine.="</form>";
        $chaine .="</div>";
        return $chaine;
    }
    private function renderModifierListe(){
        $uneListe = $this->data;
        $chaine ="<div>";
        $linkform = $this->script_name."/setListe/?id=".$uneListe->id;
        $chaine.='<form id="formInsertListe" action="'.$linkform.'" method="POST">';
        $chaine.="<table class='table_inscription'>
                    <tr>";
        $chaine.="<td><label for='nom'>Nom de la liste</label></td>";
        $chaine.="<td><input type='text' id='nom' name='nom' maxlength='25' value='".$uneListe->nom."' /></td>";
        $chaine.="<td><label for='description'>Description de la liste</label></td>";
        $chaine.="<td><textarea id='description' name='description' maxlength='140'>".$uneListe->description."</textarea></td>";
        $chaine.="<td><label for='date_limite'>Date limite de validité</td>";
        $chaine.="<td><input type='date' id='date_limite' name='date_limite' value='".$uneListe->date_limite."' /></td>";
        $chaine.="<td><label for='destinataire'>Destinataire de la liste</label></td>";
        $chaine.="<td><input type='text' id='destinataire' name='destinataire' maxlength='25' value='".$uneListe->destinataire."' /></td>";
        $chaine.="<td><label for='pour_soi'>La liste est-elle pour vous ?</label></td>";
        if($uneListe->pour_soi == 1){
            $chaine.="<td><label for='pour_soi_1'>Oui</label>";
            $chaine.="<input type='radio' id='pour_soi_1' name='pour_soi' value='1' checked />";
            $chaine.="<label for='pour_soi_2'>Non</label>";
            $chaine.="<input type='radio' id='pour_soi_2' name='pour_soi' value='0' /></td>";
        }
        else{
            $chaine.="<td><label for='pour_soi_1'>Oui</label>";
            $chaine.="<input type='radio' id='pour_soi_1' name='pour_soi' value='1' />";
            $chaine.="<label for='pour_soi_2'>Non</label>";
            $chaine.="<input type='radio' id='pour_soi_2' name='pour_soi' value='0' checked /></td>";
            
        }
        $chaine.="</tr>
                        <tr>";
        $chaine.="<td><input type='submit' value='Modifier'/></td> </tr>";
        $chaine.="</table>";
        $chaine.="</form>";
        $chaine .="</div>";
        return $chaine;
    }
    
    public function renderListeItems(){
        {
            $lesItems = $this->data['items'];
            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }
            else{
                $id = $lesItems->first()->id;
            }
            $html = "<a href='".$this->script_name."/ajouterCadeau/?id=".$id."'>
            <img src = '".$this->app_root."/images/add.png' height='14pt'>Ajouter un cadeau</a>";
            if($lesItems->first()){
                $html .= "
                <div class='tuto2'>Liste de cadeaux</div>
                <table class='listes_cadeau'>";
                $html .="<tr>
                    <td>Nom du cadeau</td>
                    <td>Description du cadeau</td>
                    <td>Prix du Cadeau</td>
                    <td>URL</td>
                    <td>Options</td>
                 </tr>";
                
                foreach ($lesItems as $unItem){
                    $html .= "<tr>";
                    $html .= "<td><a href='".$this->script_name."/item/?id=".$unItem->id."'>".$unItem->nom."</a></td>";
                    $html .= "<td>".$unItem->description."</td>";
                    $html .= "<td>".$unItem->tarif."</td>";
                    $html .= "<td><a href='$unItem->url_ecommerce'>URL</a></td>";                    
                    $html .="<td>
                    <a href='".$this->script_name."/modifierItem/?id=".$unItem->id."'>
                    <img src = '".$this->app_root."/images/edit.png' height='12pt'></a>
                    <a href ='#' onclick='ConfirmSuppression(); return false;'>
                    <img src = '".$this->app_root."/images/suppr.png' height='12pt'></a>
                    </td>";
                    $html .= '<script type="text/javascript">
                    function ConfirmSuppression() {
                        if (confirm("Voulez-vous vraiment supprimer cet item ?")) { // Clic sur OK
                            document.location.href ="'.$this->script_name.'/supprimerItem/?id='.$unItem->id.'";
                        }
                    }
                    </script>';
                    $html .="</tr>";
                }
                $html .= "</table>";
                $lesMessages = $this->data['messages'];
                foreach($lesMessages as $unMessage){
                    if(!empty($unMessage->contenu)){
                        $html .= $unMessage->contenu;
                    }
                }
            }
            return $html;
        }
    }
    
    
    public function renderListeInvite(){
    {
        $html = "";   
        $lesItems = $this->data['items'];
            if($lesItems->first()){
                $html .= "
            <div class='tuto2'>Liste de cadeaux</div>
            <table class='listes_cadeau'";
                $html .= "<tr>
                    <td>Nom du cadeau</td>
                    <td>Description du cadeau</td>
                    <td>Prix du Cadeau</td>
                 </tr>";
                foreach ($lesItems as $unItem){
                    $html .= "<tr>";
                    $html .= "<td><a href='".$this->script_name."/item/?token=".$_GET['token']."&id=".$unItem->id."'>".$unItem->nom."</a></td>";
                    $html .= "<td>".$unItem->description."</td>";
                    $html .= "<td>".$unItem->tarif."</td></tr>";
                }
                $html .= "</table>";
                $lesMessages = $this->data['messages'];
                foreach($lesMessages as $unMessage){
                    if(!empty($unMessage->contenu)){
                        $html .= $unMessage->contenu."<br/>";
                    }
                }
            }
            return $html;
        }
    }
        
    private function renderItemInvite()
    {
        $Item = $this->data['item'];
        $message = $this->data['message'];
        $lesPhotos = $this->data['photos'];
        $html = "";
        foreach ($lesPhotos as $unePhoto){
            if(!empty($unePhoto)){
                $html .= "<img src = '".$unePhoto->url."' />";
            }
        }
        $html .= "
            <div class='tuto2'>Détail du cadeau</div>
        <table class='listes_cadeau'>
                    <tr>
                    <td>Nom</td>
                    <td>Description du cadeau</td>
                    <td>Prix du Cadeau</td>
                    <td>URL</td>
                    
                 </tr>
                 <tr>
        ";
        $html .=  "<td>".$Item->nom."</td>";
        $html .= "<td>".$Item->description."</td>";
        $html .= "<td>".$Item->tarif."</td>";
        $html .= "<td>".$Item->url_ecommerce."</td>";
        $html .="</tr> </table>";
        if($Item->reserve == 0){
            $html .= "<table class='listes_cadeau'><tr><td>Voulez-vous réserver ce cadeau ?</td></tr>";
            $html.="<form id='formReserve' action='".$this->script_name."/reserverItem/?token=".$_GET['token']."&id=".$Item->id."' method='POST'>";
            $html.="<tr><td><label for='messageItem'>Laissez un message sur ce cadeau : </label></td>";
            $html.="<td><textarea id='messageItem' name='messageItem' maxlength='250'></textarea></td></tr>";
            $html.="<tr><td><label for='messageListe'>Laissez un message public sur la liste : </label></td>";
            $html.="<td><textarea id='messageListe' name='messageListe' maxlength='250'></textarea></td>";
            $html.="<td><label for='auteur'>Votre nom : </label></td>";
            $html.="<td><input type='text' id='auteur' name='auteur' /></td>";
            $html.="<td><input type='submit' value='Réserver'/></td></tr>";
        }
        else{
            $html .= "Ce cadeau est déjà réservé par quelqu'un<br/>";
            if(isset($message->contenu)){
                $html .= $message->contenu;
            }
        }
        $html .="</table>";
        return $html;
    }
    
    private function renderInformationItem()
    {
        $Item = $this->data['item'];
        $message = $this->data['message'];
        $lesPhotos = $this->data['photos'];
        $html = "";
        foreach ($lesPhotos as $unePhoto){
            if(!empty($unePhoto)){
                $html .= "<img src = '".$unePhoto->url."' />";
            }
        }
        $html .= "
        <div class='tuto2'>Détail du cadeau</div>
        <table class='listes_cadeau'>
                    <tr>
                    <td>Nom</td>
                    <td>Description du cadeau</td>
                    <td>Prix du Cadeau</td>
                    <td>URL</td>
                    
                 </tr>
                 <tr>
        ";
        $html .=  "<td>".$Item->nom."</td>";
        
        $auj = date('Y-m-d');
        $html .= "<td>".$Item->description."</td>";
        $html .= "<td>".$Item->tarif."</td>";
        $html .= "<td>".$Item->url_ecommerce."</td>";
        $html .="</tr>";
        $liste = $this->data['liste'];
        if($liste->date_limite < $auj)
        {
            if(isset($message->contenu)){
                $html .= $message->contenu;
            }
        }
        $html .="</table>";
        return $html;
    }
    
    private function renderAddCadeau(){
        $html = "
     <article>
                <form class='forms' action='$this->script_name/check_addcadeau/' method='post'>
                <div class='table_inscription'>
                    <input type='hidden' name='idListe' value='$this->data'>
                    <label for='nomCadeau'>Nom du cadeau</label>
                    <input id='nomCadeau' name='nomCadeau' type='text'><br/>
                    <label for='descriptionCadeau'>Description</label>
                    <input id='descriptionCadeau' name='descriptionCadeau' type='text'><br/>
                    <label for='tarifCadeau'>Prix indicatif du cadeau</label>
                    <input id='tarifCadeau' name='tarifCadeau' type='number'><br/>
                    <label for='urlCadeau'>Lien facultatif vers un site d'e-commerce</label>
                    <input id='urlCadeau' name='urlCadeau' type='text'><br/>";
                    $nbImages = 5;
                    $html .= "<input type='hidden' name='nbImages' value='$nbImages'>";
                    for($i = 1; $i <= $nbImages; $i++){
                        $html .="<label for='nomImage".$i."'>Nom de l'image ".$i."</label>";
                        $html .="<input type='text' name='nomImage".$i."' id='nomImage".$i."' /><br />";
                        $html .="<label for='image".$i."'>URL de l\'image n°".$i." (JPG, PNG ou GIF) :</label>";
                        $html .="<input type='text' name='image".$i."' id='image".$i."' /><br />";
                    }
                              
                    $html .= "<button class='forms-button' name='login_button' type='submit'>Ajouter</button>
                    </div>
                </form>
            </article>";
        return $html;
    }
    private function renderModifierItem(){
        $unItem = $this->data;
        $linkform = $this->script_name."/setItem/?id=".$unItem->id;
        $chaine='<form id="formInsertListe" action="'.$linkform.'" method="POST">
            <div class="table_inscription">
            ';
        $chaine.="<label for='nom'>Nom du Cadeau :</label>";
        $chaine.="<input type='text' id='nom' name='nom' maxlength='25' value='".$unItem->nom."' /><br/>";
        $chaine.="<label for='description'>Description du cadeau :</label>";
        $chaine.="<input type='text' id='description' name='description' maxlength='25' value='".$unItem->description."' /><br/>";
        $chaine.="<label for='tarif'>Tarif du cadeau :</label>";
        $chaine.="<input type='text' id='tarif' name='tarif' value='".$unItem->tarif."' /><br/>";
        $chaine.="<label for='url_ecommerce'>URL du cadeau :</label>";
        $chaine.="<input type='text' id='url_ecommerce' name='url_ecommerce' maxlength='25' value='".$unItem->url_ecommerce."' /><br/>";
        $chaine.="<input type='submit' value='modifier le cadeau'/>";
        $chaine.="</div></form>";
        return $chaine;
        
    }
    protected function renderBody($selector=null){
        $head = $this->renderHeader();
        $foot = $this->renderFooter();
        $content;
        switch ($selector){
            case 'viewHome':{
                $content = $this->renderHome();
            }break;
           
            case 'viewLogin':{
                $content = $this->renderLogin();
            }break;
            case 'viewSignUp':{
                $content = $this->renderSignUp();
            }break;
            case 'viewUserListes':{
                $content = $this->renderUserListes();
            }break;
            case 'viewNewListe':{
                $content = $this->renderNewListe();
            }break;
            case 'viewModifierListe':{
                $content = $this->renderModifierListe();
            }break;
            case 'viewListeItems':{
                $content = $this->renderListeItems();
            }break;
            case 'viewListeInvite':{
                $content = $this->renderListeInvite();
            }break;
            case 'viewInformationItem':{
                $content = $this->renderInformationItem();
            }break;
            case 'viewItemInvite':{
                $content = $this->renderItemInvite();
            }break;
            case 'addCadeau':{
                $content = $this->renderAddCadeau();
            }break;
            case 'viewModifierItem':{
                $content = $this->renderModifierItem();
            }break;
            default:{
                $content = $this->renderHome();
            }break;
        }
        $html = <<<EOT
<header>${head}</header>
<section>
    <div class = "content">
        ${content}
    </div>
</section>
<footer>${foot}</footer>
EOT;

        return  $html;
        
    }
}
