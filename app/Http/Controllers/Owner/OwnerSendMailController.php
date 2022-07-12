<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OwnerSendMail;
use App\Http\Requests\MailRequest;

class OwnerSendMailController extends Controller
{
    public function create($id)
    {
        $owner = Owner::findOrFail($id);
        $login_owner = Auth::user('owner');
        return view('owner.mails.create-mail', compact('owner', 'login_owner'));
    }

    public function confirm(MailRequest $request)
    {
        $from = $request->from;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;
        return view('owner.mails.confirm-mail', compact('from', 'to', 'subject', 'content'));
    }

    public function send(MailRequest $request)
    {
        $from = $request->form;
        $to = $request->to;
        $subject = $request->subject;
        $content = $request->content;

        Mail::to($to)->send(new OwnerSendMail($content, $subject));
        return redirect()->route('owner.owners.index')->with('successMessage', 'メールを送信しました');
    }
}
