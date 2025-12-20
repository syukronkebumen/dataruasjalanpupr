<?php

namespace App\Http\Controllers;

use App\Models\RuasJalan;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataRuasJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = RuasJalan::all();
        $final = $data->map(function ($item) {

                $segments = preg_split('/\s+/', trim($item->polyline));

                $coords = [];
                foreach ($segments as $seg) {
                    if (str_contains($seg, ',')) {
                        [$lat, $lng] = explode(',', $seg);
                        $coords[] = [(float)$lat, (float)$lng];
                    }
                }

                return [
                    'name' => $item->name,
                    'panjang' => $item->panjang,
                    'fungsi' => $item->fungsi,
                    'kecamatan' => $item->kecamatan,
                    'wilayah' => $item->wilayah,
                    'no_ruas' => $item->no_ruas,
                    'jumlah_titik' => $item->jumlah_titik,    
                    'coords' => $coords
                ];
            });
            
            return response()->json($final);
        
    }

    public function batasWilayah()
    {
        $path = public_path('storage/geojson/batas_lamtim.geojson');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $geojson = file_get_contents($path);
        $data = json_decode($geojson, true);

        return response()->json($data);
    }

    public function batasKecamatan()
    {
        $path = public_path('storage/geojson/batas_kecamatan.geojson');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $geojson = file_get_contents($path);
        $data = json_decode($geojson, true);

        return response()->json($data);
    }

    public function batasKelurahan()
    {
        $path = public_path('storage/geojson/batas_kelurahan.geojson');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $geojson = file_get_contents($path);
        $data = json_decode($geojson, true);

        return response()->json($data);
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
    public function landingpage()
    {
        $datas = RuasJalan::paginate(20);
        return view('landingpage', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
