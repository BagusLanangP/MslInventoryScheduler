<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifikasiEmail;
use App\Models\Schedule;

class EmailController extends Controller
{
    public function kirimEmail($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return back()->with('error', 'Data tidak ditemukan.');
        }
    
        $data = [
            "nama" => $schedule->name,
            "catatan" => $schedule->note,
            "date" => $schedule->date,
            "reminder_date" => $schedule->reminder_date
        ];
    

        Mail::to('baguslanangpurbhawa@gmail.com')->send(new NotifikasiEmail($data));

        return "Email berhasil dikirim!";
    }
}
