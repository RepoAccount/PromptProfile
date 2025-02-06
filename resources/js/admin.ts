document.querySelectorAll('.role-select').forEach(select => {
    select.addEventListener('change', e => {
        const target = e.target as HTMLSelectElement;
        const userId = target.dataset.user;
        const newRole = target.value;

        fetch(`/admin/users/${userId}/role`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ role: newRole })
        })
            .then(r => {
                if (!r.ok) {
                    target.value = target.value === 'admin' ? 'user' : 'admin';
                    throw new Error('Failed to update role');
                }
            })
            .catch(err => {
                console.error(err);
            });
    });
});
