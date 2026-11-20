<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Ubah Lesson</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}"
              class="bg-white shadow-sm sm:rounded-lg p-6">
            @csrf
            @method('PUT')
            @include('admin.lessons._form')
            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Perbarui</button>
                <a href="{{ route('admin.courses.lessons.index', $lesson->course_id) }}"
                   class="px-4 py-2 text-gray-600">Batal</a>
            </div>
        </form>
        <div id="video-box"
     data-url="{{ route('admin.lessons.video.store', $lesson) }}"
     data-token="{{ csrf_token() }}"
     class="mt-6 bg-white shadow-sm sm:rounded-lg p-6">
    <h3 class="font-semibold text-gray-800">Video Lesson</h3>

    <p class="mt-2 text-sm text-gray-600">
        Status: <span id="video-status" class="font-medium">{{ $lesson->videoStatusLabel() }}</span>
    </p>
    @if ($lesson->video_original_name)
        <p class="text-sm text-gray-500">File: <span id="video-name">{{ $lesson->video_original_name }}</span></p>
    @endif

    <div class="mt-4 flex items-center gap-3">
        <input type="file" id="video-input" accept="video/mp4,video/webm" class="text-sm">
        <button type="button" id="video-btn"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm disabled:opacity-50">
            Upload
        </button>
    </div>

    <div class="mt-4 w-full h-3 bg-gray-200 rounded overflow-hidden">
        <div id="video-bar" class="h-3 bg-indigo-600" style="width: 0%"></div>
    </div>
    <p id="video-msg" class="mt-2 text-sm text-gray-600"></p>
    <p class="mt-1 text-xs text-gray-400">Format MP4 atau WebM, maksimal 200 MB.</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const box    = document.getElementById('video-box');
    const input  = document.getElementById('video-input');
    const btn    = document.getElementById('video-btn');
    const bar    = document.getElementById('video-bar');
    const msg    = document.getElementById('video-msg');
    const status = document.getElementById('video-status');
    const labels = { uploading: 'Sedang diunggah', ready: 'Siap', failed: 'Gagal' };

    btn.addEventListener('click', function () {
        if (!input.files.length) {
            msg.textContent = 'Pilih file video dulu.';
            return;
        }

        const data = new FormData();
        data.append('video', input.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', box.dataset.url);
        xhr.setRequestHeader('X-CSRF-TOKEN', box.dataset.token);
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable) {
                const pct = Math.round((e.loaded / e.total) * 100);
                bar.style.width = pct + '%';
                msg.textContent = 'Mengunggah... ' + pct + '%';
            }
        });

        xhr.onload = function () {
            let res = {};
            try { res = JSON.parse(xhr.responseText); } catch (e) {}

            if (xhr.status === 200) {
                status.textContent = labels.ready;
                msg.textContent = res.message;
            } else if (xhr.status === 422 && res.errors) {
                status.textContent = 'Belum ada video / video lama';
                msg.textContent = Object.values(res.errors).flat()[0];
                bar.style.width = '0%';
            } else {
                status.textContent = labels.failed;
                msg.textContent = res.message || 'Upload gagal (kode ' + xhr.status + ').';
            }
            btn.disabled = false;
        };

        xhr.onerror = function () {
            status.textContent = labels.failed;
            msg.textContent = 'Koneksi terputus saat upload.';
            btn.disabled = false;
        };

        btn.disabled = true;
        status.textContent = labels.uploading;
        msg.textContent = 'Memulai upload...';
        bar.style.width = '0%';
        xhr.send(data);
    });
});
</script>
    </div>
</x-app-layout>