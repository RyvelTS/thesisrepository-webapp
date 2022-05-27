<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  use HasFactory;
  protected $fillable = [
      'name',
  ];
  public function users()
  {
    return $this->hasMany(User::class);
  }
  public function getTotalUsersAttribute()
  {
    return $this->users->count();
  }
  public function getTotalThesesAttribute()
  {
    $total_theses = 0;
    foreach ($this->users as $user) {
      $total_theses += $user->theses->count();
    }
    return $total_theses;
  }
  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? false, function($query,$search){
      return $query->where('name','like','%'.$search.'%');
    });
  }
}
