@props([
    'id',
    'title'
])

<div
    id="{{ $id }}"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50"
>

    <div class="bg-white rounded-3xl p-8 w-full max-w-2xl relative">

        <button
            onclick="closeModal('{{ $id }}')"
            class="absolute top-4 right-6 text-3xl"
        >
            ×
        </button>

        <h2 class="text-2xl font-bold primary-color mb-6">
            {{ $title }}
        </h2>

        {{ $slot }}

    </div>

</div>