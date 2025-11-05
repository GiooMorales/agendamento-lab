const confirmationModal = document.getElementById('confirmationModal');
const form = document.getElementById('delete_place_form');

confirmationModal.addEventListener('shown.bs.modal', (event) => {
    const id = event.relatedTarget.getAttribute('data-place-id');
    form.action = "/places/" + id;
});