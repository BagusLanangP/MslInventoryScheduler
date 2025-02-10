@extends('layouts.index')

@section('tittle', 'homepage')
@section('content')



<div class="content p-10 ">
    <table class="table-fixed border border-gray-300 w-full">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border border-gray-400 px-4 w-[5%] py-2">No</th>
                <th class="border border-gray-400 px-4 w-[30%] py-2">Nama</th>
                <th class="border border-gray-400 px-4 w-[10%] py-2">Tanggal</th>
                <th class="border border-gray-400 px-4 w-[35%] py-2">Catatan</th>
                <th class="border border-gray-400 px-4 w-[20%] py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border border-gray-400 px-4 py-2">1961</td>
                <td class="border border-gray-400 px-4 py-2">The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                <td class="border border-gray-400 px-4 py-2">Malcolm Lockyer</td>
                <td class="border border-gray-400 px-4 py-2">1961</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="border border-gray-400 px-4 py-2">1961</td>
                <td class="border border-gray-400 px-4 py-2">Witchy Woman</td>
                <td class="border border-gray-400 px-4 py-2">The Eagles</td>
                <td class="border border-gray-400 px-4 py-2">1972</td>
            </tr>
            <tr>
                <td class="border border-gray-400 px-4 py-2">1961</td>
                <td class="border border-gray-400 px-4 py-2">Shining Star</td>
                <td class="border border-gray-400 px-4 py-2">Earth, Wind, and Fire</td>
                <td class="border border-gray-400 px-4 py-2">1975</td>
            </tr>
        </tbody>
    </table>
    <div class="flex justify-end">
        <a href="/schedule-create">
            <button class="bg-blue-600 rounded-md text-white px-4 py-2 mt-4 hover:bg-blue-700 justify-self-end">
                Buat Schedule
            </button>
        </a>        
    </div>
    

</div>



@endsection