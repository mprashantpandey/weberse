<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store\DownloadToken;
use App\Models\Store\Entitlement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    public function entitlement(Entitlement $entitlement): BinaryFileResponse
    {
        abort_if($entitlement->user_id !== Auth::id(), 403);
        abort_if($entitlement->revoked_at !== null, 403);

        $product = $entitlement->product()->with('files')->firstOrFail();
        $file = $product->files->firstWhere('is_primary', true) ?? $product->files->sortByDesc('id')->first();
        abort_if(! $file, 404);

        return response()->download(Storage::disk('local')->path($file->storage_path), $file->original_name);
    }

    public function token(string $token): BinaryFileResponse
    {
        /** @var DownloadToken|null $record */
        $record = DownloadToken::query()
            ->with(['entitlement.product.files'])
            ->where('token', $token)
            ->first();

        abort_if(! $record, 404);
        abort_if($record->expires_at->isPast(), 410);
        abort_if($record->downloads_count >= $record->max_downloads, 410);
        abort_if($record->entitlement?->revoked_at !== null, 403);

        $product = $record->entitlement->product;
        $file = $product->files->firstWhere('is_primary', true) ?? $product->files->sortByDesc('id')->first();
        abort_if(! $file, 404);

        DB::transaction(function () use ($record) {
            $record->refresh();
            if ($record->expires_at->isPast() || $record->downloads_count >= $record->max_downloads) {
                abort(410);
            }
            $record->downloads_count = $record->downloads_count + 1;
            $record->last_downloaded_at = now();
            $record->save();
        });

        return response()->download(Storage::disk('local')->path($file->storage_path), $file->original_name);
    }
}

