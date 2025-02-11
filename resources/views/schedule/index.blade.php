@extends('layouts.index')

@section('tittle', 'homepage')
@section('content')

<div class="content p-10 ">
    <table class="table-fixed border border-gray-300 w-full">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border border-gray-400 px-4 w-[4%] py-2">No</th>
                <th class="border border-gray-400 px-4 w-[27%] py-2">Nama</th>
                <th class="border border-gray-400 px-4 w-[7%] py-2">Tanggal</th>
                <th class="border border-gray-400 px-4 w-[7%] py-2">Reminder</th>
                <th class="border border-gray-400 px-4 w-[35%] py-2">Catatan</th>
                <th class="border border-gray-400 px-4 w-[20%] py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataSchedule as $schedule)
                <tr>
                    <td class="border border-gray-400 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->name }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->date }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->reminder_date }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->note }}</td>
                    <td class="border border-gray-400 px-4 py-2">
                        <a href="/schedule/{{ $schedule->id }}/edit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Edit</a>
                        <form action="/schedule/{{ $schedule->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                        </form>
                        <a href="/schedule/{{ $schedule->id }}/edit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Checklist button</a>
                        <a href="/schedule/{{ $schedule->id }}/edit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Kirim</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end">
        <a href="/schedule-create">
            <button class="bg-green-500 rounded-md text-white px-4 py-2 mt-4 hover:bg-green-600 justify-self-end me-4">
                Simpan Sebagai Excel
            </button>
        </a>  
        <a href="/schedule-create">
            <button class="bg-blue-600 rounded-md text-white px-4 py-2 mt-4 hover:bg-blue-700 justify-self-end">
                Buat Schedule
            </button>
        </a>
                   
    </div>
    

</div>



@endsection