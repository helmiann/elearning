<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Lesson: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.courses.lessons.store', $course) }}"
              class="bg-white shadow-sm sm:rounded-lg p-6">
            @csrf
            @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
            @endif
            @include('admin.lessons._form')
            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Simpan</button>
                <a href="{{ route('admin.courses.lessons.index', $course) }}"
                   class="px-4 py-2 text-gray-600">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>