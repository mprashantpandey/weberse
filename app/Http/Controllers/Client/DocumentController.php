<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientDocument;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('client.documents.index', [
            'documents' => ClientDocument::query()->where('user_id', $request->user()->id)->latest()->paginate(10),
        ]);
    }
}
