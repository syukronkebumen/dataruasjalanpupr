<?php

namespace App\Http\Controllers;

use App\Models\Kemantapan;
use App\Models\KetMantap;
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

                $segments = preg_split('/\s+/', trim($item->ruas_geom));

                $coords = [];
                foreach ($segments as $seg) {
                    if (str_contains($seg, ',')) {
                        [$lat, $lng] = explode(',', $seg);
                        $coords[] = [(float)$lat, (float)$lng];
                    }
                }

                return [
                    // 'name' => $item->name,
                    // 'panjang' => $item->panjang,
                    // 'fungsi' => $item->fungsi,
                    // 'kecamatan' => $item->kecamatan,
                    // 'wilayah' => $item->wilayah,
                    // 'no_ruas' => $item->no_ruas,
                    // 'jumlah_titik' => $item->jumlah_titik,    
                    // 'coords' => $coords,

                    'id_ruasjln' => $item->id_ruasjln,
                    'nama_ruasjln' => $item->nama_ruasjln,
                    'panjang_jln' => $item->panjang_jln,
                    'id_fungsijln' => $item->id_fungsijln,
                    'kec_jalan' => $item->kec_jalan,
                    'wilayah' => $item->wilayah,
                    'no_ruasjln' => $item->no_ruasjln,
                    'jumlah_titik' => $item->jumlah_titik,
                    'coords' => $coords
                ];
            });
            
            return response()->json($final);
        
    }

    public function ruasDetail($id)
    {
        $item = RuasJalan::where('id_ruasjln', $id)->first();

        if (!$item) {
            return response()->json(['error' => 'Ruas Jalan not found'], 404);
        }
        $segments = preg_split('/\s+/', trim($item->ruas_geom));

        $result = [
            'id_ruasjln' => $item->id_ruasjln,
            'nama_ruasjln' => $item->nama_ruasjln,
            'panjang_jln' => $item->panjang_jln,
            'id_fungsijln' => $item->id_fungsijln,
            'kec_jalan' => $item->kec_jalan,
            'wilayah' => $item->wilayah,
            'no_ruasjln' => $item->no_ruasjln,
            'jumlah_titik' => $item->jumlah_titik,
            'coords' => $segments
        ];
        return response()->json($result);
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
        $datas = RuasJalan::orderBy('no_ruasjln', 'ASC')->paginate(20);
        $totalPanjang = RuasJalan::sum('panjang_jln');
        $panjangJalanKM = $totalPanjang / 1000;
        $countRuasJalan = RuasJalan::count();

        $kemantapan = Kemantapan::get();
        $getKemantapan = KetMantap::where('jenis_mantap', "Kemantapan Jalan")->first();
        $indeksKemantapan = $getKemantapan->mantap_persen;
        $totalPanjangFull = $getKemantapan->panjang_full;

        $totalJalanBaik = $kemantapan->sum('baik_km') + $kemantapan->sum('sedang_km');
        return view('contentlanding', compact(
            'datas',
            'countRuasJalan',
            'kemantapan', 
            'indeksKemantapan',
            'totalJalanBaik',
            'totalPanjangFull'
        ));
    }

    public function detail($id)
    {
        $data = RuasJalan::where('id_ruasjln', $id)->first();
        return view('detail.index', compact('data'));
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
