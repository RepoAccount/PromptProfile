const mainPrompt = document.getElementById('mainPrompt') as HTMLTextAreaElement;
const writingPrompt = document.getElementById('writingPrompt') as HTMLTextAreaElement;
const miscPrompt = document.getElementById('miscPrompt') as HTMLTextAreaElement;

[mainPrompt, writingPrompt, miscPrompt].forEach(textarea => {
    textarea?.addEventListener('change', () => {
        fetch(`/characters/${characterId}/prompts`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                main_prompt: mainPrompt.value,
                writing_prompt: writingPrompt.value,
                misc_prompt: miscPrompt.value
            })
        });
    });
});
