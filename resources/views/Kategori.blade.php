@extends('layouts.app')

@section('content')
{{-- Inject stok alat ke window JS --}}
<script>
    window.stokAlatFromBlade = @json($alats->pluck('stok', 'id_alat'));
</script>


<div x-data="cartSidebar()" x-init="init()" class="relative pt-4 min-h-screen">

@if(session('msg'))
  <div class="bg-green-200 text-green-800 p-2 rounded mb-3">
    {{ session('msg') }}
  </div>
@endif

@if(session('msg'))
    <script>
        localStorage.removeItem('cart');
        localStorage.removeItem('durasi');
    </script>
@endif



    {{-- BAR KATEGORI --}}
    <div class="flex gap-2 overflow-x-auto px-4 pb-3 pt-2"> 
    <a href="{{ url('/kategori') }}"
       class="inline-block px-4 py-2 rounded-full whitespace-nowrap font-semibold transition-all duration-200
            {{ is_null($activeKategori) ? 'bg-blue-600 text-white scale-105 shadow-lg ring-2 ring-blue-400' : 'bg-gray-200 text-gray-800 hover:bg-blue-500 hover:text-white' }}">
        Semua
    </a>
    @foreach ($kategoris as $kategori)
        <a href="{{ url('/kategori/' . $kategori->id_kategori) }}"
           class="inline-block px-4 py-2 rounded-full whitespace-nowrap font-semibold transition-all duration-200
                {{ $activeKategori == $kategori->id_kategori 
                    ? 'bg-blue-600 text-white scale-105 shadow-lg ring-2 ring-blue-400' 
                    : 'bg-gray-200 text-gray-800 hover:bg-blue-500 hover:text-white' }}">
            {{ $kategori->nama_kategori }}
        </a>
    @endforeach
</div>




    {{-- NOTIFIKASI --}}
        <template x-if="notif">
        <div class="fixed bottom-24 right-6 bg-blue-600 text-white px-4 py-2 rounded shadow-2xl z-50 animate-bounce ring-2 ring-blue-300 scale-105 transition">
    <span x-text="notif"></span>
</div>

    </template>

    {{-- MODAL FORM SEWA --}}
    <template x-if="showModal">
        <div class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xs">
                <div class="mb-2 font-bold text-lg text-center" x-text="alatAktif?.nama_alat"></div>
                <img :src="'/storage/alats/' + (alatAktif?.foto || '')" class="h-20 mx-auto mb-2 rounded shadow">
                <div class="mb-2 text-blue-700 font-semibold" x-text="'Rp' + (alatAktif?.harga_sewa_per_hari?.toLocaleString('id-ID') || 0) + ' /hari'"></div>
                <div class="mb-2">Stok tersedia: <span x-text="stokAlat[alatAktif?.id_alat] ?? 0"></span></div>
                <div class="mb-3">
                    <label>Jumlah unit:</label>
                    <input type="number" x-model="jumlah" min="1" :max="stokAlat[alatAktif?.id_alat] || 1"
                        class="border rounded px-2 py-1 w-20 ml-2" required>
                </div>
                <div class="flex gap-2 mt-4">
                    <button
                        @click="
                            if(jumlah > 0 && jumlah <= (stokAlat[alatAktif.id_alat] || 0)) {
                                add({
                                    id_alat: parseInt(alatAktif.id_alat),
                                    nama_alat: alatAktif.nama_alat,
                                    harga: alatAktif.harga_sewa_per_hari,
                                    foto: alatAktif.foto,
                                    jumlah: jumlah,
                                });
                                showModal = false;
                                jumlah = 1;
                            }
                        "
                        :class="(stokAlat[alatAktif?.id_alat] ?? 0) < 1 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-700 hover:bg-blue-800'"
                        :disabled="(stokAlat[alatAktif?.id_alat] ?? 0) < 1"
                        class="flex-1 text-white rounded px-4 py-2 font-bold"
                    >Oke</button>
                    <button @click="showModal=false;jumlah=1" class="flex-1 bg-gray-300 text-gray-700 rounded px-4 py-2">Batal</button>
                </div>
            </div>
        </div>
    </template>

    {{-- SIDEBAR KERANJANG --}}
    <div
        class="fixed top-0 right-0 h-full w-80 max-w-full bg-white border-l shadow-xl z-50 flex flex-col"
        :class="{ 'translate-x-0': open, 'translate-x-full': !open }"
        style="will-change: transform;"
    >
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="font-bold text-lg">Keranjang</h3>
            <button @click="open = false" class="text-gray-600 text-2xl font-bold">&times;</button>
        </div>
        <div class="flex-1 p-4 overflow-y-auto" style="max-height:68vh;">
            <template x-if="cart.length === 0">
                <div class="text-gray-400 text-center my-8">Keranjang kosong</div>
            </template>
            <template x-for="(item, i) in cart" :key="item.id_alat">
                <div class="flex gap-2 items-center mb-4 border-b pb-2">
                    <img :src="'/storage/alats/' + item.foto" class="h-12 w-12 object-cover rounded" />
                    <div class="flex-1">
                        <div class="font-bold truncate" x-text="item.nama_alat"></div>
                        <div class="text-xs text-gray-500">Jumlah:
                            <input type="number" min="1"
                                class="w-14 border rounded px-1 text-sm"
                                x-model.number="item.jumlah"
                                @input="syncStokAlat(); updateTotal()"
                                :max="getStokAvailable(item.id_alat, i)"
                            />
                        </div>
                        <div class="text-xs text-blue-700 font-semibold mt-1">
                            Total: Rp<span x-text="(item.jumlah * item.harga * (durasi || 1)).toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                    <button @click="remove(i)" class="text-red-600 text-lg font-bold ml-2">&times;</button>
                </div>
            </template>
        </div>
        <div class="p-4 border-t bg-white sticky bottom-0 z-10">
            <div class="flex items-center mb-2">
                <label class="font-semibold flex-shrink-0">Durasi sewa:</label>
                <input type="number" min="1" class="w-16 border ml-2 rounded px-1 text-sm" x-model.number="durasi" @input="updateTotal()" />
                <span class="ml-1 text-sm">hari</span>
            </div>
            <div class="mb-2 text-right font-bold text-lg">
                Grand Total:
                <span class="text-blue-700">Rp<span x-text="grandTotal.toLocaleString('id-ID')"></span></span>
            </div>
            {{-- Tombol Lanjutkan Checkout --}}
            <form id="cartToCheckout" action="{{ route('checkout.saveCart') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="cart" id="cartInput">
    <input type="hidden" name="durasi" id="durasiInput">
