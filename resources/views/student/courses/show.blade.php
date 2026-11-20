<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $course->title }}</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('courses.index') }}" class="text-sm text-gray-600">&larr; Semua course</a>

        <div class="mt-4 bg-white shadow-sm sm:rounded-lg p-6">
            <p class="text-gray-700 whitespace-pre-line">{{ $course->description }}</p>
        </div>

        <h3 class="mt-8 mb-3 font-semibold text-gray-800">Daftar Lesson</h3>

        <div class="bg-white shadow-sm sm:rounded-lg divide-y">
            @forelse ($lessons as $lesson)
                <a href="{{ route('lessons.show', $lesson) }}"
                   class="flex items-center justify-between p-4 hover:bg-gray-50">
                    <span>
                        <span class="text-gray-400 mr-3">{{ $loop->iteration }}</span>
                        {{ $lesson->title }}
                    </span>
                    @if ($lesson->video_status !== 'ready')
                        <span class="text-xs text-gray-400">Video belum tersedia</span>
                    @endif
                </a>
            @empty
                <p class="p-4 text-gray-500">Belum ada lesson.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>