<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OwnerCsvController extends Controller
{
    public function ownerCsvDownload()
    {
        dd('down_test');
    }

    public function ownerCsvUpload(Request $request)
    {
        dd('upload_test');
    }
}
