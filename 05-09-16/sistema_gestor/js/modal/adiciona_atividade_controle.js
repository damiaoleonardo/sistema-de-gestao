function openModal_adiciona_atividade(idModal) {
    var dialog = document.getElementById(idModal);
    dialog.style.opacity = 1;
    dialog.style.pointerEvents = "auto";
}

function fecha_modal(idModal) {
    var dialog = document.getElementById(idModal);
    dialog.style.opacity = 0;
    dialog.style.pointerEvents = "none";
}


