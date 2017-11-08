<?php

namespace mecado\view;

class MecadoView extends \mf\view\AbstractView {
  
    public function __construct( $data ){
        parent::__construct($data);
    }
     
    private function renderHeader(){
        return '<h1>Mecado</h1>';
    }
    
    private function renderFooter(){
        return 'La super app créée en Licence Pro &copy;2017';
    }

    private function renderHome()
    { 
        $html = "<div>";
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
        $html .= "<label for = 'pseudo'>Pseudo : </label>";
        $html .= "<input type = 'text' id = 'pseudo' name = 'pseudo' size = '20' maxlength = '50' required /><br/>";
        $html .= "<label for = 'mdp'>Mot de passe : </label>";
        $html .= "<input type = 'password' id = 'mdp' name = 'mdp' size = '20' maxlength = '50' required /><br/>";
        $html .= "<input type = 'submit' id = 'valider' name = 'valider' value = 'Login' />";
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
        $html .= "<label for = 'mail'>Mail : </label>";
        $html .= "<input type = 'text' id = 'mail' name = 'mail' size = '20' maxlength = '50' required /><br/>";
		$html .= "<label for = 'nom_complet'>Nom complet : </label>";
        $html .= "<input type = 'text' id = 'nom_complet' name = 'nom_complet' size = '20' maxlength = '50' required /><br/>";
        $html .= "<label for = 'pseudo'>Pseudo : </label>";
        $html .= "<input type = 'text' id = 'pseudo' name = 'pseudo' size = '20' maxlength = '50' required /><br/>";
        $html .= "<label for = 'mdp'>Mot de passe : </label>";
        $html .= "<input type = 'password' id = 'mdp' name = 'mdp' size = '20' maxlength = '50' required /><br/>";
        $html .= "<label for = 'remdp'>Retaper le mot de passe : </label>";
        $html .= "<input type = 'password' id = 'remdp' name = 'remdp' size = '20' maxlength = '50' required /><br/>";
        $html .= "<input type = 'submit' id = 'valider' name = 'valider' value = 'Inscription' />";
        $html .= "</form>";
        return $html;
    }
    private function renderUserListes()
    {
        $lesListes = $this->data;
        $html = "<table border=\"2\">";
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
            $html .= "<th>".$uneListe->nom."</th>";
            $html .= "<td>".$uneListe->description."</td>";
            $html .= "<td>".$uneListe->date_limite."</td>";
            $html .= "<td>".$uneListe->destinataire."</td>";
            $html .= "<td>".$uneListe->pour_soi."</td>";
            $html .= "<td>".$uneListe->url."</td>";
            $html .="<td><img src = 'edit.png'></td>";
            $html .="</tr>";
        }
        $html .= "</table>";
        return $html;
    }
    private function renderNewListe(){
        $chaine ="<div>";
        $linkform = $this->script_name."/insertListe/";
        $chaine.='<form id="formInsertListe" action="'.$linkform.'" method="POST">';
        $chaine.="<label for='nom'>Nom de la liste</label>";
        $chaine.="<input type='text' id='nom' name='nom' maxlength='25' /><br/>";
        $chaine.="<label for='description'>Description de la liste</label>";
        $chaine.="<textarea id='description' name='description' maxlength='140'></textarea><br/>";
        $chaine.="<label for='date_limite'>Date limite de validité</label>";
        $chaine.="<input type='date' id='date_limite' name='date_limite' /><br/>";
        $chaine.="<label for='destinataire'>Destinataire de la liste</label>";
        $chaine.="<input type='text' id='destinataire' name='destinataire' maxlength='25' /><br/>";
        $chaine.="<label for='pour_soi'>La liste est-elle pour vous ?</label>";
        $chaine.="<label for='pour_soi_1'>Oui</label>";
        $chaine.="<input type='radio' id='pour_soi_1' name='pour_soi' value='1' />";
        $chaine.="<label for='pour_soi_2'>Non</label>";
        $chaine.="<input type='radio' id='pour_soi_2' name='pour_soi' value='0' /><br/>";
        $chaine.="<input type='submit' value='Créer'/>";
        $chaine.="</form>";
        $chaine .="</div>";
        return $chaine;
    }
    private function renderModifierListe(){
        $uneListe = $this->data;
        $chaine ="<div>";
        $linkform = $this->script_name."/setListe/?id=".$uneListe->id;
        $chaine.='<form id="formInsertListe" action="'.$linkform.'" method="POST">';
        $chaine.="<label for='nom'>Nom de la liste</label>";
        $chaine.="<input type='text' id='nom' name='nom' maxlength='25' value='".$uneListe->nom."' /><br/>";
        $chaine.="<label for='description'>Description de la liste</label>";
        $chaine.="<textarea id='description' name='description' maxlength='140'>".$uneListe->description."</textarea><br/>";
        $chaine.="<label for='date_limite'>Date limite de validité</label>";
        $chaine.="<input type='date' id='date_limite' name='date_limite' value='".$uneListe->date_limite."' /><br/>";
        $chaine.="<label for='destinataire'>Destinataire de la liste</label>";
        $chaine.="<input type='text' id='destinataire' name='destinataire' maxlength='25' value='".$uneListe->destinataire."' /><br/>";
        $chaine.="<label for='pour_soi'>La liste est-elle pour vous ?</label>";
        if($uneListe->pour_soi == 1){
            $chaine.="<label for='pour_soi_1'>Oui</label>";
            $chaine.="<input type='radio' id='pour_soi_1' name='pour_soi' value='1' checked />";
            $chaine.="<label for='pour_soi_2'>Non</label>";
            $chaine.="<input type='radio' id='pour_soi_2' name='pour_soi' value='0' /><br/>";
        }
        else{
            $chaine.="<label for='pour_soi_1'>Oui</label>";
            $chaine.="<input type='radio' id='pour_soi_1' name='pour_soi' value='1' />";
            $chaine.="<label for='pour_soi_2'>Non</label>";
            $chaine.="<input type='radio' id='pour_soi_2' name='pour_soi' value='0' checked /><br/>";
        }
        $chaine.="<input type='submit' value='Créer'/>";
        $chaine.="</form>";
        $chaine .="</div>";
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
