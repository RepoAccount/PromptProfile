interface Image {
    id: number;
    file_path: string;
    description: string | null;
    type: 'background' | 'profile' | 'expression';
}

const uploadBtn = document.getElementById('uploadBtn');
const imageInput = document.getElementById('imageInput') as HTMLInputElement;
const typeSelect = document.getElementById('imageType') as HTMLSelectElement;

const profileGrid = document.querySelector('.profile-grid');
const backgroundGrid = document.querySelector('.background-grid');
const miscGrid = document.querySelector('.misc-grid');

uploadBtn?.addEventListener('click', () => imageInput.click());

imageInput?.addEventListener('change', () => {
    if (!imageInput.files?.length) return;

    const file = imageInput.files[0];
    const validTypes = ['image/jpeg', 'image/png', 'image/webp'];

    if (!validTypes.includes(file.type)) {
        document.getElementById('uploadError')!.textContent = 'Only JPG, PNG and WebP files allowed';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        document.getElementById('uploadError')!.textContent = 'File too large (max 2MB)';
        return;
    }

    const formData = new FormData();
    formData.append('type', typeSelect.value);
    for (let i = 0; i < imageInput.files.length; i++) {
        formData.append('images[]', imageInput.files[i]);
    }

    fetch(`/characters/${characterId}/images`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: formData
    })
        .then(r => r.json())
        .then(images => {
            document.getElementById('uploadError')!.textContent = '';
            images.forEach(addImageToGrid);
            imageInput.value = '';
        });
});

function addImageToGrid(image: Image) {
    const grid = image.type === 'profile' ? profileGrid :
        image.type === 'background' ? backgroundGrid :
            miscGrid;

    const controls = image.type === 'profile'
        ? `<button class="star-image">★</button><button class="delete-image">×</button>`
        : `<button class="delete-image">×</button>`;

    const div = document.createElement('div');
    div.className = 'image-card';
    div.dataset.id = image.id.toString();
    div.innerHTML = `
        <img src="${image.file_path}" alt="${image.description || ''}">
        <div class="image-controls">
            ${controls}
        </div>
    `;
    grid?.appendChild(div);
}

document.querySelectorAll('.image-grid').forEach(grid => {
    grid.addEventListener('click', e => {
        const deleteBtn = (e.target as HTMLElement).closest('.delete-image');
        if (!deleteBtn) return;

        const imageCard = deleteBtn.closest('.image-card');
        const imageId = imageCard?.dataset.id;

        fetch(`/characters/${characterId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        }).then(() => imageCard?.remove());
    });
});

document.querySelector('.profile-grid')?.addEventListener('click', e => {
    const starBtn = (e.target as HTMLElement).closest('.star-image');
    if (!starBtn) return;

    const imageCard = starBtn.closest('.image-card');
    const imageId = imageCard?.dataset.id;
    const method = starBtn.classList.contains('active') ? 'DELETE' : 'POST';

    fetch(`/characters/${characterId}/images/${imageId}/set-profile`, {
        method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    }).then(() => {
        if (method === 'DELETE') {
            starBtn.classList.remove('active');
        } else {
            document.querySelectorAll('.star-image').forEach(btn =>
                btn.classList.remove('active')
            );
            starBtn.classList.add('active');
        }
    });
});


