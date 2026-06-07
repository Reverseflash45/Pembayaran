<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function guest() { return view('antrian.guest'); }

    public function guestStore(Request $request) {
        $last = Antrian::whereDate('created_at', today())->max('nomor') ?? 0;
        Antrian::create(['nomor' => $last + 1, 'nama' => $request->nama, 'status' => 'menunggu']);
        return back()->with('success', 'Nomor Antrian: ' . ($last + 1));
    }

    public function admin() {
        $antrians = Antrian::whereDate('created_at', today())->get();
        return view('antrian.admin', compact('antrians'));
    }

    public function panggil($id) {
        Antrian::where('status', 'dipanggil')->update(['status' => 'selesai']);
        Antrian::where('id', $id)->update(['status' => 'dipanggil']);
        return back();
    }

    public function papan() { return view('antrian.papan'); }

    public function stream() {
        set_time_limit(0);
        
        // KUNCI ANTI-MUNYER: Lepaskan lock session PHP!
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        return response()->stream(function () {
            while (true) {
                if (connection_aborted()) break;
                
                $data = [
                    'dipanggil' => Antrian::where('status', 'dipanggil')->whereDate('created_at', today())->first(),
                    'menunggu' => Antrian::where('status', 'menunggu')->whereDate('created_at', today())->get()
                ];

                echo 'event: queue-update' . PHP_EOL;
                echo 'data: ' . json_encode($data) . PHP_EOL . PHP_EOL;
                
                ob_flush();
                flush();
                
                sleep(2);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}