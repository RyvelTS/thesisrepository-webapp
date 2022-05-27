<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
  use HasFactory;
  protected $fillable = [
    'title',
    'user_id',
    'supervisor_name',
    'document',
  ];
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? false, function($query,$search){
      return $query->where('title','like','%'.$search.'%');
    });
    $query->when($filters['user'] ?? false, function($query,$user){
      return $query->whereHas('user',function($query) use($user){
        $query->where('name',$user);
      });
    });
    $query->when($filters['school'] ?? false, function($query,$school){
      return $query->whereHas('user',function($query) use($school){
        $query->whereHas('school',function($query) use($school){
          $query->where('name',$school);
        });
      });
    });
  }
}
