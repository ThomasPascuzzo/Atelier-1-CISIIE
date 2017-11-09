<?php

$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
//1. strrchr renvoie l'extension avec le point (« . »).
//2. substr(chaine,1) ignore le premier caractère de chaine.
//3. strtolower met l'extension en minuscules.
$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
if ( in_array($extension_upload,$extensions_valides) ) echo "Extension correcte";


  $nom = "uneimage"; //Le nom de l'image est l'id de la dernière image dans la base + 1
  $dossier  = "item_images"; //utiliser $this->app_root pour trouver le chemin à partir de la racine du projet
$resultat = move_uploaded_file($_FILES['image']['tmp_name'],$dossier."/".$nom.".".$extension_upload);
if ($resultat) echo "Transfert réussi";

?>
