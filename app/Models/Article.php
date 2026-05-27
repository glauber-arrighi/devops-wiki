<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Article extends Model {
    use SoftDeletes;
    protected $fillable = ['title','slug','content','excerpt','priority','product','area','requester','status','published_at','author_id','views'];
    protected $casts = ['published_at' => 'datetime'];
    public function author(): BelongsTo { return $this->belongsTo(User::class, 'author_id'); }
    public function groups(): BelongsToMany { return $this->belongsToMany(Group::class); }
    public function tags(): BelongsToMany { return $this->belongsToMany(Tag::class); }
    public function attachments(): HasMany { return $this->hasMany(Attachment::class); }
    public function scopePublished($q) { return $q->where('status', 'published'); }
    public function scopeVisibleTo($query, User $user) {
        if ($user->isAdmin()) return $query;
        return $query->whereHas('groups', fn($q) => $q->whereIn('groups.id', $user->groups->pluck('id')));
    }
}
