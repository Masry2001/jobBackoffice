<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class=" py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    {{ __("Account Settings") }}
                </h2>
                <p class="text-gray-600">
                    {{ __("Manage your profile and account preferences") }}
                </p>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

                <!-- Profile Section -->
                <div class="p-8 border-b border-gray-100">
                    <div class="flex items-center space-x-4 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ Auth::user()->name ?? __('User') }}
                            </h3>
                            <p class="text-gray-500 text-sm">
                                {{ Auth::user()->email ?? '' }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                        class="group relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 ease-in-out shadow-lg hover:shadow-xl w-full sm:w-auto">
                        <span class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ __("Edit Profile") }}</span>
                        </span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="p-8 bg-gray-50">
                    <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">
                        {{ __("Quick Actions") }}
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <!-- Security Card -->
                        <div
                            class="bg-white p-4 rounded-xl border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-900">{{ __("Security") }}</h5>
                                    <p class="text-xs text-gray-500">{{ __("Password & 2FA") }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Preferences Card -->
                        <div
                            class="bg-white p-4 rounded-xl border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-900">{{ __("Preferences") }}</h5>
                                    <p class="text-xs text-gray-500">{{ __("Notifications & Theme") }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="group relative inline-flex items-center justify-center px-6 py-3 bg-white text-red-600 font-medium rounded-xl border-2 border-red-200 hover:bg-red-50 hover:border-red-300 transform hover:scale-105 transition-all duration-200 ease-in-out shadow-sm hover:shadow-md w-full sm:w-auto">
                            <span class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>{{ __("Log Out") }}</span>
                            </span>
                        </button>
                    </form>
                </div>

            </div>

            <!-- Footer Info -->
            <div class="mt-6 text-center text-sm text-gray-500">
                Need help? <a href="mailto:me5127538@gmail.com"
                    class="font-semibold text-indigo-600 hover:text-indigo-500">Contact</a>
                our support team
            </div>
        </div>
    </div>
</x-app-layout>