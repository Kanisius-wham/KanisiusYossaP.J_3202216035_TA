<!DOCTYPE html>
<html>
<head>
    <title>Login Admin/Pemilik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="w-full max-w-sm">
    <form method="POST" action="{{ route('login.custom') }}" class="bg-white p-6 rounded shadow-md">
            @csrf
            <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>
            @if(session('error'))
                <div class="mb-3 text-red-500">{{ session('error') }}</div>
            @endif

            <div class="mb-3">
                <label for="username" class="block mb-1">Username</label>
                <input type="text" name="username" id="username" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label for="password" class="block mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label for="role" class="block mb-1">Login Sebagai</label>
                <select name="role" id="role" class="w-full border rounded p-2" required>
                    <option value="admin">Admin</option>
                    <option value="pemilik">Pemilik</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-800 text-white w-full py-2 rounded hover:bg-gray-700">Login</button>
        </form>
        <!-- Tombol kembali di bawah card -->
        <div class="mt-4 text-center">
            <a href="{{ url('/') }}"
               class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</body>

</html>
