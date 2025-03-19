<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        @include('admin.layouts.sidebar') <!-- Sidebar dipisahkan -->

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <div class="bg-white shadow p-4 flex justify-between">
                <div>
                    <img src="/img/logo.png" alt="Logo" class="h-10 w-auto">
                  </div>
                <h1 class="text-xl font-semibold">@yield('title')</h1>
                <a href="{{ route('logout') }}" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a>
            </div>

            <!-- Dynamic Content -->
            <div class="p-6">
                @yield('content') <!-- Konten diisi dari halaman berbeda -->
            </div>
        </div>
    </div>
</body>
</html>
