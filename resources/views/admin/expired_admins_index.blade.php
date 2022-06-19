<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            削除済み管理者
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
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">氏名</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年齢</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">部署</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($expired_admins as $expired_admin)
                                        <tr>
                                        <td class="px-4 py-3">{{ $expired_admin->name }}</td>
                                        <td class="px-4 py-3">{{ $expired_admin->age }}</td>
                                        <td class="px-4 py-3">{{ $expired_admin->email }}</td>
                                        <td class="px-4 py-3">{{ $expired_admin->department->name }}</td>
                                        <form id="restore_{{$expired_admin->id}}" method="post" action="{{ route('admin.expired-admin.restore',$expired_admin->id) }}">
                                            @csrf
                                            <td class="px-4 py-3">
                                                <a href="#" data-id="{{ $expired_admin->id }}" onclick="restorePost(this)" class="text-white bg-blue-400 border-0 py-2 px-4 focus:outline-none hover:bg-blue-500 rounded">復元</a>
                                            </td>
                                        </form>
                                        <form id="delete_{{$expired_admin->id}}" method="post" action="{{ route('admin.expired-admin.destroy',$expired_admin->id) }}">
                                            @csrf
                                            <td class="px-4 py-3">
                                                <a href="#" data-id="{{ $expired_admin->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                                            </td>
                                        </form>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
        function restorePost(e) {
        'use strict';
        if (confirm('本当に復元してもいいですか?')) {
            document.getElementById('restore_' + e.dataset.id).submit();
        }
    }

    function deletePost(e) {
        'use strict';
        if (confirm('本当に削除してもいいですか?')) {
            document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
    </script>
</x-app-layout>

