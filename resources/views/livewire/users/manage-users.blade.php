<div class="p-4 w-full mx-auto">

    {{-- Success Message --}}
    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Register User Button --}}
    <button wire:click="openModal()" 
            class="bg-cyan-600 text-white px-4 py-2 rounded mb-4 hover:bg-cyan-700">
        Register User
    </button>

    {{-- Users Table --}}
    <div class="overflow-x-auto">
        <table class="w-full border text-sm text-gray-900 dark:text-gray-100">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="p-2 border">S/N</th>
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Role</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr class="border-t">
                    <td class="p-2 border text-center">{{ $index + 1 }}</td>
                    <td class="p-2 border">{{ $user->name }}</td>
                    <td class="p-2 border">{{ $user->email }}</td>
                    <td class="p-2 border">{{ ucfirst($user->role) }}</td>
                    <td class="p-2 border flex gap-2">
                        <button wire:click="editUser({{ $user->id }})" 
                                class="bg-yellow-500 text-white px-2 py-1 rounded">
                            Edit
                        </button>
                        {{-- <button wire:click="deleteUser({{ $user->id }})" 
                                class="bg-red-600 text-white px-2 py-1 rounded">
                            Delete
                        </button> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal for Register / Edit User --}}
    {{-- Modal for Register / Edit User --}}
@if($showModal)
<div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-900 w-full max-w-md rounded-lg shadow-lg p-6 relative">

        {{-- Close Button --}}
        <button wire:click="closeModal()" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900">&times;</button>

        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">
            {{ $editingUserId ? 'Edit User' : 'Register User' }}
        </h2>

        {{-- Form --}}
        <div class="space-y-2">
            <input type="text" wire:model="name" placeholder="Name" 
                   class="border rounded p-2 w-full bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
            <input type="email" wire:model="email" placeholder="Email" 
                   class="border rounded p-2 w-full bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
            <input type="password" wire:model="password" placeholder="Password" 
                   class="border rounded p-2 w-full bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
            <select wire:model="role" class="border rounded p-2 w-full bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="cashier">Cashier</option>
            </select>
            <button wire:click="saveUser" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white py-2 rounded">
                {{ $editingUserId ? 'Update User' : 'Add User' }}
            </button>
            <button wire:click="resetForm" class="w-full mt-2 bg-gray-400 text-white py-2 rounded">Reset</button>
        </div>

    </div>
</div>
@endif


</div>
