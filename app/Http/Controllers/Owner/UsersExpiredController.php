<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersExpiredController extends Controller
{
    public function expiredUserIndex()
    {
        $expired_users = User::onlyTrashed()->paginate(4);
        return view('owner.users_content.expired_users_index', compact('expired_users'));
    }

    public function expiredUserRestore($id)
    {
        User::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('owner.expired-users.index')->with('successMessage', 'ユーザー情報を復元しました。');
    }

    public function expiredUserDestroy($id)
    {
        User::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('owner.expired-users.index')->with('successMessage', 'ユーザー情報を削除しました。');
    }
}
