<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Attachment extends Model {
    protected $fillable = ['article_id','uploaded_by','filename','path','disk','mime_type','size'];
    public function article(): BelongsTo { return $this->belongsTo(Article::class); }
    public function uploader(): BelongsTo { return $this->belongsTo(User::class, 'uploaded_by'); }
}
