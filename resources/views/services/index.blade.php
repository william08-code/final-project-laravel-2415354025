@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-4xl font-bold primary-color mb-2">
            Services
        </h1>

        <p class="text-gray-500">
            Service management data
        </p>
    </div>

    <button
        type="button"
        onclick="openModal('serviceModal')"
        class="primary-btn text-white px-6 py-3 rounded-2xl"
    >
        Add Service
    </button>

</div>

<div class="bg-white rounded-3xl p-6 card-shadow overflow-x-auto">

    <table class="w-full">

        <thead>
            <tr class="border-b">
                <th class="text-left py-4 primary-color">Name</th>
                <th class="text-left py-4 primary-color">Price</th>
                <th class="text-left py-4 primary-color">Description</th>
                <th class="text-left py-4 primary-color">Status</th>
                <th class="text-left py-4 primary-color">Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach($services as $service)

            <tr class="border-b hover:bg-[#F5EFEB] transition">

                <td class="py-4 font-semibold">
                    {{ $service['name'] }}
                </td>

                <td class="py-4">
                    Rp {{ number_format($service['price']) }}
                </td>

                <td class="py-4">
                    {{ $service['description'] }}
                </td>

                <td class="py-4">

                    @if($service['status'])

                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm">
                            Active
                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm">
                            Inactive
                        </span>

                    @endif

                </td>

                <td class="py-4 flex gap-2">

                    <button
                        type="button"
                        class="bg-[#567C8D] text-white px-4 py-2 rounded-xl"
                    >
                        Edit
                    </button>

                    <button
                        type="button"
                        class="bg-red-500 text-white px-4 py-2 rounded-xl"
                    >
                        Delete
                    </button>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<x-modal
    id="serviceModal"
    title="Add Service"
>

<form
    action="{{ route('services.store') }}"
    method="POST"
    class="space-y-4"
>
    @csrf

    <input
        type="text"
        name="name"
        placeholder="Service Name"
        class="w-full border p-3 rounded-xl"
        required
    >

    <input
        type="number"
        name="price"
        placeholder="Price"
        class="w-full border p-3 rounded-xl"
        required
    >

    <textarea
        name="description"
        placeholder="Description"
        class="w-full border p-3 rounded-xl"
    ></textarea>

    <select
        name="status"
        class="w-full border p-3 rounded-xl"
    >
        <option value="active">
            Active
        </option>

        <option value="inactive">
            Inactive
        </option>
    </select>

    <button
        type="submit"
        class="primary-btn text-white w-full py-3 rounded-2xl"
    >
        Save Service
    </button>

</form>

</x-modal>

@endsection