<?php

namespace App\Http\Controllers;

use App\Models\TarifParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TarifParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarif_parkir = TarifParkir::all();
        return view('tarif_parkir.index', compact('tarif_parkir'));
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
        $validator = Validator::make($request->all(), [
            'lama_parkir' => 'required|integer|unique:tarif_parkirs,lama_parkir',
            'tarif' => 'required|integer',
        ], [
            'lama_parkir.unique' => 'Lama parkir sudah ada',
            'tarif.integer' => 'Tarif harus berupa angka',
            'tarif.required' => 'Tarif harus diisi',
            'lama_parkir.required' => 'Lama parkir harus diisi',
            'lama_parkir.integer' => 'Lama parkir harus berupa angka',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        TarifParkir::create($request->all());
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(TarifParkir $tarifParkir, $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TarifParkir $tarifParkir, $id)
    {
        $data = $tarifParkir::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TarifParkir $tarifParkir, $id)
    {
        $data = $tarifParkir::find($id);

        $data->lama_parkir = $request->lama_parkir;
        $data->tarif = $request->tarif;

        $data->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        try {
            $deleteData = TarifParkir::findOrFail($id);
            $deleteData->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}