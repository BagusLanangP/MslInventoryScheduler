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
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">jenis Barang</h2>
            <p class="text-gray-600">Total: {{$jenisBarangs}} </p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Supplier</h2>
            <p class="text-gray-600">Total: {{ $supplier }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Inventory</h2>
            <p class="text-gray-600">Total: {{ $Inventory}}</p>
        </div>
    </div>
    <div class="bg-white rounded shadow mt-6">
        <div class="bg-red-500 p-4">
            <h2 class="text-xl text-white font-semibold">Stok Mendekati Expired (7 hari)</h2>
        </div>
        <table class="m-4 w-full border-collapse">
            <thead>
                <tr>
                    <th class="border-b-2 p-2 text-left">Nama Barang</th>
                    <th class="border-b-2 p-2 text-left">Tanggal Expired</th>
                    <th class="border-b-2 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expiredSoon as $item)
                    <tr>
                        <td class="border-b p-2">{{ $item->nama }}</td>
                        <td class="border-b p-2">{{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}</td>
                        <td class="border-b p-2">
                            <a href="" class="text-blue-500 hover:underline ml-2">Perbarui Stok</a>
                            <a href="" class="text-red-500 hover:underline ml-2">Hapus</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-2 text-center">Tidak ada yang mau expired.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="bg-white rounded shadow mt-6">
        <div class="bg-green-500 p-4">
            <h2 class="text-xl text-white font-semibold">Schedule dalam (7 hari)</h2>
        </div>
        <table class="m-4 w-full border-collapse">
            <thead>
                <tr>
                    <th class="border-b-2 p-2 text-left">Nama</th>
                    <th class="border-b-2 p-2 text-left">Tanggal | Reminder date</th>
                    <th class="border-b-2 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expiredSoon as $item)
                    <tr>
                        <td class="border-b p-2">{{ $item->nama }}</td>
                        <td class="border-b p-2">{{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}</td>
                        <td class="border-b p-2">
                            <a href="" class="text-blue-500 hover:underline ml-2">Perbarui Stok</a>
                            <a href="" class="text-red-500 hover:underline ml-2">Hapus</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-2 text-center">Tidak ada schedule dengan waktu terdekat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
