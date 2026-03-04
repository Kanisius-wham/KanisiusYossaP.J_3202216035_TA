@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <p>Selamat datang, {{ session('username') }} ({{ session('role') }})</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded mt-4">Logout</button>
    </form>
    <!-- Fitur umum di sini -->

    <!-- Fitur khusus untuk pemilik -->
    @if(session('role') == 'pemilik')
        <div class="mt-4">
            <a href="/fitur-khusus-pemilik" class="bg-blue-500 text-white px-4 py-2 rounded">Fitur Khusus Pemilik</a>
        </div>
    @endif
@endsection
