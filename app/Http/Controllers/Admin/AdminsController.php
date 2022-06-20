<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::select('id', 'name', 'age', 'email', 'department_id', 'file_path', 'created_at')->get();

        return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::select('id', 'name')->get();
        return view('admin.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //フォームからファイルを取得
        //フォームのname="image"
        $image_file = $request->file('image');

        //ファイル名を一意の名前に変更し取得
        $extension = $image_file->extension();
        $file_name = uniqid(rand());
        $file_name_store = $file_name . '.' . $extension;

        //縦のサイズだけリサイズし、storage/app/public/に保存。
        //publicフォルダにシンボリック作成済み
        InterventionImage::make($image_file)->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('/app/public/' . $file_name_store));;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'department_id' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Admin::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'file_path' => $file_name_store,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.show', compact('admin'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $departments = Department::all();
        return view('admin.edit', compact('admin', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'department_id' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $admin->name = $request->name;
        $admin->age = $request->age;
        $admin->email = $request->email;
        $admin->department_id = $request->department_id;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.admin.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::findOrfail($id)->delete();

        return redirect()->route('admin.admin.index');
    }

    public function expiredAdminIndex()
    {
        $expired_admins = Admin::onlyTrashed()->get();

        return view('admin.expired_admins_index', compact('expired_admins'));
    }

    public function expiredAdminRestore($id)
    {
        Admin::onlyTrashed()->restore();
        return redirect()->route('admin.admin.index');
    }

    public function expiredAdminDestroy($id)
    {
        Admin::onlyTrashed()->forceDelete();
        return redirect()->route('admin.admin.index');
    }
}
