<?php namespace Wetcat\Board\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class News extends Eloquent {

  protected $table = 'news';

  protected $softDelete = true;

  protected $fillable = array('title', 'body');    

}