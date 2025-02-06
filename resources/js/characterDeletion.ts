const deleteBtn = document.getElementById('deleteCharacter');
const deleteModal = document.getElementById('deleteModal');

deleteBtn?.addEventListener('click', () => {
    if (deleteModal) deleteModal.style.display = 'block';
});

document.querySelectorAll('.close, .close-modal').forEach(btn => {
    btn.addEventListener('click', () => {
        if (deleteModal) deleteModal.style.display = 'none';
    });
});

document.getElementById('confirmDelete')?.addEventListener('click', () => {
    fetch(`/characters/${characterId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    }).then(() => {
        window.location.href = '/characters';
    });
});
