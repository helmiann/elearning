<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Kelola Course</h2>
            <a href="{{ route('admin.courses.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                + Tambah Course
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3">Judul</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr class="border-t">
                            <td class="p-3">{{ $course->title }}</td>
                            <td class="p-3">
                                @if ($course->is_published)
                                    <span class="text-green-700">Published</span>
                                @else
                                    <span class="text-gray-500">Draft</span>
                                @endif
                            </td>
                            <td class="p-3 text-right space-x-3">
                                <a href="{{ route('admin.courses.edit', $course) }}"
                                   class="text-indigo-600">Edit</a>
                                <form action="{{ route('admin.courses.destroy', $course) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Hapus course ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-500">
                                Belum ada course.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $courses->links() }}</div>
    </div>
</x-app-layout>