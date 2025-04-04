<button
    {{ $attributes->merge(["type" => "submit", "class" => "inline-flex items-center justify-center px-4 py-2 bg-gray-800 cursor-pointer border border-transparent rounded-md font-semibold text-white text-center tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"]) }}
>
    {{ $slot }}
</button>
