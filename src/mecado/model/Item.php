<?php
namespace mecado\model;
class Item extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'item';  /* le nom de la table */
    protected $primaryKey = 'id';     /* le nom de la cl� primaire */
    public    $timestamps = false;    /* si vrai la table doit contenir
                                            les deux colonnes updated_at,
                                            created_at */




}