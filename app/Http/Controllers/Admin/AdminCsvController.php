<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use SplFileObject;
use Illuminate\Support\Facades\Hash;

class AdminCsvController extends Controller
{
    public function csvdownload()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=admin_list.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function()
        {

            $create_csvfile = fopen('php://output', "w"); // ファイルを作成

            $export_csv_title = ['id', 'name', 'age', 'email', 'department_id', 'created_at']; // 1行目の情報

            mb_convert_variables('SJIS-win', 'UTF-8', $export_csv_title); // 文字化け対策

            fputcsv($create_csvfile, $export_csv_title); // 1行目の情報を追記

            $admins = Admin::select('id', 'name', 'age', 'email', 'department_id', 'created_at')->get(); // tableから情報を取得

            foreach ($admins as $row) { // データを1行ずつ回す
                $csv= [
                    $row->id, // オブジェクトなので->で取得
                    $row->name,
                    $row->age,
                    $row->email,
                    $row->department_id,
                    $row->created_at
                ];

                mb_convert_variables('SJIS-win', 'utf-8', $csv); // 文字化け対策

                fputcsv($create_csvfile, $csv); // ファイルに書き込み
            }

            fclose($create_csvfile); // ファイルを閉じる。
        };

        return response()->stream($callback, 200, $headers);

    }

    public function csvupload(Request $request)
    {
        $uploaded_file = $request->file('csvfile');
        $file_path = $request->file('csvfile')->path($uploaded_file);


        $file = new SplFileObject($file_path);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

        $row_count = 1;

        foreach ($file as $row) {

            if ($row === [null]) continue;

            if ($row_count > 1)
            {
                $name = mb_convert_encoding($row[0], 'utf-8', 'SJIS');
                $age = mb_convert_encoding($row[1], 'utf-8', 'SJIS');
                $email = mb_convert_encoding($row[2], 'utf-8', 'SJIS');
                $department_id = mb_convert_encoding($row[3], 'utf-8', 'SJIS');
                $password = mb_convert_encoding($row[4], 'utf-8', 'SJIS');
                $created_at = mb_convert_encoding($row[5], 'utf-8', 'SJIS');
                if ($created_at == '') {
                    $created_at = null;
                }


                Admin::insert(array(
                    'name' => $name,
                    'age' => $age,
                    'email' => $email,
                    'department_id' => $department_id,
                    'password' => Hash::make($password),
                    'created_at' => $created_at
                ));
            }
            $row_count++;
        }
        return redirect()->route('admin.admin.index');
    }
}
