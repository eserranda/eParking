<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class PrinterController extends Controller
{

    public function index()
    {
        //
    }

    function printToPrinter()
    {

        $now = Carbon::now()->format('d M Y H:i:s');
        $printerName = "p_parkir";
        $timeNow = round(microtime(true) * 1000);

        try {
            // Menghubungkan ke printer
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("\nMTOS MAKASSAR\n(Makassar Town Square)\nJl. Perintis Kemerdekaan No.KM.7\n\nParkir Mobil\nWaktu: $now WITA\n");
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

            return true; // Berhasil mencetak
        } catch (\Exception $e) {
            return false; // Gagal mencetak
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