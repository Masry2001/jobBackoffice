<!-- navigation.blade.php -->
<nav
    class="fixed left-0 top-0 w-[250px] h-screen bg-white border-r {{ auth()->user()->role == 'Admin' ? 'border-gray-300' : 'border-gray-200' }} overflow-y-auto z-50">
    <!-- Primary Navigation Menu -->
    <div
        class="flex items-center px-6 border-b {{ auth()->user()->role == 'Admin' ? 'border-gray-300' : 'border-gray-200' }} py-[18.5px]">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo
                class="h-9 w-auto fill-current {{ auth()->user()->role == 'Admin' ? 'text-gray-700' : 'text-gray-800' }}" />
            <span
                class="text-lg font-semibold {{ auth()->user()->role == 'Admin' ? 'text-gray-700' : 'text-gray-800' }}">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col space-y-2 px-2 py-4 bg-white">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            🏠 Dashboard
        </x-nav-link>
        @if (auth()->user()->role == 'Admin')

            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                🏢 Companies
            </x-nav-link>
        @endif
        @if (auth()->user()->role == 'Company-Owner')
            <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')">
                🏢 My Company
            </x-nav-link>
        @endif


        <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.*')">
            💼 Job Vacancies
        </x-nav-link>

        <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')">
            🔍 Job Applications
        </x-nav-link>

        @if (auth()->user()->role == 'Admin')

            <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.*')">
                🗂️ Job Categories
            </x-nav-link>

            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                👥 Users
            </x-nav-link>
        @endif

        <x-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
            ⚙️ Settings
        </x-nav-link>
    </ul>
</nav>