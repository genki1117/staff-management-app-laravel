{{-- 成功時 --}}
@if (session('successMessage'))
    <div class="flash-message bg-blue-100 border border-blue-500 text-blue-700 px-4 py-3 mb-4 rounded" role="alert">
        <p class="font-bold">{{ session('successMessage') }}</p>
    </div>
@endif
{{-- 失敗時 --}}
@if (session('errorMessage'))
    <div class="flash-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded" role="alert">
        <p class="font-bold">{{ session('errorMessage') }}</p>
    </div>
@endif
