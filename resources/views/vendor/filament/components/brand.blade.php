@if (filament()->getId() === 'opd')
    <!-- Custom brand untuk panel OPD -->
    <div class="flex items-center gap-3">
        <img 
            src="{{ asset('images/logo.jpg') }}" 
            alt="Logo OPD" 
            class="h-10 w-10" 
        />
        <div class="flex flex-col">
            <div class="text-lg font-bold leading-tight text-gray-900 dark:text-white">
                Sistem Pengadaan
            </div>
            <div class="text-xs leading-tight text-gray-500 dark:text-gray-400">
                OPD
            </div>
        </div>
    </div>
@else
    <!-- Default brand untuk panel lain -->
    <div class="text-xl font-bold tracking-tight">
        {{ filament()->getBrandName() }}
    </div>
@endif