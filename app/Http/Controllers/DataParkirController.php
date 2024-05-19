<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataParkir;
use App\Models\TarifParkir;
use Illuminate\Http\Request;

class DataParkirController extends Controller
{
    public function index()
    {
        // Ambil semua data parkir dari database
        $data_parkir = DataParkir::limit(10)->get();
        $tarif_parkir = TarifParkir::all();

        // Ambil tarif berdasarkan lama parkir
        $tarif_satu_jam = $tarif_parkir->where('lama_parkir', 1)->first()->tarif;
        $tarif_jam_berikutnya = $tarif_parkir->where('lama_parkir', 2)->first()->tarif;

        // Iterasi melalui setiap entri dan hitung selisih waktu
        foreach ($data_parkir as $entry) {
            $tanggalMasuk = $entry->tanggal;
            $jamMasuk = $entry->jam_masuk;
            $now = Carbon::now();

            // Gabungkan tanggal dan jam masuk untuk membuat objek Carbon
            $dateTimeMasuk = Carbon::createFromFormat('Y-m-d H:i:s', $tanggalMasuk . ' ' . $jamMasuk);

            // Hitung selisih waktu menggunakan diffInMinutes
            $diffInMinutes = $dateTimeMasuk->diffInMinutes($now);
            $diffInHours = floor($diffInMinutes / 60);
            $remainingMinutes = $diffInMinutes % 60;
            $diffInSeconds = $dateTimeMasuk->diffInSeconds($now) % 60;

            // Tentukan lama parkir dalam format "HH:mm:ss"
            $lama_parkir = sprintf('%02d:%02d:%02d', $diffInHours, $remainingMinutes, $diffInSeconds);

            // Hitung total tagihan
            if ($diffInHours < 1) {
                $total_tagihan = $tarif_satu_jam;
            } else {
                // Hitung tarif untuk jam pertama dan setiap jam berikutnya
                $total_tagihan = $tarif_satu_jam + (($diffInHours - 1) * $tarif_jam_berikutnya);
                // Jika ada sisa menit setelah jam penuh, tambahkan tarif jam berikutnya
                if ($remainingMinutes > 0 || $diffInSeconds > 0) {
                    $total_tagihan += $tarif_jam_berikutnya;
                }
            }

            // Simpan hasil lama parkir dan total tagihan dalam field yang sesuai
            $entry->lama_parkir = $lama_parkir;
            $entry->total_tagihan = $total_tagihan;

            // Simpan perubahan ke database
            $entry->save();
        }

        // Kembalikan tampilan dengan data parkir yang diperbarui
        return view('data_parkir.index', compact('data_parkir'));
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DataParkir $dataParkir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataParkir $dataParkir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataParkir $dataParkir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleteData = DataParkir::findOrFail($id);
            $deleteData->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}