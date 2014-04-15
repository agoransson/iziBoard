<?php namespace Wetcat\Board\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Marker extends Eloquent {

  protected $table = 'markers';

  protected $softDelete = true;

  protected $fillable = array('title', 'description', 'latitude', 'longitude');    


  public function markerable()
  {
    return $this->morphTo();
  }

}