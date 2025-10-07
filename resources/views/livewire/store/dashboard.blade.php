<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Frontdesk of {{ auth()->user()->department->name ?? 'Unknown Department' }}</h2>
        <p class="text-gray-600 text-sm">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
    {{-- RFID Not Found Modal --}}
    <div
    x-data="{ showModal: @entangle('rfidNotFound') }"
    x-show="showModal"
    x-cloak
    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-xl font-bold text-red-600 mb-4">RFID Not Recognized</h2>
            <p class="text-gray-700 mb-4">The RFID code you scanned is not registered in the system.</p>
            <button
                @click="showModal = false"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
                Close
            </button>
        </div>
    </div>    
    {{-- Mode Switcher --}}
    <div class="flex gap-4 mb-6">
        <button wire:click="selectMode('rfid')" class="px-4 py-2 bg-blue-600 text-black font-semibold rounded hover:bg-blue-700 transition">
            RFID Charge
        </button>
        <button wire:click="selectMode('manual')" class="px-4 py-2 bg-green-600 text-black font-semibold rounded hover:bg-green-700 transition">
            Manual Charge
        </button>
    </div>

    {{-- RFID Mode --}}
    @if ($mode === 'rfid')
        <div class="mb-6">
            <label for="rfid_code" class="block text-gray-700 font-semibold">Scan RFID Code</label>
            <input wire:model.lazy="rfid_code" id="rfid_code" type="text"
                   class="mt-2 w-full border rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                   autofocus>
        </div>
    @endif

    {{-- Manual Mode --}}
    @if ($mode === 'manual')
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold">Select Family</label>
                <select wire:model.lazy="selected_family_id"
                        class="mt-2 w-full border rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">-- Choose Family --</option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">{{ $family->family_name }}</option>
                    @endforeach
                </select>
            </div>

            @if ($selected_family_id)
                <div>
                    <label class="block text-gray-700 font-semibold">Select Member</label>
                    <select wire:model.lazy="selected_member_id"
                            class="mt-2 w-full border rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        <option value="">-- Choose Member --</option>
                        @foreach ($familyMembers as $fm)
                            <option value="{{ $fm->id }}">{{ $fm->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    @endif

    {{-- Member Info & Charge Form --}}
    @if ($member)
        <div class="bg-yellow-100 border border-yellow-300 p-4 rounded-md mb-6">
            <p><strong>Name:</strong> {{ $member->name }}</p>
            <p><strong>Role:</strong> {{ $member->role }}</p>
            <p><strong>Spending Limit:</strong>
                @php
                    $rule = $member->rules->firstWhere('department_id', auth()->user()->department_id);
                @endphp
                {{ $rule && $rule->spending_limit !== null ? '₱' . number_format($rule->spending_limit, 2) : 'None' }}
            </p>
            <p><strong>Restriction:</strong> {{ $rule && $rule->is_restricted ? 'Restricted' : 'Allowed' }}</p>
        </div>

        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-semibold">Description</label>
                <input wire:model="description" type="text"
                       class="mt-2 w-full border rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Price (₱)</label>
                <input wire:model="price" type="number" step="0.01"
                       class="mt-2 w-full border rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring focus:border-green-300">
            </div>
        </div>

        <div class="text-right">
            <button wire:click="submitCharge"
                    class="px-6 py-2 bg-purple-600 text-black rounded hover:bg-purple-700 transition font-semibold">
                Submit Charge
            </button>
        </div>
    @endif

    {{-- Recent Charges --}}
    @if (count($charges) > 0)
        <div class="mt-10">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Charges (This Family & Department)</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow text-sm">
                    <thead class="bg-gray-100 text-left text-gray-600 font-medium">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Member</th>
                            <th class="px-4 py-3">Staff</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($charges as $c)
                            <tr>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($c->charge_datetime)->format('M d, Y') }}</td>
                                <td class="px-4 py-3">{{ $c->description }}</td>
                                <td class="px-4 py-3 text-green-600 font-semibold">₱{{ number_format($c->price, 2) }}</td>
                                <td class="px-4 py-3">{{ $c->member->name }}</td>
                                <td class="px-4 py-3">{{ $c->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
