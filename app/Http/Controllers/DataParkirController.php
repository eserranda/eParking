<?php

namespace App\Http\Controllers;

use App\Models\DataParkir;
use Illuminate\Http\Request;

class DataParkirController extends Controller
{
    public function index()
    {
        $data_parkir = DataParkir::limit(10)->get();
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
    public function destroy(DataParkir $dataParkir)
    {
        //
    }
}
