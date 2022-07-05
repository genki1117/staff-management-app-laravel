<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー管理画面
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
                                    <button onclick="location.href='{{ route('owner.owners.create') }}'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
                                        新規登録
                                    </button>
                                </div>
                                <x-flash-message/>
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                    <tr>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">氏名</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年齢</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">部署</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($expired_owners as $expired_owner)
                                        <tr>
                                        <td class="md:px-4 py-3">{{ $expired_owner->name }}</td>
                                        <td class="md:px-4 py-3">{{ $expired_owner->age }}</td>
                                        <td class="md:px-4 py-3">{{ $expired_owner->email }}</td>
                                        <td class="md:px-4 py-3">{{ $expired_owner->department->name }}</td>
                                        <form id="restore_{{$expired_owner->id}}" method="post" action="{{ route('owner.expired-owners.restore',$expired_owner->id) }}">
                                            @csrf
                                            <td class="md:px-4 py-3">
                                                <a href="#" data-id="{{ $expired_owner->id }}" onclick="restorePost(this)" class="text-white bg-blue-400 border-0 py-2 px-4 focus:outline-none hover:bg-blue-500 rounded">復元</a>
                                            </td>
                                        </form>
                                        <form id="delete_{{$expired_owner->id}}" method="post" action="{{ route('owner.expired-owners.destroy',$expired_owner->id) }}">
                                            @csrf
                                            <td class="md:px-4 py-3">
                                                <a href="#" data-id="{{ $expired_owner->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                                            </td>
                                        </form>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $expired_owners->links() }}
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

