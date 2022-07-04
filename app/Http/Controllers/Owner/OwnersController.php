<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Department;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::select('id', 'name', 'age', 'email', 'department_id', 'file_path')
        ->paginate(4);
        return view('owner.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('owner.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        $image_file = $request->file('image');
        $file_path = '/app/public/';
        $file_name_store = ImageService::upload($image_file, $file_path);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'department_id' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $result = Owner::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'file_path' => $file_name_store,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('owner.owners.index')->with('successMessage', 'オーナー登録が完了しました');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $owner = Owner::findOrFail($id);
        return view('owner.show', compact('owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $owner = Owner::findOrFail($id);
        $departments = Department::all();

        return view('owner.edit', compact('owner', 'departments'));
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
        $owner = Owner::findOrFail($id);
        $image_file = $request->file('image');
        $file_path = 'app/public/';
        $file_name_store = ImageService::upload($image_file, $file_path);

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required',
            'email' => 'required|email|unique:owners,email,' . $owner->id,
            'department_id' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $owner->name = $request->name;
        $owner->age = $request->age;
        $owner->department_id = $request->department_id;
        $owner->file_path = $file_name_store;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return redirect()->route('owner.owners.index')->with('successMessage', 'オーナー情報を編集しました');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Owner::findOrFail($id)->delete();

        return redirect()->route('owner.owners.index')->with('successMessage', 'オーナー情報を削除しました。');
    }

    public function expiredOwnerIndex()
    {
        $expired_owners = Owner::onlyTrashed()->get();
        return view('owner.expired_owners_index', compact('expired_owners'));
    }

    public function expiredOwnerRestore()
    {

    }

    public function expiredOwnerDestroy()
    {

    }
}
