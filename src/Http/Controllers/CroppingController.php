<?php

namespace Weiwait\DcatCropper\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CroppingController extends Controller
{
    public function cropping(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');
        $mimeType = $file->getMimeType();
        if ($mimeType == 'image/webp') {
            $temp = $file->getPathname();
            $im = \imagecreatefromwebp($temp);
            \imagepng($im, $temp, 1);
            \imagedestroy($im);
        }

        $filename = Storage::disk(config('admin.upload.disk'))
            ->putFile('weiwait/cropper', $request->file('file'));

        return response()->json([
            'name' => $filename,
            'url' => Storage::disk(config('admin.upload.disk'))->url($filename),
        ]);
    }
}
