<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Parkir;
use App\Models\DataParkir;
use App\Models\TarifParkir;
use Illuminate\Http\Request;

class ParkirController extends Controller
{
    public function index()
    {
        return view('parkir.index');
    }

    public function findOneKodeParkir($no_parkir)
    {
        $data_parkir = DataParkir::where('no_parkir', $no_parkir)->first();

        if ($data_parkir) {
            // Fetch the tariff information
            $tarif_parkir = TarifParkir::all();
            $tarif_satu_jam = $tarif_parkir->where('lama_parkir', 1)->first()->tarif;
            $tarif_jam_berikutnya = $tarif_parkir->where('lama_parkir', 2)->first()->tarif;

            // Calculate the parking duration and total charge
            $tanggalMasuk = $data_parkir->tanggal;
            $jamMasuk = $data_parkir->jam_masuk;
            $now = Carbon::now();

            // Combine date and time of entry to create a Carbon object
            $dateTimeMasuk = Carbon::createFromFormat('Y-m-d H:i:s', $tanggalMasuk . ' ' . $jamMasuk);

            // Calculate the time difference using diffInMinutes
            $diffInMinutes = $dateTimeMasuk->diffInMinutes($now);
            $diffInHours = floor($diffInMinutes / 60);
            $remainingMinutes = $diffInMinutes % 60;
            $diffInSeconds = $dateTimeMasuk->diffInSeconds($now) % 60;

            // Determine the parking duration in the format "HH:mm:ss"
            $lama_parkir = sprintf('%02d:%02d:%02d', $diffInHours, $remainingMinutes, $diffInSeconds);

            // Calculate the total charge
            if ($diffInHours < 1) {
                $total_tagihan = $tarif_satu_jam;
            } else {
                $total_tagihan = $tarif_satu_jam + ($diffInHours * $tarif_jam_berikutnya);

                // Add charge for remaining minutes and seconds

                // if ($remainingMinutes > 0 || $diffInSeconds > 0) {
                //     $total_tagihan += $tarif_jam_berikutnya;
                // }
            }

            // Update the data_parkir object with calculated values
            $data_parkir->lama_parkir = $lama_parkir;
            $data_parkir->total_tagihan = $total_tagihan;

            return response()->json([
                'success' => true,
                'data' => $data_parkir
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }
    }

    public function updateDataParkir(Request $request)
    {
        $status = $request->status;
        $no_parkir = $request->no_parkir;

        $now = Carbon::now();
        $time = $now->format('H:i:s');

        $update = DataParkir::where('no_parkir', $no_parkir)->first();
        $update->keterangan =  $status;
        $update->jam_keluar =  $time;
        $update->save();

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Data berhasil update'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Data gagal di update'], 500);
        }
    }

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
    public function show(Parkir $parkir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parkir $parkir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parkir $parkir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parkir $parkir)
    {
        //
    }
}
