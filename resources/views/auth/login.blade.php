<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <div class="mb-4 flex items-center justify-center">
            <img src="/img/logo.png" alt="Logo" class="h-10 w-auto">
            <h2 class="text-2xl font-bold text-center mb-6">
                <span class="text-[#eb5213]">L</span>ogin <span class="text-[#00aa6b]">P</span>age
            </h2>
            
        </div>
        <hr>

        
        @if(session('error'))
            <div class="mb-4 text-red-600 text-sm text-center">{{ session('error') }}</div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            



            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Login</button>
        </form>
    </div>
</body>
</html>
