<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#38533e] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2d4232] focus:bg-[#2d4232] active:bg-[#1a261c] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
