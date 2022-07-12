<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;

class OwnerExpiredController extends Controller
{
    public function expiredOwnersIndex()
    {
        $expired_owners = Owner::onlyTrashed()->paginate(4);
        return view('admin.owners_content.expired_owners_index', compact('expired_owners'));
    }

    public function expiredOwnersRestore($id)
    {
        Owner::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('admin.owners.index');
    }

    public function expiredOwnersDestroy($id)
    {
        Owner::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('admin.owners.index');
    }
}
