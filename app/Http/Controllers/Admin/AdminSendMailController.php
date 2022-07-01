<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminSendMailController extends Controller
{
    public function create($id)
    {
        $admin = Admin::findOrFail($id);
        $login_admin = Auth::user('admin');
        return view('admin.emails.create_mail', compact('admin', 'login_admin'));
    }

    public function confirm(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;
        return view('admin.emails.confirm_mail', compact('from', 'to', 'subject', 'content'));
    }

    public function send(Request $request)
    {
        dd($request);
    }
}
