<nav class="bg-emerald-600 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}"
                   class="text-white font-bold text-xl">
                    🏥 Klinik Kampus
                </a>
            </div>

            <!-- Menu -->
            <div class="flex items-center gap-6">

                <a href="{{ route('dashboard') }}"
                   class="text-white hover:text-emerald-100 font-medium">
                    Dashboard
                </a>

                <a href="{{ route('kunjunganpasien.index') }}"
                   class="text-white hover:text-emerald-100 font-medium">
                    Data Pasien
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="text-white hover:text-emerald-100 font-medium">
                    Profile
                </a>

                <div class="text-white text-sm border-l border-emerald-400 pl-4">
                    {{ Auth::user()->name }}
                    ({{ Auth::user()->role }})
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="bg-white text-emerald-700 px-4 py-2 rounded-lg font-semibold hover:bg-emerald-50 transition">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</nav>
```
