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
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">メール作成</h1>
                            </div>
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <form method="post" action="{{ route('admin.owner_confirm_mail') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="-m-2">
                                        <div class="p-2 mx-auto">
                                            <div class="relative">
                                                <p class="leading-7 text-lg font-semibold text-gray-600">form</p>
                                                <input type="hidden" name="from" value="{{ $login_user->email }}">
                                                <h4>{{ $login_user->email }}</h4>
                                            </div>
                                            <div class="relative">
                                                <p class="leading-7 text-lg font-semibold text-gray-600 mt-4">to</p>
                                                <input type="hidden" name="to" value="{{ $owner->email }}">
                                                <h4>{{ $owner->email }}</h4>
                                            </div>
                                            <div class="relative">
                                                <p class="leading-7 text-lg font-semibold text-gray-600 mt-4">subject</p>
                                                <input type="text" id="subject" name="subject" value="" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                            <div class="relative">
                                                <p class="leading-7 text-lg font-semibold text-gray-600 mt-4">content</p>
                                                <textarea name="content" id="content" cols="30" rows="10" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full flex justify-around mt-4">
                                            <button type="button" onclick="location.href='{{ route('admin.owners.index') }}'" class="bg-gray-300 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">確認</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

