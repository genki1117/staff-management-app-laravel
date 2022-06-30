<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            メール作成
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 mx-auto">
                            <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">メール送信</h1>
                            </div>
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <form method="post" action="{{ route('admin.admin.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="-m-2">
                                        <div class="p-2 w-1/2 mx-auto">
                                            <div class="relative">
                                                <label for="password_confirmation" class="leading-7 text-sm text-gray-600">パスワード確認</label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full flex justify-around mt-4">
                                            <button type="button" onclick="location.href='{{ route('admin.admin.index') }}'" class="bg-gray-300 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">確認</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="lg:w-1/2 md:w-2/3 mx-auto mt-12">
                                <hr>
                                <form action="{{ route('admin.admin_csv_upload') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <label for="csvfile" class="leading-7 text-sm text-gray-600">csvアップロード</label>
                                    <div class="p-2 w-full flex justify-around mt-4">
                                            <input type="file" id="csvfile" name="csvfile" class="bg-opacity-50 rounded focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 leading-8 transition-colors duration-200 ease-in-out">
                                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                                        </div>
                                </form>
                            </div> --}}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

