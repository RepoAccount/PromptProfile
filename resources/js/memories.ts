interface Memory {
    id: number;
    title: string;
    context: string;
    excerpt: string;
    scene_trigger: string | null;
    order: number;
}

function reorderColumn(column: HTMLElement | null) {
    if (!column) return;

    const memories = Array.from(column.querySelectorAll('.memory'));
    memories.sort((a, b) => {
        const orderA = Number((a.querySelector('.order') as HTMLInputElement).value);
        const orderB = Number((b.querySelector('.order') as HTMLInputElement).value);
        return orderA - orderB;
    });

    const addButton = column.querySelector('.add-memory');
    column.innerHTML = '';
    memories.forEach(mem => column.appendChild(mem));
    if (addButton) column.appendChild(addButton);
}

document.querySelector('.add-memory')?.addEventListener('click', () => {
    fetch(`/characters/${characterId}/memories`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
        .then(r => r.json())
        .then(memory => {
            const div = createMemory(memory);
            const list = document.querySelector('.memory-list');
            list?.insertBefore(div, list.querySelector('.add-memory'));
            reorderColumn(list);
        });
});

function createMemory(memory: Memory): HTMLElement {
    const div = document.createElement('div');
    div.className = 'memory';
    div.dataset.id = memory.id.toString();
    div.innerHTML = `
        <input type="text" class="segment-title" value="">
        <input type="text" class="memory-context" value="">
        <textarea class="segment-content"></textarea>
        <div class="segment-controls">
            <input type="text" class="scene-trigger" placeholder="Scene triggers">
            <input type="number" class="order" value="0">
            <button class="delete-btn">×</button>
        </div>
    `;
    bindMemoryEvents(div);
    return div;
}

function bindOrderInput(input: HTMLInputElement) {
    input.addEventListener('focus', () => {
        input.dataset.oldValue = input.value;
    });

    input.addEventListener('change', () => {
        const value = parseInt(input.value);
        if (isNaN(value) || value < 0) {
            input.value = input.dataset.oldValue || '0';
        }
    });
}

function bindMemoryEvents(memory: HTMLElement) {
    const title = memory.querySelector('.segment-title');
    const context = memory.querySelector('.memory-context');
    const excerpt = memory.querySelector('.segment-content');
    const trigger = memory.querySelector('.scene-trigger');
    const order = memory.querySelector('.order') as HTMLInputElement;
    const deleteBtn = memory.querySelector('.delete-btn');

    [title, context, excerpt, trigger, order].forEach(field => {
        field?.addEventListener('change', () => updateMemory(memory));
    });

    const orderInput = memory.querySelector('.order') as HTMLInputElement;
    if (orderInput) {
        bindOrderInput(orderInput);
        orderInput.addEventListener('change', () => {
            updateMemory(memory);
            reorderColumn(memory.closest('.memory-list'));
        });
    }

    deleteBtn?.addEventListener('click', () => {
        fetch(`/characters/${characterId}/memories/${memory.dataset.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        }).then(() => memory.remove());
    });
}

function updateMemory(memory: HTMLElement) {
    const data = {
        title: memory.querySelector<HTMLInputElement>('.segment-title')?.value,
        context: memory.querySelector<HTMLInputElement>('.memory-context')?.value,
        excerpt: memory.querySelector<HTMLTextAreaElement>('.segment-content')?.value,
        scene_trigger: memory.querySelector<HTMLInputElement>('.scene-trigger')?.value,
        order: Number(memory.querySelector<HTMLInputElement>('.order')?.value)
    };

    fetch(`/characters/${characterId}/memories/${memory.dataset.id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(data)
    });
}

document.querySelectorAll('.memory').forEach(memory => {
    bindMemoryEvents(memory as HTMLElement);
});

