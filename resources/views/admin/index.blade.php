<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者管理画面
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-4 mx-auto text-right">
                            <div class="flex flex-col text-center w-full">
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <div class="text-right">
                                    <button onclick="location.href='{{ route('admin.admin.create') }}'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
                                        新規登録
                                    </button>
                                </div>
                                {{-- セッションメッセージ --}}
                                <x-flash-message/>
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                    <tr>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"></th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">氏名</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年齢</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">部署</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                        @if ($admin->file_path == '')
                                            <td class="md:px-4 py-3">
                                            <img src="{{asset('images/lion.jpg')}}" width="50px" height="50px" alt="">
                                        </td>
                                        @else
                                            <td class="px-4 py-3">
                                            <img src="{{asset('storage/' . $admin->file_path)}}" width="50px" height="50px" alt="">
                                        </td>
                                        @endif
                                        <td class="md:px-4 py-3">{{ $admin->name }}</td>
                                        <td class="md:px-4 py-3">{{ $admin->age }}</td>
                                        <td class="md:px-4 py-3">{{ $admin->email }}</td>
                                        <td class="md:px-4 py-3">{{ $admin->department->name }}</td>
                                        <td class="md:px-4 py-3">
                                            {{-- <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-primary btn-sm">詳細</a> --}}
                                            <button onclick="location.href='{{ route('admin.admin.show', $admin->id) }}'" class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-500 rounded">
                                                詳細
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $admins->links() }}
                            </div>
                        </div>
                        <div class="mt-8">
                            <label for="csvdownload"><i class="fa-solid fa-download"></i></label>
                            <a href="{{ route('admin.admin_csv_download') }}" id="csvdownload" >csvダウンロード</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

