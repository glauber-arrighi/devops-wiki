<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Group extends Model {
    protected $fillable = ['name', 'label', 'description', 'color', 'active'];
    protected $casts = ['active' => 'boolean'];
    public function users(): BelongsToMany { return $this->belongsToMany(User::class)->withTimestamps(); }
    public function articles(): BelongsToMany { return $this->belongsToMany(Article::class); }
}
