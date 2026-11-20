<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $course->title }}</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('courses.show', $course) }}" class="text-sm text-gray-600">
            &larr; Kembali ke course
        </a>

        <div class="mt-4 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="bg-black rounded-lg overflow-hidden">
                    @if ($lesson->video_status === 'ready')
                        <video controls preload="metadata" class="w-full"
                               src="{{ route('lessons.video', $lesson) }}">
                            Browser kamu tidak mendukung pemutar video.
                        </video>
                    @else
                        <div class="p-12 text-center text-gray-300">
                            Video untuk lesson ini belum tersedia.
                        </div>
                    @endif
                </div>

                <h3 class="mt-4 text-lg font-semibold text-gray-800">{{ $lesson->title }}</h3>
                <p class="mt-2 text-gray-600 whitespace-pre-line">{{ $lesson->description }}</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg divide-y h-fit">
                @foreach ($lessons as $item)
                    <a href="{{ route('lessons.show', $item) }}"
                       class="block p-3 text-sm {{ $item->id === $lesson->id ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                        {{ $loop->iteration }}. {{ $item->title }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>