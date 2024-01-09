<?php
declare(strict_types=1);

namespace Modules\Lender\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Modules\Common\Http\Controllers\Controller;
use Modules\Common\Http\Requests\UploadFileRequest;

class UploadController extends Controller
{
    public function upload(UploadFileRequest $request)
    {
        $file = $request->file('file');
        Storage::disk('local')->put('public/image', $file);

        return response()->json([
            'path' => asset('/storage/image/' .$file->hashName()),
            'success' => true,
        ]);
    }
}
