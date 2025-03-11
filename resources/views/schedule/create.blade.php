@extends('layouts.index')

@section('title', isset($schedule) ? 'Edit Schedule' : 'Buat Schedule')

@section('content')
    <div class="content-mid flex justify-center mt-14">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg mt-10">
            <h2 class="text-xl font-semibold text-center mb-4">
                {{ isset($schedule) ? 'Edit Schedule' : 'Form Buat Schedule' }}
            </h2>
    
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
    
            <form action="{{ isset($schedule) ? route('schedule.update', $schedule->id) : route('schedule.store') }}" method="POST" class="space-y-4 mt-10">
                @csrf
                @if(isset($schedule))
                    @method('PUT')
                @endif
    
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $schedule->name ?? '') }}" required class="w-full p-2 border rounded-lg">
                </div>
    
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $schedule->date ?? '') }}" required class="w-full p-2 border rounded-lg">
                </div>                
    
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tambahkan Catatan Untuk Nanti</label>
                    <input type="text" name="note" id="note" value="{{ old('note', $schedule->note ?? '') }}" required class="w-full p-2 border rounded-lg">
                </div>
    
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Reminder</label>
                    <input type="date" name="reminder_date" id="reminder_date" value="{{ old('reminder_date', $schedule->reminder_date ?? '') }}" required class="w-full p-2 border rounded-lg">
                </div>
    
                <div class="flex items-center">
                    <input type="hidden" name="berulang" value="0">
                    <input type="checkbox" name="berulang" id="berulang" value="1" {{ isset($schedule) && $schedule->berulang ? 'checked' : '' }} class="w-4 h-4">
                    <label for="berulang" class="ml-2 text-sm text-gray-700">Jadikan Berulang?</label>
                </div>
    
                <div id="holidayContainer" class="hidden mt-3">
                    <label class="block text-sm font-medium text-gray-700">Pilih Hari Libur</label>
                    <ul id="holidayList" class="border rounded-lg p-2 bg-gray-50 max-h-40 overflow-y-auto">
                        @foreach($dataApi as $date => $name)
                            <li class="p-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer mb-1"
                                onclick="selectHoliday('{{ $name }}', '{{ $date }}')">
                                {{ $name }} - {{ $date }}
                            </li>
                        @endforeach
                    </ul>
                </div>
    
                <button type="button" onclick="toggleHolidayList()" class="bg-green-500 text-white px-4 py-2 rounded-md w-full">
                    Lihat Hari Libur dari API
                </button>
    
                <div class="action flex justify-end">
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                        {{ isset($schedule) ? 'Update Schedule' : 'Booking Sekarang' }}
                    </button>
                </div>
                
            </form>
        </div>
    </div>

    <script>
        function toggleHolidayList() {
            const container = document.getElementById('holidayContainer');
            container.classList.toggle('hidden');
        }

        function selectHoliday(name, date) {
            document.getElementById('name').value = name;
            document.getElementById('date').value = date;
        }
    </script>
@endsection
