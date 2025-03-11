@extends('layouts.index')

@section('tittle', 'homepage')
@section('content')

<div class="content mt-10 p-10 ">
    <div class="mb-4 flex gap-2">
        <button id="show-upcoming" class="bg-green-500 text-white px-4 py-2 rounded-md mt-2">Event yang Akan Datang</button>
        <button id="show-finished" class="bg-red-500 text-white px-4 py-2 rounded-md mt-2">Event yang Sudah Selesai</button>
    </div>
    
    
    <table class="table-fixed border border-gray-300 w-full">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border border-gray-400 px-4 w-[4%] py-2">No</th>
                <th class="border border-gray-400 px-4 w-[27%] py-2">Nama</th>
                <th class="border border-gray-400 px-4 w-[9%] py-2">Tanggal</th>
                <th class="border border-gray-400 px-4 w-[9%] py-2">Reminder</th>
                <th class="border border-gray-400 px-4 w-[35%] py-2">Catatan</th>
                <th class="border border-gray-400 px-4 w-[16%] py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataSchedule as $schedule)
                <tr class="odd:bg-white even:bg-gray-100"  data-status="{{ $schedule->status ? 'false' : 'true' }}" >
                    <td class="border border-gray-400 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->name }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->date }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->reminder_date }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $schedule->note }}</td>
                    <td class="border border-gray-400 px-4 py-2 ">
                        <div class="flex justify-end items-center">
                            <input type="checkbox" 
                            onchange="toggleStatus({{ $schedule->id }})"
                            class="w-5 h-5 cursor-pointer me-2"
                            {{ $schedule->status ? 'false' : 'true' }}>
                            <form action="{{ route('schedule.update', $schedule->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT') <!-- Wajib ada untuk update -->
                                <button type="submit" class="me-1 bg-blue-500 text-white rounded-sm p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M16.5 3l3 3L7.5 18H4.5V15L16.5 3z"/>
                                    </svg>
                                </button>
                            </form>
                            
                            
                            <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus schedule ini?')" class="p-1 text-white rounded-sm me-1 bg-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                            <form action="/kirim/email/{{ $schedule->id }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-white rounded-sm bg-green-500 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="  w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12L21.75 3l-9.75 9.75 9.75 9.75-19.5-9.75z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleStatus(id) {
        $.ajax({
            url: `/schedule/${id}/toggle-status`,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    let row = $("#row-" + id);

                    if (response.status) {
                        // Jika checklist aktif, pindahkan ke bawah & beri warna abu-abu
                        row.fadeOut(300, function() {
                            $(this).appendTo("#schedule-table").fadeIn().addClass("bg-gray-300");
                        });
                    } else {
                        // Jika checklist dihapus, pindahkan ke atas & hilangkan warna abu-abu
                        row.fadeOut(300, function() {
                            $(this).prependTo("#schedule-table").fadeIn().removeClass("bg-gray-300");
                        });
                    }
                }
            }
        });
    }


    document.getElementById('show-upcoming').addEventListener('click', function () {
        let rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let status = row.getAttribute('data-status');
            row.style.display = (status === 'false') ? '' : 'none'; // Tampilkan yang belum finish
        });
    });

    document.getElementById('show-finished').addEventListener('click', function () {
        let rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let status = row.getAttribute('data-status');
            row.style.display = (status === 'true') ? '' : 'none'; // Tampilkan yang sudah finish
        });
    });
</script>



@endsection