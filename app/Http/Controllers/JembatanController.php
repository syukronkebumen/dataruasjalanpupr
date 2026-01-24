<?php

namespace App\Http\Controllers;

use App\Models\Jembatan;
use App\Models\KetMantap;
use Illuminate\Http\Request;

class JembatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isWhere = "Kemantapan Jembatan";
        $dataJembatan = Jembatan::leftjoin('tb_kemantapan_jemb', 'tb_jemb.no_jemb', '=', 'tb_kemantapan_jemb.no_jemb')
                        ->select('tb_jemb.*', 
                            'tb_kemantapan_jemb.panjang_meter',
                            'tb_kemantapan_jemb.lebar_meter',
                            'tb_kemantapan_jemb.tipe_lantai',
                            'tb_kemantapan_jemb.kondisi_jemb'
                            );
        $isData = $dataJembatan->get();
        $kondisiCounts = $isData->groupBy('kondisi_jemb')->map->count();
        $datas = $dataJembatan->paginate(10);
        $dataJembatan = $dataJembatan->count();
        $totalJembatan = $dataJembatan;

        $getKemantapan = KetMantap::where('jenis_mantap', $isWhere)->first();
        $indeksKemantapan = $getKemantapan->mantap_persen;


        return view('jembatan.index', compact(
            'datas',
            'totalJembatan',
            'indeksKemantapan',
            'kondisiCounts'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

         $dataJembatan = Jembatan::leftjoin('tb_kemantapan_jemb', 'tb_jemb.no_jemb', '=', 'tb_kemantapan_jemb.no_jemb')
                        ->select('tb_jemb.*', 
                            'tb_kemantapan_jemb.panjang_meter',
                            'tb_kemantapan_jemb.lebar_meter',
                            'tb_kemantapan_jemb.tipe_lantai',
                            'tb_kemantapan_jemb.kondisi_jemb'
                            );
        $data = $dataJembatan->where('nama_jemb', 'LIKE', "%{$query}%")
                ->orWhere('nama_ruas_jemb', 'LIKE', "%{$query}%")
                ->get();

        return response()->json($data);
    }

    public function list()
    {
        $data = Jembatan::all();
        $final = $data->map(function ($item) {

                $segments = preg_split('/\s+/', trim($item->jemb_geom));

                $coords = [];
                foreach ($segments as $seg) {
                    if (str_contains($seg, ',')) {
                        [$lat, $lng] = explode(',', $seg);
                        $coords[] = [(float)$lat, (float)$lng];
                    }
                }

                return [
                    'no_jemb' => $item->no_jemb,
                    'nama_jemb' => $item->nama_jemb,
                    'nama_ruas_jemb' => $item->nama_ruas_jemb,
                    'id_ruasjln' => $item->id_ruasjln,
                    'coords' => $item->jemb_geom
                ];
            });
        return response()->json($final);
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
    public function show(string $id)
    {
        //
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
