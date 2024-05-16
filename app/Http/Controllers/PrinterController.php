<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataParkir;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class PrinterController extends Controller
{

    public function index()
    {
        //
    }

    function printToPrinter($timeNow)
    {

        $now = Carbon::now()->format('d M Y, H:i:s');
        $printerName = "p_parkir";

        try {
            // Menghubungkan ke printer
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("\nMTOS MAKASSAR\n(Makassar Town Square)\nJl. Perintis Kemerdekaan No.KM.7\n\nParkir Mobil\n$now WITA\n");
            $testStr =  $timeNow;
            $sizes = 10;
            $printer->qrCode($testStr, Printer::QR_ECLEVEL_L, $sizes);
            $printer->text("\n");
            $printer->text($testStr);
            $printer->text("\n\nHarap Jangan Meninggalkan Barang Berharaga Anda di Dalam\nKendaraan\n\n");
            $printer->text("Denda Kehilangan Tiket Mobil\nRp.20.000");
            $printer->setJustification();
            $printer->feed();

            // Cut & close
            $printer->cut();
            $printer->close();

            return "Success"; // Berhasil mencetak
        } catch (\Exception $e) {
            return false; // Gagal mencetak
        }
    }



    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $now = Carbon::now();
        $timeNow = round(microtime(true) * 1000);

        $dataParkir = [
            'no_parkir' => $timeNow,
            'jenis_kendaraan' => 'Mobil',
            'tanggal' => $now->format('y-m-d'),
            'jam_masuk' => $now->format('H:i:s'),
            'jam_keluar' => null,
            'lama_parkir' => null,
            'total_tagihan' => 0,
            'keterangan' => null
        ];

        $saveData = DataParkir::create($dataParkir);

        if ($saveData) {
            $printResult = $this->printToPrinter($timeNow);
            if ($printResult === "Success") {
                return response()->json(['message' => 'Data berhasil disimpan dan dicetak'], 201);
            } else {
                return response()->json(['message' => 'Data berhasil disimpan, tetapi gagal mencetak'], 500);
            }
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }

        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }

    public function show(Printer $printer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Printer $printer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Printer $printer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Printer $printer)
    {
        //
    }
}
