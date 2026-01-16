@props([
    'mode' => 'auto', // auto | light | dark
])
<div class="text-center">
    @if ($mode === 'light')
        <img {{ $attributes->class('h-48 mx-auto') }}
             src="{{ asset('assets/images/logo/logo.png') }}" alt="Bud Logo">
    @elseif ($mode === 'dark')
        <img {{ $attributes->class('h-48 mx-auto') }}
             src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Bud Logo">
    @else
        {{-- auto (Tailwind dark mode) --}}
        <img {{ $attributes->class('dark:hidden h-48 mx-auto') }}
             src="{{ asset('assets/images/logo/logo.png') }}" alt="Bud Logo">

        <img {{ $attributes->class('hidden dark:block h-48 mx-auto') }}
             src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Bud Logo">
    @endif
    <p class="mt-2 text-black/60 dark:text-white/60">Convert Python dictionaries to JSON</p>
</div>
