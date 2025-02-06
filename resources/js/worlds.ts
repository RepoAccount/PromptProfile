interface World {
    id: number;
    name: string;
    description: string;
}

let currentWorldList: World[] = [];

document.addEventListener('DOMContentLoaded', () => {
    const worldList = document.querySelector('.world-list');

    fetch('/worlds')
        .then(response => response.json())
        .then((worlds: World[]) => {
            worlds.forEach(world => {
                const worldDiv = document.createElement('div');
                worldDiv.className = 'filter-option';
                worldDiv.textContent = world.name;
                worldDiv.dataset.id = world.id.toString();
                worldDiv.addEventListener('click', () => filterByWorld(world.id));
                worldList?.appendChild(worldDiv);
            });
        });
});

function filterByWorld(worldId: number) {
    const worldElement = document.querySelector(`[data-id="${worldId}"]`);
    const isActive = worldElement?.classList.contains('active');

    document.querySelectorAll('.filter-option').forEach(el =>
        el.classList.remove('active')
    );

    if (isActive) {
        loadAllCharacters();
    } else {
        worldElement?.classList.add('active');
        fetch(`/worlds/${worldId}/characters`)
            .then(response => response.json())
            .then(characters => {
                updateCharacterGrid(characters);
            });
    }
}

function loadAllCharacters() {
    fetch('/characters/list')
        .then(response => response.json())
        .then(characters => updateCharacterGrid(characters));
}

function updateCharacterGrid(characters: any[]) {
    const container = document.querySelector('.characters-container');
    if (!container) return;

    container.innerHTML = characters.map(char => `
        <div class="character" data-character-id="${char.id}">
            <a href="/characters/${char.id}">
                <img src="${char.image || '/img/placeholder.jpg'}" alt="${char.name}">
                <p>${char.name}</p>
            </a>
        </div>
    `).join('');
}

const createWorldButton = document.getElementById('createWorldBtn');
const modal = document.getElementById('createWorldModal') as HTMLDivElement;
const closeButton = modal.querySelector('.close') as HTMLSpanElement;
const submitButton = document.getElementById('submitWorld') as HTMLButtonElement;

createWorldButton.addEventListener('click', () => modal.style.display = 'block');
closeButton.addEventListener('click', () => modal.style.display = 'none');

submitButton.addEventListener('click', () => {
    const nameInput = document.getElementById('worldName') as HTMLInputElement;
    const descInput = document.getElementById('worldDescription') as HTMLTextAreaElement;
    const errorMessage = document.getElementById('worldValidationError') as HTMLParagraphElement;

    if (nameInput.value.length === 0 || nameInput.value.length > 255) {
        errorMessage.textContent = 'Name must be between 1 and 255 characters.';
        return;
    }

    if (!descInput.value.trim()) {
        errorMessage.textContent = 'Description is required.';
        return;
    }

    fetch('/worlds', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
            name: nameInput.value,
            description: descInput.value
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                errorMessage.textContent = data.error;
                return;
            }
            location.reload();
        });
});

const editWorldsButton = document.getElementById('editWorldsBtn');
editWorldsButton?.addEventListener('click', () => {
    const editModal = document.getElementById('editWorldModal') as HTMLElement;
    const worldList = editModal.querySelector('#worldList') as HTMLElement;

    fetch('/worlds')
        .then(r => r.json())
        .then((worlds: World[]) => {
            worldList.innerHTML = worlds.map(world => `
                <div class="world-item">
                    ${world.name}
                    <div class="world-controls">
                        <button class="edit-world" data-id="${world.id}">✎</button>
                        <button class="remove-world" data-id="${world.id}">×</button>
                    </div>
                </div>
            `).join('');
        });

    editModal.style.display = 'block';
});

function showWorldList() {
    const editModal = document.getElementById('editWorldModal') as HTMLElement;
    editModal.innerHTML = `
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Edit Worlds</h2>
            <div id="worldList"></div>
        </div>
    `;

    const worldList = editModal.querySelector('#worldList') as HTMLElement;
    const closeBtn = editModal.querySelector('.close') as HTMLElement;

    closeBtn.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    worldList.addEventListener('click', e => {
        const target = e.target as HTMLElement;
        const worldId = Number(target.dataset.id);

        if (target.classList.contains('edit-world')) handleWorldEdit(worldId);
        if (target.classList.contains('remove-world')) handleWorldDelete(worldId);
    });

    fetch('/worlds')
        .then(r => r.json())
        .then((worlds: World[]) => {
            worldList.innerHTML = worlds.map(world => `
                <div class="world-item">
                    ${world.name}
                    <div class="world-controls">
                        <button class="edit-world" data-id="${world.id}">✎</button>
                        <button class="remove-world" data-id="${world.id}">×</button>
                    </div>
                </div>
            `).join('');
        });
}

function handleWorldEdit(worldId: number) {
    fetch(`/worlds/${worldId}`)
        .then(r => r.json())
        .then((world: World) => {
            const editModal = document.getElementById('editWorldModal') as HTMLElement;
            editModal.innerHTML = `
                <div class="modal-content">
                    <h2>Edit World</h2>
                    <input type="text" id="editWorldName" value="${world.name}">
                    <textarea id="editWorldDescription">${world.description}</textarea>
                    <div class="modal-buttons">
                        <button class="general-button" id="saveWorld">Save</button>
                        <button class="general-button" id="cancelEdit">Cancel</button>
                    </div>
                </div>
            `;

            const saveBtn = document.getElementById('saveWorld');
            const cancelBtn = document.getElementById('cancelEdit');

            saveBtn?.addEventListener('click', () => {
                const name = (document.getElementById('editWorldName') as HTMLInputElement).value;
                const description = (document.getElementById('editWorldDescription') as HTMLTextAreaElement).value;

                fetch(`/worlds/${worldId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ name, description })
                })
                    .then(() => {
                        showWorldList();
                        updateSidebarWorldList();
                    });
            });

            function updateSidebarWorldList() {
                fetch('/worlds')
                    .then(r => r.json())
                    .then(worlds => {
                        const worldList = document.querySelector('.world-list');
                        if (!worldList) return;
                        worldList.innerHTML = worlds.map((world: World) => `
                <div class="world-item" data-world-id="${world.id}">${world.name}</div>
            `).join('');
                    });
            }

            cancelBtn?.addEventListener('click', () => showWorldList());
        });
}

function handleWorldDelete(worldId: number) {
    const editModal = document.getElementById('editWorldModal') as HTMLElement;
    editModal.innerHTML = `
        <div class="modal-content">
            <h2>Delete World</h2>
            <p class="confirmation">Are you sure you want to delete this world?</p>
            <div class="modal-buttons">
                <button class="general-button" id="confirmDelete">Delete</button>
                <button class="general-button" id="cancelDelete">Cancel</button>
            </div>
        </div>
    `;

    document.getElementById('confirmDelete')?.addEventListener('click', () => {
        fetch(`/worlds/${worldId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        }).then(() => location.reload());
    });

    document.getElementById('cancelDelete')?.addEventListener('click', () => {
        showWorldList();
    });


}

document.getElementById('worldList')?.addEventListener('click', e => {
    const target = e.target as HTMLElement;
    const worldId = Number(target.dataset.id);

    if (target.classList.contains('edit-world')) handleWorldEdit(worldId);
    if (target.classList.contains('remove-world')) handleWorldDelete(worldId);
});

document.querySelectorAll('.modal .close').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const modal = (e.target as HTMLElement).closest('.modal');
        if (modal) modal.style.display = 'none';
    });
});
