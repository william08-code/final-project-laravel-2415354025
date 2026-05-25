@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-4xl font-bold primary-color mb-2">
            Customers
        </h1>

        <p class="text-gray-500">
            Customer management data
        </p>
    </div>

    <button
        type="button"
        onclick="openModal('customerModal')"
        class="primary-btn text-white px-6 py-3 rounded-2xl"
    >
        Add Customer
    </button>

</div>

<div class="bg-white rounded-3xl p-6 card-shadow overflow-x-auto">

    <table class="w-full">

        <thead>
            <tr class="border-b">
                <th class="text-left py-4 primary-color">Customer ID</th>
                <th class="text-left py-4 primary-color">Name</th>
                <th class="text-left py-4 primary-color">Email</th>
                <th class="text-left py-4 primary-color">Phone</th>
                <th class="text-left py-4 primary-color">Status</th>
                <th class="text-left py-4 primary-color">Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach($customers as $customer)

            <tr class="border-b hover:bg-[#F5EFEB] transition">

                <td class="py-4">
                    {{ $customer['customer_id'] }}
                </td>

                <td class="py-4 font-semibold">
                    {{ $customer['name'] }}
                </td>

                <td class="py-4">
                    {{ $customer['email'] }}
                </td>

                <td class="py-4">
                    {{ $customer['phone'] }}
                </td>

                <td class="py-4">

                    @if($customer['status'])

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
    id="customerModal"
    title="Add Customer"
>

<form
    action="{{ route('customers.store') }}"
    method="POST"
    class="space-y-4"
>
    @csrf

    <input
        type="text"
        name="customer_id"
        placeholder="Customer ID"
        class="w-full border p-3 rounded-xl"
        required
    >

    <input
        type="text"
        name="name"
        placeholder="Customer Name"
        class="w-full border p-3 rounded-xl"
        required
    >

    <input
        type="email"
        name="email"
        placeholder="Email"
        class="w-full border p-3 rounded-xl"
    >

    <input
        type="text"
        name="phone"
        placeholder="Phone"
        class="w-full border p-3 rounded-xl"
    >

    <textarea
        name="address"
        placeholder="Address"
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
        Save Customer
    </button>

</form>

</x-modal>

@endsection