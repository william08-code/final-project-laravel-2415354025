@if(session('toast_success'))

<div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
    {{ session('toast_success') }}
</div>

@endif

@if(session('toast_error'))

<div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
    {{ session('toast_error') }}
</div>

@endif