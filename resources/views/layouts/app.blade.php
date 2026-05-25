<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>ERP App</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        body {
            background-color: #F5EFEB;
        }

        .sidebar-bg {
            background-color: #2F4156;
        }

        .primary-color {
            color: #2F4156;
        }

        .secondary-color {
            color: #567C8D;
        }

        .primary-btn {
            background-color: #567C8D;
        }

        .primary-btn:hover {
            background-color: #2F4156;
        }

        .card-shadow {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

    </style>

</head>

<body>

<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col">

        @include('layouts.navbar')

        <main class="p-8">
            @yield('content')
        </main>

        @include('layouts.footer')

    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            console.error('Modal dengan ID ' + id + ' tidak ditemukan.');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
</script>

</body>
</html>