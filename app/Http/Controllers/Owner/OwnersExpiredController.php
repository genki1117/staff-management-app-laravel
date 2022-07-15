<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;

class OwnersExpiredController extends Controller
{
    public function expiredOwnerIndex()
    {
        $expired_owners = Owner::onlyTrashed()->paginate(4);
        return view('owner.expired_owners_index', compact('expired_owners'));
    }

    public function expiredOwnerRestore($id)
    {
        Owner::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('owner.owners.index')->with('successMessage', 'オーナー情報を修正しました。');
    }

    public function expiredOwnerDestroy($id)
    {
        Owner::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('owner.owners.index')->with('succesMessage', 'オーナー情報を削除しました。');
    }
}
