document.getElementById('cadastro-form').addEventListener('submit', function(event) {
    const nome = document.getElementById('nome').value.trim();
    const partido = document.getElementById('partido').value.trim();
    const numero = document.getElementById('numero').value.trim();
    const foto = document.getElementById('foto').value.trim();
    const nomeVice = document.getElementById('nome-vice').value.trim();
    const fotoVice = document.getElementById('foto-vice').value.trim();
    
    if (!nome || !partido || !numero || !foto || !nomeVice || !fotoVice) {
        event.preventDefault();
        document.getElementById('message').textContent = 'Todos os campos, incluindo o nome e a foto do vice, devem ser preenchidos.';
    }
});
