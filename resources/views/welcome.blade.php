<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkirin</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f7f9fc] text-[#191c1e]">
    <main class="mx-auto flex min-h-screen max-w-2xl items-center justify-center px-6 py-12">
        <section class="w-full rounded-2xl border border-[rgba(194,198,214,0.2)] bg-white p-10 text-center shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
            <h1 class="text-3xl font-black tracking-tight text-gray-900">Parkirin</h1>
            <p class="mt-3 text-sm text-[#64748b]">Sistem manajemen parkir untuk operasional harian.</p>
            <a href="{{ route('login') }}" class="mt-8 inline-flex items-center rounded-xl bg-linear-to-r from-[#0058be] to-[#2170e4] px-6 py-3 text-sm font-semibold text-white transition-all hover:shadow-[0px_10px_15px_-3px_rgba(0,88,190,0.2)]">
                Masuk ke Sistem
            </a>
        </section>
    </main>
</body>
</html>