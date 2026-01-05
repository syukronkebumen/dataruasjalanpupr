<?php

namespace App\Http\Controllers;

use App\Models\Jembatan;
use Illuminate\Http\Request;

class JembatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jembatan.index');
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
