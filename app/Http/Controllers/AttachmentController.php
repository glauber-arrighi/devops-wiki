<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'files'   => 'required|array|max:5',
            'files.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,webp,txt,md,yaml,yml,json,sh,zip',
        ]);

        $uploaded = [];
        foreach ($request->file('files') as $file) {
            $path = $file->store("attachments/article-{$article->id}", 'public');
            $attachment = $article->attachments()->create([
                'uploaded_by' => auth()->id(),
                'filename'    => $file->getClientOriginalName(),
                'path'        => $path,
                'mime_type'   => $file->getMimeType(),
                'size'        => $file->getSize(),
            ]);
            $uploaded[] = $attachment;
        }

        return back()->with('success', count($uploaded) . ' arquivo(s) enviado(s)!');
    }

    public function destroy(Article $article, Attachment $attachment)
    {
        abort_if($attachment->article_id !== $article->id, 404);
        abort_if(!auth()->user()->isAdmin() && $attachment->uploaded_by !== auth()->id(), 403);

        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();

        return back()->with('success', 'Anexo removido.');
    }
}
