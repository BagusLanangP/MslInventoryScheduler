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
                        <input type="checkbox" 
                        onchange="toggleStatus({{ $schedule->id }})"
                        class="w-5 h-5 cursor-pointer me-2"
                        {{ $schedule->status ? 'checked' : '' }}>
                        <a href="/schedule/{{ $schedule->id }}/edit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Edit</a>
                        <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus schedule ini?')">
                                Delete
                            </button>
                        </form>
                        <form action="/kirim/email/{{ $schedule->id }}"  method="POST" class="inline" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            @csrf
                            <button type="submit" class="bg-blue-300 text-white px-4 py-2 rounded-md">Kirim email</button>
                        </form>

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
</script>



@endsection