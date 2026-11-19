<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Lesson: {{ $course->title }}
            </h2>
            <a href="{{ route('admin.courses.lessons.create', $course) }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                + Tambah Lesson
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.courses.index') }}"
           class="text-sm text-gray-600">&larr; Kembali ke daftar course</a>

        @if (session('success'))
            <div class="my-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-4 bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3 w-12">#</th>
                        <th class="p-3">Judul</th>
                        <th class="p-3">Urutan</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lessons as $lesson)
                        <tr class="border-t">
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">{{ $lesson->title }}</td>
                            <td class="p-3">
                                <div class="flex gap-1">
                                    <form method="POST"
                                          action="{{ route('admin.lessons.move', [$lesson, 'up']) }}">
                                        @csrf @method('PATCH')
                                        <button class="px-2 py-1 border rounded disabled:opacity-30"
                                                @disabled($loop->first)>&uarr;</button>
                                    </form>
                                    <form method="POST"
                                          action="{{ route('admin.lessons.move', [$lesson, 'down']) }}">
                                        @csrf @method('PATCH')
                                        <button class="px-2 py-1 border rounded disabled:opacity-30"
                                                @disabled($loop->last)>&darr;</button>
                                    </form>
                                </div>
                            </td>
                            <td class="p-3 text-right space-x-3">
                                <a href="{{ route('admin.lessons.edit', $lesson) }}"
                                   class="text-indigo-600">Edit</a>
                                <form action="{{ route('admin.lessons.destroy', $lesson) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Hapus lesson ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                Belum ada lesson.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>