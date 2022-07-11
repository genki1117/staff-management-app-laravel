<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminSendMail;
use App\Http\Requests\MailRequest;

class OwnerSendMailController extends Controller
{
    public function create($id)
    {
        $owner = Owner::findOrFail($id);
        $login_owner = Auth::user('owner');
        dd($owner, $login_owner);
    }
}
