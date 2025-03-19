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
        $email = 'baguslanangpurbhawa@gmail.com';
    
        $data = [
            "name" => $schedule->name,
            "catatan" => $schedule->note,
            "date" => $schedule->date,
            "reminder_date" => $schedule->reminder_date
        ];
    

        Mail::to($email)->send(new NotifikasiEmail($data));

          // Simpan pesan sukses dalam session
         // Simpan pesan sukses dalam session dengan interpolasi string yang benar
    return redirect()->back()->with('success', "Email berhasil dikirim ke $email");
    }
}
