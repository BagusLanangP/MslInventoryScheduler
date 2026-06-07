<div id="sidebar" class="w-64 bg-slate-900 text-slate-100 flex flex-col fixed md:static inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-800 shadow-2xl md:shadow-none">
    
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-emerald-500/10 p-2 rounded-xl border border-emerald-500/20">
                <img src="/img/logo.png" alt="Logo" class="h-6 w-auto">
            </div>
            <span class="font-bold text-lg tracking-tight bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">MSL Admin</span>
        </div>
        <button id="sidebar-close" class="md:hidden text-slate-400 hover:text-white focus:outline-none p-1 rounded-lg hover:bg-slate-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        
        <!-- Dashboard Link -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 pl-3' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        @if(Auth::user() && Auth::user()->role === 'admin')
        <!-- User Management Link (Super Admin only) -->
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.create-user') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 pl-3' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>Manajemen User</span>
        </a>
        @endif

        <!-- Supplier CRUD Link -->
        <a href="{{ route('supplier_index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('supplier_index') || request()->routeIs('admin.create-supplier') || request()->routeIs('supplier.edit') || request()->routeIs('supplier.show') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 pl-3' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Supplier CRUD</span>
        </a>

        <!-- Inventory CRUD Link -->
        <a href="{{ route('inventory_index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('inventory_index') || request()->routeIs('inventory_checkings.create') || request()->routeIs('inventory.edit') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 pl-3' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" />
            </svg>
            <span>Inventory CRUD</span>
        </a>

        <!-- Schedule CRUD Link -->
        <a href="{{ route('admin.schedule.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.schedule.index') || request()->routeIs('schedule.create') || request()->routeIs('schedule.edit') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500 pl-3' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Schedule CRUD</span>
        </a>

    </nav>
    
    <!-- Sidebar Footer (Logged User) -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center font-bold text-emerald-400">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
            </div>
        </div>
    </div>

</div>
