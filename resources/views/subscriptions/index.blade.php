@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold primary-color mb-2">
            Subscriptions
        </h1>
        <p class="text-gray-500">
            Subscription management data
        </p>
    </div>

    <button
        type="button"
        onclick="openModal('subscriptionModal')"
        class="primary-btn text-white px-6 py-3 rounded-2xl"
    >
        Add Subscription
    </button>
</div>

<div class="bg-white rounded-3xl p-6 card-shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b">
                <th class="py-4 primary-color">Customer</th>
                <th class="py-4 primary-color">Service</th>
                <th class="py-4 primary-color">Start Date</th>
                <th class="py-4 primary-color">End Date</th>
                <th class="py-4 primary-color">Status</th>
                <th class="py-4 primary-color">Action</th>
            </tr>
        </thead>
        <tbody id="subscriptionTableBody">
            @foreach($subscriptions as $subscription)
                <tr class="border-b hover:bg-[#F5EFEB] transition" id="row-{{ $subscription['id'] }}">
                    <td class="py-4 font-semibold">
                        {{ $subscription['customer']['name'] ?? '-' }}
                    </td>
                    <td class="py-4">
                        {{ $subscription['service']['name'] ?? '-' }}
                    </td>
                    <td class="py-4">
                        {{ $subscription['start_date'] }}
                    </td>
                    <td class="py-4">
                        {{ $subscription['end_date'] }}
                    </td>
                    <td class="py-4">
                        <span class="bg-[#C8D9E6] text-[#2F4156] px-4 py-2 rounded-full text-sm capitalize">
                            {{ $subscription['status'] }}
                        </span>
                    </td>
                    <td class="py-4 flex gap-2 flex-wrap">
                        @if($subscription['status'] === 'dismantle')
                            <span class="text-red-500 text-sm font-semibold italic">No Action Allowed</span>
                        @else
                            @if($subscription['status'] !== 'active')
                                <form action="{{ route('subscriptions.changeStatus', $subscription['id']) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-green-600 transition">
                                        Activate
                                    </button>
                                </form>
                            @endif

                            @if($subscription['status'] !== 'isolir')
                                <form action="{{ route('subscriptions.changeStatus', $subscription['id']) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="isolir">
                                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-orange-600 transition">
                                        Isolir
                                    </button>
                                </form>
                            @endif

                            @if($subscription['status'] !== 'trial')
                                <form action="{{ route('subscriptions.changeStatus', $subscription['id']) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="trial">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-600 transition">
                                        Trial
                                    </button>
                                </form>
                            @endif

                            @if($subscription['status'] !== 'deactivate')
                                <form action="{{ route('subscriptions.changeStatus', $subscription['id']) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="deactivate">
                                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-600 transition">
                                        Deactivate
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('subscriptions.changeStatus', $subscription['id']) }}" method="POST" class="inline" onsubmit="return confirm('Apakah anda yakin ingin melakukan dismantle? Status tidak akan bisa diubah kembali!')">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="dismantle">
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-red-700 transition">
                                    Dismantle
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-modal id="subscriptionModal" title="Add Subscription">
    <form id="formAddSubscription" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
            <select name="customer_id" class="w-full border p-3 rounded-xl bg-white" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer['id'] }}">{{ $customer['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
            <select name="service_id" class="w-full border p-3 rounded-xl bg-white" required>
                <option value="">Select Service</option>
                @foreach($services as $service)
                    <option value="{{ $service['id'] }}">{{ $service['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
            <input type="date" name="start_date" class="w-full border p-3 rounded-xl" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
            <input type="date" name="end_date" class="w-full border p-3 rounded-xl" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Initial Status</label>
            <select name="status" class="w-full border p-3 rounded-xl bg-white">
                <option value="active">Active</option>
                <option value="trial">Trial</option>
                <option value="isolir">Isolir</option>
            </select>
        </div>

        <button
            type="submit"
            class="primary-btn text-white w-full py-3 rounded-2xl font-semibold mt-2"
        >
            Save Subscription
        </button>
    </form>
</x-modal>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('formAddSubscription');
    
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('subscriptions.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(response => {
                if(!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (typeof closeModal === "function") {
                        closeModal('subscriptionModal');
                    } else {
                        let modalEl = document.getElementById('subscriptionModal');
                        if (modalEl && window.bootstrap) {
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        }
                    }

                    // Insert data baru ke tabel HTML secara live tanpa refresh
                    const tableBody = document.getElementById('subscriptionTableBody');
                    const newRow = `
                        <tr class="border-b hover:bg-[#F5EFEB] transition" id="row-${data.data.id}">
                            <td class="py-4 font-semibold">${data.data.customer_name}</td>
                            <td class="py-4">${data.data.service_name}</td>
                            <td class="py-4">${data.data.start_date}</td>
                            <td class="py-4">${data.data.end_date}</td>
                            <td class="py-4">
                                <span class="bg-[#C8D9E6] text-[#2F4156] px-4 py-2 rounded-full text-sm capitalize">
                                    ${data.data.status}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-gray-400 italic">
                                Baru ditambahkan (Refresh halaman untuk opsi aksi penuh)
                            </td>
                        </tr>
                    `;
                    
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                    form.reset();
                } else {
                    alert("Gagal menyimpan: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Gagal: " + (error.message || "Terjadi kesalahan sistem atau validasi gagal."));
            });
        });
    }
});
</script>

@endsection