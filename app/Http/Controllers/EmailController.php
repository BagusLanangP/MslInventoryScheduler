<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifikasiEmail;

class EmailController extends Controller
{
    public function kirimEmail()
    {
        $data = [
            'nama' => 'Bagus Lanang',
            'pesan' => 'Ini adalah email notifikasi dari Laravel.'
        ];

        Mail::to('ditapratiwi222@gmail.com')->send(new NotifikasiEmail($data));

        return "Email berhasil dikirim!";
    }
}
