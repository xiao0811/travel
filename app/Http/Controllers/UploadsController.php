<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;

class UploadsController extends Controller
{
    public function upload(Request $request)
    {
        $urls = [];

        foreach ($request->file() as $file) {
            $urls[] = asset("storage/" . $file->store(date('ymd'), 'public'));
        }
        Log::info($urls);
        return [
            "errno" => 0,
            "data"  => $urls,
        ];
    }
}
