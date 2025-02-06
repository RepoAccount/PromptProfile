interface Segment {
    id: number;
    title: string | null;
    segment_content: string;
    scene_trigger: string | null;
    order: number;
}

['Backstory', 'Relationships', 'Personality', 'Misc'].forEach(type => {
    document.getElementById(`add${type}`)?.addEventListener('click', () => {
        const list = document.querySelector(`.segment-list[data-type="${type.toLowerCase()}"]`);

        fetch(`/characters/${characterId}/segments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ type: type.toLowerCase() })
        })
            .then(r => r.json())
            .then(segment => {
                const div = createSegment(segment);
                list?.appendChild(div);
                reorderColumn(list);
            });
    });
});

function createSegment(segment: Segment): HTMLElement {
    const div = document.createElement('div');
    div.className = 'segment';
    div.dataset.id = segment.id.toString();
    div.innerHTML = `
        <input type="text" class="segment-title" value="">
        <textarea class="segment-content"></textarea>
        <div class="segment-controls">
            <input type="text" class="scene-trigger" placeholder="Scene triggers">
            <input type="number" class="order" value="0">
            <button class="delete-btn">×</button>
        </div>
    `;
    bindSegmentEvents(div);
    return div;
}

function bindSegmentEvents(segment: HTMLElement) {
    const title = segment.querySelector('.segment-title');
    const content = segment.querySelector('.segment-content');
    const trigger = segment.querySelector('.scene-trigger');
    const order = segment.querySelector('.order');
    const deleteBtn = segment.querySelector('.delete-btn');

    [title, content, trigger, order].forEach(field => {
        field?.addEventListener('change', () => updateSegment(segment));
    });

    deleteBtn?.addEventListener('click', () => {
        fetch(`/characters/${characterId}/segments/${segment.dataset.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        }).then(() => segment.remove());
    });

    const orderInput = segment.querySelector('.order') as HTMLInputElement;
    if (orderInput) {
        bindOrderInput(orderInput);
        orderInput.addEventListener('change', () => {
            updateSegment(segment);
            reorderColumn(segment.closest('.segment-list'));
        });
    }
}

function reorderColumn(column: HTMLElement | null) {
    if (!column) return;

    const segments = Array.from(column.querySelectorAll('.segment'));
    segments.sort((a, b) => {
        const orderA = Number((a.querySelector('.order') as HTMLInputElement).value);
        const orderB = Number((b.querySelector('.order') as HTMLInputElement).value);
        return orderA - orderB;
    });

    const addButton = column.querySelector('.add-segment');
    segments.forEach(seg => column.appendChild(seg));
    if (addButton) column.appendChild(addButton);
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


function updateSegment(segment: HTMLElement) {
    const data = {
        title: segment.querySelector<HTMLInputElement>('.segment-title')?.value,
        segment_content: segment.querySelector<HTMLTextAreaElement>('.segment-content')?.value,
        scene_trigger: segment.querySelector<HTMLInputElement>('.scene-trigger')?.value,
        order: Number(segment.querySelector<HTMLInputElement>('.order')?.value)
    };

    fetch(`/characters/${characterId}/segments/${segment.dataset.id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(data)
    });
}

document.querySelectorAll('.segment').forEach(segment => {
    bindSegmentEvents(segment as HTMLElement);
});
