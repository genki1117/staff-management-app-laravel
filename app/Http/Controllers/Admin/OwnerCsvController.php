<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use SplFileObject;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CsvUploadRequest;

class OwnerCsvController extends Controller
{
    public function ownerCsvDownLoad()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=owners_list.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {

            $create_csvfile = fopen('php://output', "w"); // ファイルを作成

            $export_csv_title = ['id', 'name', 'age', 'email', 'department_id', 'created_at']; // 1行目の情報

            mb_convert_variables('SJIS-win', 'UTF-8', $export_csv_title); // 文字化け対策

            fputcsv($create_csvfile, $export_csv_title); // 1行目の情報を追記

            $admins = Owner::select('id', 'name', 'age', 'email', 'department_id', 'created_at')->get(); // tableから情報を取得

            foreach ($admins as $row) { // データを1行ずつ回す
                $csv = [
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

    public function ownerCsvUpLoad(CsvUploadRequest $request)
    {

        // Owner::truncate(); // 全件削除

        $uploaded_file = $request->file('csvfile'); //fileを取得
        $file_path = $request->file('csvfile')->path($uploaded_file); //fileの絶対パスを取得


        $file = new SplFileObject($file_path); // SplFileObjectをインスタンス化
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

        $array = []; // バルクインサートの為の配列を作成

        $row_count = 1;

        foreach ($file as $row) {

            if ($row === [null]) continue; // 最終行が空の場合の対策

            if ($row_count > 1) // 1行目のヘッダーは取り込まない
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

                $csvimport_array = [
                    'name' => $name,
                    'age' => $age,
                    'email' => $email,
                    'department_id' => $department_id,
                    'password' => Hash::make($password),
                    'created_at' => $created_at
                ];

                //$array配列に追加
                array_push($array, $csvimport_array);

                // Owner::insert(array(
                //     'name' => $name,
                //     'age' => $age,
                //     'email' => $email,
                //     'department_id' => $department_id,
                //     'password' => Hash::make($password),
                //     'created_at' => $created_at
                // ));
            }
            $row_count++;
        }

        // バルクインサート
        //追加した配列の数をカウント
        $array_count = count($array);

        //この場合だと4件未満だと普通のインサート
        if ($array_count < 4) {

            Owner::insert($array);
        } else {

            $array_partial = array_chunk($array, 4);

            $array_partial_count = count($array_partial);

            for ($i = 0; $i <= $array_partial_count - 1; $i++) {

                Owner::insert($array_partial[$i]);
            }
        }

        return redirect()->route('admin.admin.index');
    }
}
