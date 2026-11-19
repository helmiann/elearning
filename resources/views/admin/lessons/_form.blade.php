<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Judul Lesson</label>
        <input type="text" name="title"
               value="{{ old('title', $lesson->title ?? '') }}"
               class="mt-1 w-full rounded-md border-gray-300">
        @error('title')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
        <textarea name="description" rows="4"
                  class="mt-1 w-full rounded-md border-gray-300">{{ old('description', $lesson->description ?? '') }}</textarea>
        @error('description')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>