<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Daftar Course</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($courses as $course)
                <a href="{{ route('courses.show', $course) }}"
                   class="block bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="font-semibold text-gray-800">{{ $course->title }}</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ Str::limit($course->description, 100) }}
                    </p>
                    <p class="mt-4 text-xs text-gray-500">{{ $course->lessons_count }} lesson</p>
                </a>
            @empty
                <p class="text-gray-500">Belum ada course yang dipublikasikan.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $courses->links() }}</div>
    </div>
</x-app-layout>