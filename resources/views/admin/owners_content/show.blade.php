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
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 mx-auto">
                            <div class="flex flex-col text-center w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">管理者詳細</h1>
                            </div>
                            <div class="flex justify-between mt-12 lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                                    @if ($owner->file_path == '')
                                        <img class="object-cover object-center rounded" alt="hero" src="{{ asset('images/lion.jpg') }}">
                                    @else
                                        <img class="object-cover object-center rounded" alt="hero" src="{{ asset('storage/' . $owner->file_path) }}">
                                    @endif
                                </div>
                                <div class="ml-16 mx-auto">
                                    <div class="p-2 mx-auto">
                                        <div class="relative">
                                            <label for="name" class="leading-7 text-sm text-gray-600">氏名</label>
                                            <p class="text-lg font-semibold">{{ $owner->name }}</p>
                                        </div>
                                    </div>
                                    <div class="p-2 mx-auto">
                                        <div class="relative">
                                            <label for="age" class="leading-7 text-sm text-gray-600">年齢</label>
                                            <p class="text-lg font-semibold">{{ $owner->age }}</p>
                                        </div>
                                    </div>
                                    <div class="p-2 mx-auto">
                                        <div class="relative">
                                            <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                            <p class="text-lg font-semibold">{{ $owner->email }}</p>
                                        </div>
                                    </div>
                                    <div class="p-2 mx-auto">
                                        <div class="relative">
                                            <label for="department_id" class="leading-7 text-sm text-gray-600">部署</label>
                                            <p class="text-lg font-semibold">{{ $owner->department->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-12 p-2 w-full flex justify-around">
                                <button type="button" onclick="location.href='{{ route('admin.owners.index') }}'" class="bg-gray-300 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="button" onclick="location.href='{{ route('admin.owners.edit', ['owner' => $owner->id ]) }}'" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集する</button>
                            </div>
                        </div>
                        <div class="-mt-10 text-right">
                            <form id="delete_{{$owner->id}}" method="post" action="{{ route('admin.owners.destroy', [ 'owner' => $owner->id ]) }}">
                                @csrf
                                @method('DELETE')
                                    <a href="#" data-id="{{ $owner->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもいいですか?')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>

</x-app-layout>

