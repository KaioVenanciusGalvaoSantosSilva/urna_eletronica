document.getElementById('cadastro-form').addEventListener('submit', function(event) {
    const nome = document.getElementById('nome').value.trim();
    const partido = document.getElementById('partido').value.trim();
    const numero = document.getElementById('numero').value.trim();
    const foto = document.getElementById('foto').value.trim();
    
    if (!nome || !partido || !numero || !foto) {
        event.preventDefault();
        document.getElementById('message').textContent = 'Todos os campos devem ser preenchidos.';
    }
});
