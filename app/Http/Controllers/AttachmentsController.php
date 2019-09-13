<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    protected function acceptMimeType($mimetype)
    {
        $acceptedMimeTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'text/plain',
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        return in_array($mimetype, $acceptedMimeTypes) ? true : false;
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');

        if(!$this->acceptMimeType($file->getClientMimeType())) {
            return response()->json(['message' => 'Tipo de arquivo não suportado']);
        }

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('/storage/anexos/'), $name);

        return response()->json(['fileName' => $name]);
    }
}
