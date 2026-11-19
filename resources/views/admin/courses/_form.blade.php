<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Judul</label>
        <input type="text" name="title"
               value="{{ old('title', $course->title ?? '') }}"
               class="mt-1 w-full rounded-md border-gray-300">
        @error('title')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" rows="4"
                  class="mt-1 w-full rounded-md border-gray-300">{{ old('description', $course->description ?? '') }}</textarea>
        @error('description')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <label class="flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1"
               @checked(old('is_published', $course->is_published ?? false))>
        <span class="text-sm text-gray-700">Publikasikan course</span>
    </label>
</div>