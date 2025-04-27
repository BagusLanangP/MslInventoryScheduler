<div class="w-64 bg-blue-900 text-white flex flex-col">
    <div class="p-6 text-lg font-semibold border-b border-blue-700">
        Admin Dashboard
    </div>
    <nav class="flex-1 px-4 py-2">
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Dashboard</a>
        <a href="{{ route('admin.create-user') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">User CRUD</a>
        <a href="{{ route('supplier_index') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Supplier CRUD</a>
        <a href="{{ route('inventory_index') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Inventory CRUD</a>
        <a href="{{ route('schedule.index') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Schedule CRUD</a>
    </nav>
</div>




