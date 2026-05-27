<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','role_id','active',
        'avatar','last_login_at','bio','job_title',
        'phone','location','preferences',
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'active'            => 'boolean',
        'password'          => 'hashed',
        'preferences'       => 'array',
    ];

    public function role(): BelongsTo { return $this->belongsTo(Role::class); }
    public function groups(): BelongsToMany { return $this->belongsToMany(Group::class)->withTimestamps(); }
    public function articles(): HasMany { return $this->hasMany(Article::class, 'author_id'); }
    public function isAdmin(): bool { return $this->role?->name === 'admin'; }
    public function isEditor(): bool { return in_array($this->role?->name, ['admin','editor']); }
    public function hasGroup(string $group): bool { return $this->groups->contains('name', $group); }

    public function avatarUrl(): string {
        if ($this->avatar) return asset('storage/' . $this->avatar);
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=6366f1&color=fff&size=128';
    }
}
