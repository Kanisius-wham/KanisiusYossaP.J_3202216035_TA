@extends('layouts.app')

@section('content')

{{-- INTRODUCTION --}}
<div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-8 py-10 mb-4">
    <div class="w-full md:w-1/2 flex justify-center">
        <img src="{{ asset('images/logosenentang.png') }}"
            alt="Introduction Image"
            class="rounded shadow-lg w-80 h-80 object-contain bg-gray-200" />
    </div>
    <div class="w-full md:w-1/2 mt-8 md:mt-0">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Selamat Datang di Senentang Outdoor</h1>
        <p class="text-lg text-gray-700">
            Senentang Outdoor adalah platform penyewaan alat outdoor terlengkap di wilayah Pontianak dan sekitarnya. Kami menyediakan berbagai kebutuhan kegiatan alam mulai dari tenda, carrier, hingga perlengkapan pendakian dengan sistem pemesanan online yang mudah dan transparan.
        </p>
        <p class="mt-3 text-gray-600">
            Dengan stok terupdate, layanan pembayaran digital, serta galeri momen dan rekomendasi destinasi wisata, kami hadir untuk mendukung pengalaman petualangan terbaik Anda!
        </p>
    </div>
</div>

{{-- SLIDE 1: PRODUK/ALAT --}}
<div class="max-w-6xl mx-auto mt-12">
    <h2 class="text-xl font-bold mb-2 ml-2">Produk & Alat Outdoor</h2>
    <div class="relative">
        <div class="swiper mySwiper mb-14">
            <div class="swiper-wrapper">
                @foreach($alats as $alat)
                <div class="swiper-slide">
                    <div class="relative w-64 h-64">
                        <img src="{{ asset('storage/alats/' . $alat->foto) }}"
                            class="w-full h-full rounded shadow object-cover" alt="{{ $alat->nama_alat }}" />
                        <div class="absolute bottom-0 left-0 w-full bg-black/70 text-white text-center py-2 font-bold text-lg rounded-b">
                            {{ $alat->nama_alat }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination !static mt-6"></div>
        </div>
    </div>
</div>

{{-- SLIDE 2: GALERI PENDAKIAN --}}
<div class="max-w-6xl mx-auto mt-12">
    <h2 class="text-xl font-bold mb-2 ml-2">Galeri Pendakian</h2>
    <div class="relative">
        <div class="swiper mySwiperPendakian mb-14">
            <div class="swiper-wrapper">
                @foreach($pendakian as $item)
                <div class="swiper-slide">
                    <div class="relative w-64 h-64">
                        <img src="{{ asset('storage/galeri_pendakian/' . $item->gambar) }}"
                            class="w-full h-full rounded shadow object-cover" alt="{{ $item->nama }}">
                        <div class="absolute bottom-0 left-0 w-full bg-black/70 text-white text-center py-2 font-bold text-lg rounded-b">
                            {{ $item->nama }}
                        </div>
                    </div>
                    @if($item->deskripsi)
                    <div class="mt-2 text-center text-sm text-gray-700">{{ $item->deskripsi }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination !static mt-6"></div>
        </div>
    </div>
</div>

{{-- SLIDE 3: REKOMENDASI WISATA --}}
<div class="max-w-6xl mx-auto mt-12">
    <h2 class="text-xl font-bold mb-2 ml-2">Rekomendasi Tempat Wisata</h2>
    <div class="relative">
        <div class="swiper mySwiperWisata mb-14">
            <div class="swiper-wrapper">
                @foreach($wisata as $item)
                <div class="swiper-slide">
                    <div class="relative w-64 h-64">
                        <img src="{{ asset('storage/rekomendasi_wisata/' . $item->gambar) }}"
                            class="w-full h-full rounded shadow object-cover" alt="{{ $item->nama_tempat }}">
                        <div class="absolute bottom-0 left-0 w-full bg-black/70 text-white text-center py-2 font-bold text-lg rounded-b">
                            {{ $item->nama_tempat }}
                        </div>
                    </div>
                    @if($item->link_sosmed)
                    <div class="mt-1">
                        <a href="{{ $item->link_sosmed }}" target="_blank" class="text-blue-600 underline">Lihat Sosmed</a>
                    </div>
                    @endif
                    @if($item->deskripsi)
                    <div class="mt-2 text-center text-sm text-gray-700">{{ $item->deskripsi }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination !static mt-6"></div>
        </div>
    </div>
</div>

{{-- FOOTER --}}
<footer class="w-full bg-gray-900 text-gray-200 mt-20 py-8">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center px-4">
        <div class="mb-4 md:mb-0 flex items-center">
            <a href="https://maps.app.goo.gl/umUJQdg5jBff478k8?g_st=iwb" target="_blank" class="text-green-400 hover:text-green-600 mr-2">
                <i class="fa-solid fa-location-dot fa-lg"></i>
            </a>
            <span>Jl. Lingkar tugu jam, Kec. Sintang, Kabupaten Sintang, Kalimantan Barat,Indonesia</span>
        </div>
        <div class="flex space-x-4">
            <a href="https://www.instagram.com/senentang_outdoor/?igsh=M3A1MHpueWZ2YmR4#" target="_blank" class="hover:text-white">
                <i class="fa-brands fa-instagram fa-lg"></i>
            </a>
            <a href="https://wa.me/6281649401049" target="_blank" class="hover:text-white">
                <i class="fa-brands fa-whatsapp fa-lg"></i>
            </a>
        </div>
    </div>
    <div class="text-center text-xs text-gray-400 mt-4">
        &copy; {{ date('Y') }} Senentang Outdoor. All rights reserved.
    </div>
</footer>



{{-- Tambahan CSS agar Swiper rapi --}}
<style>
.swiper {
    width: 100%;
    position: relative;
}
.swiper-slide {
    height: 300px !important;
    display: flex !important;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.swiper-button-next,
.swiper-button-prev {
    z-index: 20 !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    color: #2563eb;
}
</style>
@endsection
