<div class="bg-surface border border-border-light rounded-xl overflow-hidden flex flex-col shadow-card">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50/80 border-b border-border-light text-text-muted text-xs uppercase tracking-wider font-semibold">
            <th class="p-4 whitespace-nowrap">Aksi</th>
            <th class="p-4 whitespace-nowrap">Nama</th>
            <th class="p-4 whitespace-nowrap">Panjang (m)</th>
            <th class="p-4 whitespace-nowrap">Fungsi</th>
            <th class="p-4 whitespace-nowrap">Kecamatan</th>
            <th class="p-4 whitespace-nowrap">Wilayah</th>
            <th class="p-4 whitespace-nowrap">No Ruas</th>
            <th class="p-4 whitespace-nowrap">Jumlah Titik</th>
            </tr>
        </thead>
        <tbody id="ruasjalanTable" class="text-text-main text-sm divide-y divide-border-light">
            @foreach($datas as $item)

            <tr class="hover:bg-primary-light/30 transition-colors group cursor-pointer">
            <td class="p-4">
                <a href="/detail/{{ $item->id_ruasjln }}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors text-sm font-medium border border-blue-200">
                <span class="material-symbols-outlined text-[18px]">visibility</span>
                Detail
                </a>
            </td>
            <td class="p-4 font-semibold text-text-main">{{ $item['nama_ruasjln'] }}</td>
            <td class="p-4 text-text-muted">{{ $item['panjang_jln'] }}</td>
            <td class="p-4 font-medium">{{ $item['id_fungsijln'] }}</td>
            <td class="p-4">{{ $item['kec_jalan'] }}</td>
            <td class="p-4">
                <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-600 border border-green-100 text-xs font-semibold">{{ $item['wilayah'] }}</span>
            </td>
            <td class="p-4 font-mono">{{ $item['no_ruasjln'] }}</td>
            <td class="p-4 text-center">{{ $item['jumlah_titik'] }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        <div class="mt-4">
            {!! $datas->links() !!}
        </div>
    </div>
</div>