const modal = document.getElementById('createModal') as HTMLElement;
const btn = document.getElementById("createCharacterBtn") as HTMLElement;
const span = document.getElementsByClassName("close")[0] as HTMLElement;
const submitBtn = document.getElementById("submitCharacter") as HTMLElement;
const errorMessage = document.getElementById('validationError') as HTMLElement;

btn.onclick = () => {
    modal.style.display = "block";
    errorMessage.style.display = 'none';
}
span.onclick = () => modal.style.display = "none";
window.onclick = (event) => {
    if (event.target == modal) modal.style.display = "none";
}

submitBtn.onclick = () => {
    const nameInput = (document.getElementById('characterName') as HTMLInputElement);
    if (nameInput.value.length === 0 || nameInput.value.length > 255) {
        errorMessage.textContent = 'Name must be between 1 and 255 characters.';
        errorMessage.style.display = 'block';
        return;
    }
    errorMessage.style.display = 'none';
    fetch('/characters', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ name: nameInput.value })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `/characters/${data.id}`;
            }
        });
    modal.style.display = "none";
}
