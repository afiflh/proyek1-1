<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking');
    }

    public function tampil()
    {
<<<<<<< HEAD
        $history = Booking::where('user_id', '=', Auth::user()->id)->where('status', '=', 'pending')->get();
        dd($history);
        return view('tampil')->with('history', $history);
=======
        $booking = Booking::all();
        return view('tampil', [
            'bkg' => $booking
        ]);
>>>>>>> 2220780c7b6caf36349f9948dbefd8870ada793c
    }

    public function create(){
        return view('booking');
    }

    public function payment($booking_id)
{
    // Temukan booking berdasarkan ID
    $booking = Booking::findOrFail($booking_id);

    // Tampilkan halaman pembayaran dengan detail booking
    return view('payment', compact('booking'));
}

public function processPayment(Request $request, $booking_id)
{
    // Temukan booking berdasarkan ID
    $booking = Booking::findOrFail($booking_id);

    // Validasi input pembayaran
    $request->validate([
<<<<<<< HEAD
        'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
=======
        'payment_method' => 'required',
>>>>>>> 2220780c7b6caf36349f9948dbefd8870ada793c
        // Tambahkan validasi input lainnya sesuai kebutuhan
    ]);

    // Proses pembayaran
    // ...
<<<<<<< HEAD

    // Simpan bukti pembayaran ke storage
    $bukti_pembayaran = $request->file('bukti_pembayaran');
    $path = $bukti_pembayaran->store('public/bukti_pembayaran');

    // Simpan path bukti pembayaran dalam database atau variabel lainnya
    $booking->bukti_pembayaran = $path;
    $booking->status =  'pending';
    $booking->save();

    // ...

    return redirect()->route('booking.history', $booking->id)->with('success', 'Pembayaran berhasil');
}


=======
    // Lakukan logika pemrosesan pembayaran sesuai dengan metode pembayaran yang dipilih
    // ...

    // Simpan status pembayaran pada booking
    $booking->payment_status = true;
    $booking->save();

    return redirect()->route('booking.tampil')->with('success', 'Pembayaran berhasil');
}



>>>>>>> 2220780c7b6caf36349f9948dbefd8870ada793c
    public function store(Request $request){
    $nama = $request->input('nama');
    $tanggal_berangkat = $request->input('tanggal_berangkat');
    $tanggal_pulang = $request->input('tanggal_pulang');
    $jumlah_pendaki = $request->input('jumlah_pendaki');

    // Validasi kuota tersedia
    $kuotaTersedia = Kuota::whereBetween('tanggal', [$tanggal_berangkat, $tanggal_pulang])->sum('kuota');
    if ($kuotaTersedia < $jumlah_pendaki) {
        return redirect('/booking')->with('error', 'Kuota tidak mencukupi');
    }

<<<<<<< HEAD
    $nominal = $jumlah_pendaki * 15000;
=======
    $total_amount = $jumlah_pendaki * 15000;
>>>>>>> 2220780c7b6caf36349f9948dbefd8870ada793c

    // Membuat booking baru
    $booking = new Booking();
    $booking->nama = $nama;
    $booking->tanggal_berangkat = $tanggal_berangkat;
    $booking->tanggal_pulang = $tanggal_pulang;
    $booking->jumlah_pendaki = $jumlah_pendaki;
<<<<<<< HEAD
    $booking->nominal = $nominal;
    $booking->user_id = Auth::user()->id;
=======
    $booking->total_amount = $total_amount;
>>>>>>> 2220780c7b6caf36349f9948dbefd8870ada793c
    $booking->save();

    // Mengurangi kuota yang tersedia
    $kuotas = Kuota::whereBetween('tanggal', [$tanggal_berangkat, $tanggal_pulang])->get();
    foreach ($kuotas as $kuota) {
        $kuota->kuota -= $jumlah_pendaki;
        $kuota->save();
    }
    return redirect()->route('booking.payment', ['booking_id' => $booking->id])->with('success', 'Booking berhasil');

<<<<<<< HEAD
=======
    return redirect()->route('booking.payment', ['booking_id' => $booking->id])->with('success', 'Booking berhasil');

>>>>>>> 2220780c7b6caf36349f9948dbefd8870ada793c
    }

    public function getHistory(){
        $history = Booking::where('user_id', '=', Auth::user()->id)->get();
        return view('history', [
            'history' => $history
        ]);
    }
}