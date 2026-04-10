<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Parkirin</title>
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center px-6 py-8 relative overflow-hidden" style="background: linear-gradient(90deg, rgb(247, 249, 252) 0%, rgb(247, 249, 252) 100%)">
    @php
        $notifications = [];

        foreach (['success', 'error', 'warning', 'info'] as $type) {
            $message = session($type);

            if (is_string($message) && $message !== '') {
                $notifications[] = [
                    'type' => $type,
                    'message' => $message,
                ];
            }
        }

        if ($errors->any()) {
            foreach (array_unique($errors->all()) as $errorMessage) {
                $notifications[] = [
                    'type' => 'error',
                    'message' => $errorMessage,
                ];
            }
        }

        $notifications = collect($notifications)
            ->unique(fn (array $notification): string => $notification['type'].'|'.$notification['message'])
            ->values()
            ->all();
    @endphp

    <div id="notification-box" class="pointer-events-none fixed inset-x-0 top-4 z-50 flex flex-col items-center gap-2 px-3"></div>

    <!-- Decorative Background Elements -->
    <div class="absolute -top-32 -left-24 w-96 h-96 bg-[rgba(0,88,190,0.05)] rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -right-24 w-96 h-96 bg-[rgba(213,224,248,0.2)] rounded-full blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Brand Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl shadow-[0px_10px_15px_-3px_rgba(0,88,190,0.2)] mb-4">
                <img src="/storage/parkirin_logo_transparent.svg" alt="Parkirin" class="w-full h-full object-contain">
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Parkirin</h1>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.06)] border border-[rgba(194,198,214,0.15)] p-12 space-y-8">
            <!-- Header -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Selamat Datang</h2>
                <p class="text-gray-600 text-sm leading-relaxed">Silakan masukkan kredensial administrator Anda untuk mengakses panel manajemen parkir.</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Username</label>
                    <div class="relative">
                        <iconify-icon icon="mdi:account" class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" style="font-size: 1.25rem;" inline></iconify-icon>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Username"
                            class="w-full pl-12 pr-4 py-3 rounded-xl bg-[#e6e8eb] border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#0058be] transition-all"
                            required
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <iconify-icon icon="mdi:lock" class="absolute left-4 top-3.5 text-gray-400" style="font-size: 1.25rem;" inline></iconify-icon>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Password"
                            class="w-full pl-12 pr-12 py-3 rounded-xl bg-[#e6e8eb] border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#0058be] transition-all"
                            required
                        >
                        <button type="button" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 transition-colors" onclick="togglePasswordVisibility()" aria-label="Tampilkan atau sembunyikan password">
                            <iconify-icon id="passwordToggleIcon" icon="mdi:eye-off" style="font-size: 1.25rem;" inline></iconify-icon>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-3.5 bg-linear-to-r from-[#0058be] to-[#2170e4] text-white font-bold rounded-xl hover:shadow-[0px_10px_15px_-3px_rgba(0,88,190,0.2)] transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2 shadow-[0px_10px_15px_-3px_rgba(0,88,190,0.2)]"
                >
                    <span>Masuk</span>
                    <iconify-icon icon="mdi:arrow-right" style="font-size: 1.25rem;" inline></iconify-icon>
                </button>
            </form>

            <!-- Footer -->
            <div class="border-t border-[rgba(194,198,214,0.1)] pt-6">
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Parkirin - UKK RPL NESKAR 2026
                    </p>
                </div>
            </div>
        </div>

    </div>

    <script>
        (function () {
            const notificationBox = document.getElementById('notification-box');

            if (!notificationBox) {
                return;
            }

            const initialNotifications = @json($notifications);

            const variants = {
                info: {
                    classes: 'bg-[#0058be] border-[#1d4ed8] text-white',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                },
                error: {
                    classes: 'bg-[#dc2626] border-[#ef4444] text-white',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                },
                warning: {
                    classes: 'bg-[#f59e0b] border-[#fbbf24] text-[#1f2937]',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                },
                success: {
                    classes: 'bg-[#059669] border-[#10b981] text-white',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                },
            };

            function escapeHtml(text) {
                return text
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }

            function sendNotification(type, message) {
                const variant = variants[type] ?? variants.info;
                const component = document.createElement('div');

                component.className = `pointer-events-auto flex w-full max-w-md items-start gap-3 rounded-xl border px-4 py-3 text-sm font-semibold shadow-[0px_14px_30px_rgba(15,23,42,0.18)] opacity-0 translate-y-2 transition-all duration-300 ${variant.classes}`;
                component.innerHTML = `${variant.icon}<p class="leading-relaxed">${escapeHtml(message)}</p>`;
                notificationBox.appendChild(component);

                requestAnimationFrame(() => {
                    component.classList.remove('opacity-0', 'translate-y-2');
                });

                setTimeout(() => {
                    component.classList.add('opacity-0', '-translate-y-2');
                    component.addEventListener('transitionend', () => component.remove(), { once: true });
                }, 4500);
            }

            window.sendNotification = sendNotification;

            initialNotifications.forEach(({ type, message }) => {
                if (typeof message === 'string' && message.trim() !== '') {
                    sendNotification(type, message);
                }
            });
        })();

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordToggleIcon = document.getElementById('passwordToggleIcon');

            if (!passwordInput || !passwordToggleIcon) {
                return;
            }

            const isPasswordHidden = passwordInput.type === 'password';
            passwordInput.type = isPasswordHidden ? 'text' : 'password';
            passwordToggleIcon.setAttribute('icon', isPasswordHidden ? 'mdi:eye' : 'mdi:eye-off');
        }
    </script>
</body>
</html>

