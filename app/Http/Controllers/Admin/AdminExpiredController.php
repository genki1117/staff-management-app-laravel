<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminExpiredController extends Controller
{
    public function expiredAdminIndex()
    {
        $expired_admins = Admin::onlyTrashed()->paginate(4);
        return view('admin.expired_admins_index', compact('expired_admins'));
    }

    public function expiredAdminRestore($id)
    {
        Admin::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('admin.expired-admin.index')->with('successMessage', '管理者情報を復元しました。');
    }

    public function expiredAdminDestroy($id)
    {
        Admin::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('admin.expired-admin.index')->with('successMessage', '管理者情報を削除しました。');
    }
}
