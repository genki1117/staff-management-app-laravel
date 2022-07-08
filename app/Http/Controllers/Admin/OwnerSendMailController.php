<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MailRequest;
use App\Mail\OwnerSendMail;
use Illuminate\Support\Facades\Mail;



class OwnerSendMailController extends Controller
{
    public function create($id)
    {
        $owner = Owner::findOrFail($id);
        $login_user = Auth::user();

        return view('admin.owners_content.emails.create-mail', compact('owner', 'login_user'));
    }

    public function confirm(MailRequest $request)
    {
        $from = $request->from;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;

        return view('admin.owners_content.emails.confirm_mail', compact('from', 'to', 'subject', 'content'));
    }

    public function send(MailRequest $request)
    {
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;

        Mail::to($to)->send(new OwnerSendMail($content, $subject));

        return redirect()->route('admin.owner_content.index')->with('successMessage', 'メールを送信しました');
    }
}