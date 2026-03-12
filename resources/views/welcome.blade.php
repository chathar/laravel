<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smart Invoice & Client Management System</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 selection:bg-blue-500 selection:text-white">
        <div class="relative min-h-screen flex flex-col justify-center overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute inset-0 bg-[url('https://play.tailwindcss.com/img/grid.svg')] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
            <div class="absolute inset-auto left-1/2 top-0 h-[300px] w-[800px] -translate-x-1/2 bg-blue-400 opacity-20 blur-[100px]"></div>

            <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex flex-col items-center text-center">
                <!-- Header / Logo Area -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-800">Smart<span class="text-blue-600">Invoice</span></span>
                </div>

                <!-- Hero Section -->
                <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight mb-6">
                    Professional Invoicing <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                        Made Simple.
                    </span>
                </h1>
                
                <p class="max-w-2xl text-lg text-slate-600 mb-10 leading-relaxed">
                    Elevate your business with our production-ready Smart Invoice & Client Management System. Track payments, manage clients, and generate professional PDFs seamlessly.
                </p>

                <!-- Action Buttons -->
                @if (Route::has('login'))
                    <div class="flex flex-col sm:flex-row gap-4 items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-blue-600 text-white font-semibold rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all transform hover:-translate-y-1">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-semibold rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all transform hover:-translate-y-1">
                                Sign In to Your Account
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 text-slate-700 font-semibold rounded-2xl hover:bg-slate-50 transition-all">
                                    Create New Account
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <!-- Demo Credentials Alert (Only for Dev) -->
                <div class="mt-12 p-6 bg-white/80 backdrop-blur border border-blue-100 rounded-3xl shadow-sm text-center max-w-md mx-auto">
                    <p class="text-sm font-medium text-slate-500 mb-2 font-mono uppercase tracking-wider">Quick Access Demo</p>
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div class="p-3 bg-blue-50 rounded-xl">
                            <span class="block text-xs font-bold text-blue-600 mb-1">Administrator</span>
                            <span class="text-sm font-mono text-slate-700 truncate">admin@example.com</span>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-xl">
                            <span class="block text-xs font-bold text-indigo-600 mb-1">Password</span>
                            <span class="text-sm font-mono text-slate-700">password</span>
                        </div>
                    </div>
                </div>

                <!-- Features Grid -->
                <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
                    <div class="p-8 bg-white rounded-3xl border border-slate-100 shadow-sm text-left">
                        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">PDF Invoices</h3>
                        <p class="text-slate-500 text-sm">Generate professional, branded PDF invoices with a single click using DomPDF.</p>
                    </div>
                    <div class="p-8 bg-white rounded-3xl border border-slate-100 shadow-sm text-left">
                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 012 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Automated Mail</h3>
                        <p class="text-slate-500 text-sm">Send invoices directly to your clients' inbox with automated tracking and notifications.</p>
                    </div>
                    <div class="p-8 bg-white rounded-3xl border border-slate-100 shadow-sm text-left">
                        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">RBAC Control</h3>
                        <p class="text-slate-500 text-sm">Enterprise-grade Role-Based Access Control to manage your team and security.</p>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="mt-20 py-8 border-t border-slate-100 w-full text-slate-400 text-sm">
                    &copy; {{ date('Y') }} Smart Invoice & Client Management. A portfolio-grade Laravel application.
                </footer>
            </div>
        </div>
    </body>
</html>
