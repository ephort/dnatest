<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <a href="/">
                        <img src="{{ asset('logo.png') }}" style="width: 200px" alt="DNA Test">
                    </a>
                </div>

                <div class="mt-16">
                    <!-- center content -->
                    <div class="flex flex-col items-center justify-center">
                        @if(session()->has('success'))
                            <div data-test="success" class="bg-green-500 text-white p-4 rounded-lg mb-6">
                                {!! session()->get('success') !!}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div data-test="error" class="bg-red-500 text-white p-4 rounded-lg mb-6">
                                {!! session()->get('error') !!}
                            </div>
                        @endif

                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Get your result now</h2>
                                <h3>Enter your phone number and password to unlock your result.</h3>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Your test result is only available to you. We will never share your data with anyone.
                                </p>

                                <form action="{{ action([\App\Http\Controllers\ResultController::class, 'store']) }}" method="post">
                                    @csrf
                                    <div class="mt-6">
                                        <div class="flex flex-col gap-2">
                                            <label for="name" class="text-sm text-gray-600 dark:text-gray-400">Phone</label>
                                            <input type="text" name="phone" id="phone" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline focus:outline-2 focus:outline-red-500" placeholder="+45 30959993" required>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <div class="flex flex-col gap-2">
                                            <label for="name" class="text-sm text-gray-600 dark:text-gray-400">Your password</label>
                                            <input type="password" name="password" id="password" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline focus:outline-2 focus:outline-red-500" placeholder="" required>
                                        </div>
                                    </div>

                                    <!-- submit -->
                                    <div class="mt-6">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg focus:outline focus:outline-2 focus:outline-red-500">Reveal result »</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                        <div class="flex items-center gap-4">
                            <a href="/" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>

                                Your data is safe with us
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        DNA Test ApS &copy; {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
