<?php namespace Wetcat\Board\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Text extends Eloquent {

  protected $table = 'texts';

  protected $softDelete = true;

  protected $fillable = array('description');    


  public function textable()
  {
    return $this->morphTo();
  }
}