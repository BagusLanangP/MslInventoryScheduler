@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create User</h1>

    <!-- Tampilkan pesan sukses -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form tambah user -->
    <form action="{{ route('admin.store-user') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf <!-- Token keamanan -->
        
        <label class="block mb-2 font-semibold">Username:</label>
        <input type="text" name="name" class="w-full border p-2 rounded @error('name') border-red-500 @enderror" value="{{ old('name') }}">
        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        
        <label class="block mt-4 mb-2 font-semibold">Gmail:</label>
        <input type="email" name="email" class="w-full border p-2 rounded @error('email') border-red-500 @enderror" value="{{ old('email') }}">
        @error('email')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mt-4 mb-2 font-semibold">Password:</label>
        <input type="password" name="password" class="w-full border p-2 rounded @error('password') border-red-500 @enderror">
        @error('password')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 w-full">Submit</button>
    </form>
@endsection

