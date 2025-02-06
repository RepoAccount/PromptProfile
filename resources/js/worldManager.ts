interface World {
    id: number;
    name: string;
    selected: boolean;
}

const worldsBtn = document.getElementById('editWorldsBtn');
const worldsModal = document.getElementById('worldsModal');
const characterWorlds = document.getElementById('characterWorlds');
const worldPicker = document.getElementById('worldPicker');
const closeBtn = worldsModal?.querySelector('.close');

worldsBtn?.addEventListener('click', () => {
    if (!worldsModal) return;
    worldsModal.style.display = "block";
    loadWorlds();
});

closeBtn?.addEventListener('click', () => {
    if (!worldsModal) return;
    worldsModal.style.display = "none";
});

function loadWorlds() {
    fetch(`/characters/${characterId}/worlds`)
        .then(r => r.json())
        .then(data => {
            renderCurrentWorlds(data.current);
            renderAvailableWorlds(data.available);
        });
}

function renderCurrentWorlds(worlds: World[]) {
    if (!characterWorlds) return;

    characterWorlds.innerHTML = worlds.map(world => `
        <div class="world-item">
            ${world.name}
            <button class="remove-world" data-id="${world.id}">×</button>
        </div>
    `).join('');

    characterWorlds.removeEventListener('click', handleRemoveWorld);
    characterWorlds.addEventListener('click', handleRemoveWorld);
}

function handleRemoveWorld(e: Event) {
    const btn = (e.target as HTMLElement).closest('.remove-world');
    if (!btn) return;

    const worldId = btn.getAttribute('data-id');
    removeWorld(Number(worldId));
}

function renderAvailableWorlds(worlds: World[]) {
    if (!worldPicker) return;

    worldPicker.innerHTML = worlds.map(world => `
        <div class="world-item">
            ${world.name}
            <button class="add-world" data-id="${world.id}">+</button>
        </div>
    `).join('');

    worldPicker.removeEventListener('click', handleAddWorld);
    worldPicker.addEventListener('click', handleAddWorld);
}

function handleAddWorld(e: Event) {
    const btn = (e.target as HTMLElement).closest('.add-world');
    if (!btn) return;

    const worldId = btn.getAttribute('data-id');
    addWorld(Number(worldId));
}

function addWorld(worldId: number) {
    fetch(`/characters/${characterId}/worlds/${worldId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    }).then(() => loadWorlds());
}

function removeWorld(worldId: number) {
    fetch(`/characters/${characterId}/worlds/${worldId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    }).then(() => loadWorlds());
}
