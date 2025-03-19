<div class="w-64 bg-blue-900 text-white flex flex-col">
    <div class="p-6 text-lg font-semibold border-b border-blue-700">
        Admin Dashboard
    </div>
    <nav class="flex-1 px-4 py-2">
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Dashboard</a>
        <a href="{{ route('admin.create-user') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Create User</a>
        <a href="{{ route('admin.add-gmail') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Add Gmail</a>
        {{-- <a href="{{ route('admin.manage-posts') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Manage Posts</a>
        <a href="{{ route('admin.settings') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Settings</a>
        <a href="{{ route('logout') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Logout</a> --}}
    </nav>
</div>
