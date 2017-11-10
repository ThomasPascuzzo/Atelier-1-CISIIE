<?php
namespace mecado\model;

class Message extends \Illuminate\Database\Eloquent\Model
{
    protected $table      = 'message';  
    protected $primaryKey = 'id';     
    
    public    $timestamps = false;
    
}

