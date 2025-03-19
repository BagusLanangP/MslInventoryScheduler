@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Users</h2>
            <p class="text-gray-600">Total: {{$userCount}}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Schedule</h2>
            <p class="text-gray-600">Total: {{ $completedSchedule}} / {{$totalSchedule}}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Messages</h2>
            <p class="text-gray-600">Total: 30</p>
        </div>
    </div>


    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden mt-6">
        <thead class="bg-blue-500 text-white">
            <tr>
                <th class="py-2 px-4">No</th>
                <th class="py-2 px-4">Nama</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Dibuat Pada</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                    <td class="py-2 px-4">
                        <a href="#" class="text-blue-500">Edit</a> |
                        <a href="#" class="text-red-500">Hapus</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
