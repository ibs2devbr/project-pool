window.addEventListener ('DOMContentLoaded', Event => {
    document.querySelectorAll ('.group-container').forEach (GroupContainer => {
        if (GroupContainer.querySelector ('.group-command')) {
            GroupContainer.querySelector ('.group-command').addEventListener ('click', () => {
                navigator.clipboard.writeText (GroupContainer.querySelector ('.group-content')['textContent']).then (() => {
                    alert ('Cópia feita com sucesso!');
                }).catch (Error => {
                    alert ('Erro na cópia.');
                });
            });
        };
    });
});