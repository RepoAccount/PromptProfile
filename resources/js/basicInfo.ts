interface Character {
    id: number;
    name: string;
    summary: string;
}

class BasicInfoEditor {
    private character: Character;

    constructor(characterId: number) {
        this.character = {
            id: characterId,
            name: document.querySelector<HTMLHeadingElement>('#characterName')?.textContent || '',
            summary: document.querySelector<HTMLTextAreaElement>('#summary')?.value || ''
        };

        this.bindEvents();
    }

    private bindEvents() {
        document.querySelector('#editBasicInfo')?.addEventListener('click', () => this.showEditModal());
    }

    private showEditModal() {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
        <div class="modal-content">
            <span class="close">×</span>
            <input type="text" id="editName" value="${this.character.name}">
            <textarea id="editSummary">${this.character.summary}</textarea>
            <button class="general-button" id="saveBasicInfo">Save</button>
        </div>
    `;
        document.body.appendChild(modal);
        modal.style.display = "block";
        this.bindModalEvents(modal);
    }

    private bindModalEvents(modal: HTMLElement) {
        modal.querySelector('.close')?.addEventListener('click', () => {
            modal.style.display = "none";
            modal.remove();
        });
        modal.querySelector('#saveBasicInfo')?.addEventListener('click', () => this.saveChanges(modal));
    }


    private saveChanges(modal: HTMLElement) {
        const name = modal.querySelector<HTMLInputElement>('#editName')?.value;
        const summary = modal.querySelector<HTMLTextAreaElement>('#editSummary')?.value;

        fetch(`/characters/${this.character.id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ name, summary })
        })
            .then(r => r.json())
            .then(data => {
                this.character.name = data.name;
                this.character.summary = data.summary;
                document.querySelector('#characterName')!.textContent = data.name;
                document.querySelector('h1')!.textContent = data.name;
                document.querySelector('#summary')!.value = data.summary;
                modal.remove();
            });
    }



}

new BasicInfoEditor(characterId);