</form>

<button
    class="w-full bg-blue-700 text-white rounded py-2 font-bold hover:bg-blue-800"
    :disabled="cart.length === 0"
    @click.prevent="
        document.getElementById('cartInput').value = JSON.stringify(cart);
        document.getElementById('durasiInput').value = durasi;
        document.getElementById('cartToCheckout').submit();
    ">
    Lanjutkan
</button>




        </div>
    </div>

    {{-- TOMBOL BUKA KERANJANG --}}
    <button
    x-show="!open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:leave="transition ease-in duration-200"
    @click="open = true"
    class="fixed bottom-6 right-6 z-50 bg-blue-700 text-white rounded-full shadow-lg w-14 h-14 flex items-center justify-center text-2xl font-bold focus:outline-none"
>
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h14l-1.35 6.35A2 2 0 0117.7 21H6.3a2 2 0 01-1.95-1.65L3 7H21"/>
        </svg>
    </button>

    {{-- GRID ALAT --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
        @forelse($alats as $alat)
        @php $alat_id = (int) $alat->id_alat; @endphp
        <div class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-xl hover:scale-105 transition-transform duration-200 flex flex-col p-4 group">
            <div class="h-40 flex items-center justify-center mb-3">
                <img src="{{ asset('storage/alats/' . $alat->foto) }}"
                     alt="{{ $alat->nama_alat }}"
                     class="max-h-full object-contain rounded-lg shadow group-hover:shadow-lg transition"
                     onerror="this.onerror=null;this.src='{{ asset('images/placeholder.png') }}';">
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-1 truncate">{{ $alat->nama_alat }}</h3>
            <div class="text-blue-700 font-bold mb-1">
                Rp{{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }} <span class="text-xs text-gray-500 font-normal">/hari</span>
            </div>
            <div class="text-sm mb-1"
                :class="(stokAlat && ({{ $alat_id }} in stokAlat) && stokAlat[{{ $alat_id }}] > 0) ? 'text-gray-500' : 'text-red-600'">
                Stok:
                <span class="font-semibold"
                      x-text="(stokAlat && ({{ $alat_id }} in stokAlat))
                        ? (stokAlat[{{ $alat_id }}] > 0
                            ? stokAlat[{{ $alat_id }}]
                            : 'habis ;)' )
                        : '{{ $alat->stok > 0 ? $alat->stok : 'habis ;)' }}'">
                    {{ $alat->stok > 0 ? $alat->stok : 'habis ;)' }}
                </span>
            </div>
            <p class="text-xs text-gray-600 mb-2 line-clamp-3">{{ $alat->deskripsi }}</p>
            <div class="mt-auto flex flex-col gap-1">
                <template x-if="stokAlat && ({{ $alat_id }} in stokAlat) && stokAlat[{{ $alat_id }}] > 0">
                    <button
                        @click="alatAktif = {
                                id_alat: {{ $alat_id }},
                                nama_alat: `{{ $alat->nama_alat }}`,
                                harga_sewa_per_hari: {{ $alat->harga_sewa_per_hari }},
                                foto: '{{ $alat->foto }}',
                                stok: stokAlat[{{ $alat_id }}]
                            };
                            showModal = true;
                            jumlah = 1;"
                        class="block w-full bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded transition font-semibold shadow"
                    >Sewa</button>
                </template>
                <template x-if="!stokAlat || !({{ $alat_id }} in stokAlat) || stokAlat[{{ $alat_id }}] <= 0">
                    <button class="block w-full bg-red-600 text-white px-4 py-2 rounded font-semibold shadow opacity-80 cursor-not-allowed" disabled>
                        Stok Habis
                    </button>
                </template>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-400 py-12">
            Belum ada alat pada kategori ini.
        </div>
        @endforelse
    </div>
</div>
@endsection
