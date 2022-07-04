<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminSendMail;
use App\Http\Requests\MailRequest;

class AdminSendMailController extends Controller
{
    public function create($id)
    {
        $admin = Admin::findOrFail($id);
        $login_admin = Auth::user('admin');
        return view('admin.emails.create_mail', compact('admin', 'login_admin'));
    }

    public function confirm(MailRequest $request)
    {
        $from = $request->from;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;
        return view('admin.emails.confirm_mail', compact('from', 'to', 'subject', 'content'));
    }

    public function send(MailRequest $request)
    {
        $from = $request->from;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;

        Mail::to($to)->send(new AdminSendMail($content,$subject));

        return redirect()->route('admin.admin.index')->with('successMessage', 'メールを送信しました');


    }
}
