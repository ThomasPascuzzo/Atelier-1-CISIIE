<?php
//LUUUUXXXX
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
        $html .= var_dump($this->data);
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
    public function renderUserListes()
    
    {
        $lesListes = $this->data;
        $urlform = $this->script_name."/token/";
        $html = '<form id="formToken" action="'.$urlform.'" method="POST">';
        $html .= "<table border=\"2\">";
        $html .="<tr>";
        $html .="<td>Nom</td>";
        $html .="<td>Description</td>";
        $html .="<td>Date Limite</td>";
        $html .="<td>Destinataire</td>";
        $html .="<td>Perso</td>";
        $html .="<td>URL</td>";
        $html .="</tr>";
       
        foreach ($lesListes as $uneListe){
            $html .="<tr>";
            $html .= "<th>".$uneListe->nom."</th>";
            $html .= "<td>".$uneListe->description."</td>";
            $html .= "<td>".$uneListe->date_limite."</td>";
            $html .= "<td>".$uneListe->destinataire."</td>";
            $html .= "<td>".$uneListe->pour_soi."</td>";
            if(is_null($uneListe->url))
            {
                $html .="<input type='hidden' id='id' name='id' value='$uneListe->id'>";
                $html .= "<td><input type='submit' id='valider' name='valider' value='URL'></td>";
            }
            else 
            {
                $html .= "<td>".$uneListe->url."</td>";
            }
            

            $html .="</tr>";
        }
       
        $html .= "</table>";
        $html .="</form>";
        return $html;
 
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
            case 'viewUserListes':{
                $content = $this->renderUserListes();
            }break;
            case 'viewSignUp':{
                $content = $this->renderSignUp();
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
