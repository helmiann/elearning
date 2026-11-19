<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tambah Course</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.courses.store') }}"
              class="bg-white shadow-sm sm:rounded-lg p-6">
            @csrf
            @include('admin.courses._form')
            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Simpan</button>
                <a href="{{ route('admin.courses.index') }}"
                   class="px-4 py-2 text-gray-600">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>