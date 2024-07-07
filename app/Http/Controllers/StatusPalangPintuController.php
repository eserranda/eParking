<?php

namespace App\Http\Controllers;

use App\Models\StatusPalangPintu;
use Illuminate\Http\Request;

class StatusPalangPintuController extends Controller
{
    public function index()
    {
        //
    }

    public function statusPalangKeluar()
    {
        $status = StatusPalangPintu::where('palang_pintu', 'palang_keluar')->first();
        return response()->json(['status' => $status->status]);
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
    public function show(StatusPalangPintu $statusPalangPintu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusPalangPintu $statusPalangPintu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($palang_pintu);
        $update = StatusPalangPintu::where('palang_pintu', 'palang_keluar')->first();
        $update->status =  $request->status;
        $update->save();
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusPalangPintu $statusPalangPintu)
    {
        //
    }
}
