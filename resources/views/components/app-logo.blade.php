@props([
    'mode' => 'auto', // auto | light | dark
])
<div class="text-center">
    @if ($mode === 'light')
        <img {{ $attributes->class('h-40 mx-auto') }}
             src="{{ asset('assets/images/logo/logo.png') }}" alt="Py2Json Logo">
    @elseif ($mode === 'dark')
        <img {{ $attributes->class('h-40 mx-auto') }}
             src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Py2Json Logo">
    @else
        {{-- auto (Tailwind dark mode) --}}
        <img {{ $attributes->class('dark:hidden h-40 mx-auto') }}
             src="{{ asset('assets/images/logo/logo.png') }}" alt="Py2Json Logo">

        <img {{ $attributes->class('hidden dark:block h-40 mx-auto') }}
             src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Py2Json Logo">
    @endif
    <p class="mt-2 text-black/60 dark:text-white/60">Convert Python dictionaries to JSON</p>
</div>
