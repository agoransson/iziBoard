<?php namespace Wetcat\Board\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Photo extends Eloquent {

  protected $table = 'photos';

  protected $softDelete = true;

  protected $fillable = array('originalname', 'name', 'ext', 'filename');    


  public function imageable()
  {
    return $this->morphTo();
  }

}