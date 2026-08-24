<x-app-layout>
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-[28px] font-bold text-[#2C211A] font-serif-custom tracking-tight mb-1">Nuevo usuario</h1>
    <p class="text-gray-500 mb-8">Da de alta una cuenta para el personal.</p>

    <div class="bg-white rounded-[20px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-gray-100 p-8">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            @include('users._form', ['user' => null])
        </form>
    </div>
</div>
</x-app-layout>
