@props(['status'])

@if($status === 'active')

<span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm">
    Active
</span>

@elseif($status === 'inactive')

<span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm">
    Inactive
</span>

@elseif($status === 'trial')

<span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm">
    Trial
</span>

@elseif($status === 'isolir')

<span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm">
    Isolir
</span>

@elseif($status === 'dismantle')

<span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm">
    Dismantle
</span>

@endif