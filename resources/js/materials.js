const typeIconsMap = {
    video: '🎬',
    pdf: '📄',
    document: '📝',
    link: '🔗'
};

function toggleFileUrl(prefix) {
    const typeEl = document.getElementById(prefix + 'Type') || document.getElementById(prefix + '_type');
    if (!typeEl) return;

    const type = typeEl.value;
    const fileWrap = document.getElementById(prefix + 'FileWrap');
    const urlWrap = document.getElementById(prefix + 'UrlWrap');

    if (!fileWrap || !urlWrap) return;

    const fileInput = fileWrap.querySelector('input[type="file"]');
    const acceptMap = {
        pdf: '.pdf',
        video: 'video/*',
        document: '.doc,.docx,.ppt,.pptx,.xls,.xlsx',
        link: '' // tidak perlu accept khusus
    };

    if (fileInput) {
        fileInput.accept = acceptMap[type] || '';
    }

    if (type === 'link') {
        fileWrap.classList.add('hidden');
        urlWrap.classList.remove('hidden');
    } else {
        fileWrap.classList.remove('hidden');
        urlWrap.classList.add('hidden');
    }
}

function openAddModal() {
    const modal = document.getElementById('addModal');
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    toggleFileUrl('add');
}

function closeAddModal() {
    const modal = document.getElementById('addModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openEditModal(mat) {
    const form = document.getElementById('editForm');
    if (!form) return;

    form.action = `/materials/${mat.id}`;
    document.getElementById('edit_service_id').value = mat.service_id || '';
    document.getElementById('edit_title').value = mat.title || '';
    document.getElementById('edit_description').value = mat.description || '';
    document.getElementById('edit_type').value = mat.type || 'pdf';
    document.getElementById('edit_position').value = mat.position || 0;
    document.getElementById('edit_url').value = mat.url || '';
    document.getElementById('edit_is_active').checked = !!mat.is_active;

    toggleFileUrl('edit');

    const modal = document.getElementById('editModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function buildPreviewContent(type, url, title) {
    const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
    const gdMatch = url.match(/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/);
    const isDoc = /\.(doc|docx)$/i.test(url);

    if (type === 'pdf') {
        return `<iframe src="${url}" class="w-full h-[70vh] border-0"></iframe>`;
    }

    if (type === 'video' || (type === 'link' && (ytMatch || vimeoMatch))) {
        if (ytMatch) {
            return `
                <div class="relative w-full pb-[56.25%] bg-black">
                    <iframe id="yt-iframe"
                        class="absolute inset-0 w-full h-full border-0"
                        src="https://www.youtube.com/embed/${ytMatch[1]}?enablejsapi=1"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                    <div id="yt-error-overlay" class="hidden absolute inset-0 z-10 bg-[#0f0f0f] flex flex-col items-center justify-center text-center">
                        <div class="text-5xl mb-4">⚠️</div>
                        <p class="text-white font-semibold text-lg">Video tidak diizinkan</p>
                        <a href="https://youtu.be/${ytMatch[1]}" target="_blank"
                           class="mt-3 text-blue-400 hover:text-blue-300 text-sm underline">
                            Tonton di YouTube
                        </a>
                    </div>
                </div>`;
        }

        if (vimeoMatch) {
            return `
                <div class="relative w-full pb-[56.25%]">
                    <iframe class="absolute inset-0 w-full h-full border-0"
                        src="https://player.vimeo.com/video/${vimeoMatch[1]}"
                        allowfullscreen>
                    </iframe>
                </div>`;
        }

        return `
            <video controls class="w-full max-h-[70vh] mx-auto">
                <source src="${url}">
                Browser tidak mendukung format video ini.
            </video>`;
    }

    if (type === 'link' && gdMatch) {
        return `<iframe src="https://drive.google.com/file/d/${gdMatch[1]}/preview"
                    class="w-full h-[70vh] border-0" allow="autoplay"></iframe>`;
    }

    if (type === 'document') {
        const viewerUrl = isDoc
            ? `https://docs.google.com/gview?url=${encodeURIComponent(url)}&embedded=true`
            : url;
        return `<iframe src="${viewerUrl}" class="w-full h-[70vh] border-0"></iframe>`;
    }

    // fallback link biasa
    return `
        <div class="flex flex-col items-center justify-center min-h-[400px] p-8 text-center">
            <a href="${url}" target="_blank"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-red-800 to-red-600 hover:brightness-110 text-white px-6 py-3 rounded-xl font-bold text-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Buka Link
            </a>
        </div>`;
}

function openPreviewModal(type, url, title) {
    const titleEl = document.getElementById('previewTitle');
    const typeEl  = document.getElementById('previewType');
    const iconEl  = document.getElementById('previewIcon');
    const linkEl  = document.getElementById('previewOpenLink');
    const content = document.getElementById('previewContent');
    const modal   = document.getElementById('previewModal');

    if (!modal || !content) return;

    if (titleEl) titleEl.textContent = title || 'Preview Materi';
    if (typeEl)  typeEl.textContent  = (type || '').toUpperCase();
    if (iconEl)  iconEl.textContent  = typeIconsMap[type] || '📎';
    if (linkEl)  linkEl.href = url || '#';

    content.innerHTML = buildPreviewContent(type, url, title);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    if (!modal) return;

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    const content = document.getElementById('previewContent');
    if (content) content.innerHTML = '';
}

// tutup modal ketika klik di luar konten
['addModal', 'editModal', 'previewModal'].forEach(id => {
    const modal = document.getElementById(id);
    if (!modal) return;

    const closeFn = {
        addModal: closeAddModal,
        editModal: closeEditModal,
        previewModal: closePreviewModal
    }[id];

    modal.addEventListener('click', e => {
        if (e.target === modal) {
            closeFn();
        }
    });
});

// YouTube error handler (khusus iframe yt)
window.addEventListener('message', e => {
    if (e.origin !== 'https://www.youtube.com') return;
    try {
        const data = JSON.parse(e.data);
        if (data.event === 'onError' || [150, 101].includes(data.info)) {
            document.getElementById('yt-error-overlay')?.style.setProperty('display', 'flex');
        }
    } catch {}
});

const materials = {
    toggleFileUrl,
    openAddModal,
    closeAddModal,
    openEditModal,
    closeEditModal,
    openPreviewModal,
    closePreviewModal,
    buildPreviewContent,
};

window.materials = materials;
