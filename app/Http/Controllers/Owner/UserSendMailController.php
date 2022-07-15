<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserSendMail;
use App\Http\Requests\MailRequest;


class UserSendMailController extends Controller
{
    public function create($id)
    {
        $user = User::findOrFail($id);
        $login_owner = Auth::user('owner');
        return view('owner.users_content.mails.create_mail', compact('user', 'login_owner'));
    }

    public function confirm(MailRequest $request)
    {
        $from = $request->from;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;
        return view('owner.users_content.mails.confirm_mail', compact('from', 'to', 'subject', 'content'));
    }

    public function send(MailRequest $request)
    {
        $from = $request->form;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;

        Mail::to($to)->send(new UserSendMail($content, $subject));
        return redirect()->route('owner.users.index')->with('successMessage', 'メールを送信しました');
    }
}
