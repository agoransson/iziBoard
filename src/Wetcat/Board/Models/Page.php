<?php namespace Wetcat\Board\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Page extends Eloquent {

  protected $table = 'pages';

  protected $softDelete = true;

  protected $fillable = array('type', 'title', 'heading');    


  public function texts()
  {
    return $this->morphMany('Wetcat\Board\Models\Text', 'textable');
  }

  public function images()
  {
    return $this->morphMany('Wetcat\Board\Models\Photo', 'imageable');
  }

  public function markers()
  {
    return $this->morphMany('Wetcat\Board\Models\Marker', 'markerable');
  }
}