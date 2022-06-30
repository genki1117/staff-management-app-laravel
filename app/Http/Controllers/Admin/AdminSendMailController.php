<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminSendMailController extends Controller
{
    public function create($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.mail', compact('admin'));
    }
}
