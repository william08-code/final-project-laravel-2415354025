function openModal(id)
{
    const modal = document.getElementById(id);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id)
{
    const modal = document.getElementById(id);

    modal.classList.remove('flex');
    modal.classList.add('hidden');
}