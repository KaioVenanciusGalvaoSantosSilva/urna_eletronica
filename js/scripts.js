document.addEventListener('DOMContentLoaded', () => {
    let numeroCandidato = "";
    let candidatoEncontrado = false; // Flag para verificar se o candidato foi encontrado

    document.addEventListener('keydown', function(event) {
        if (event.key === "F11" || event.key === "Escape") {
            event.preventDefault();
        }
    });
    
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });

    // Adiciona um listener para o clique em qualquer lugar da página
    document.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                document.documentElement.msRequestFullscreen();
            }
        }
    });
    
    // Adiciona eventos aos botões numéricos
    document.querySelectorAll('.numero').forEach(button => {
        button.addEventListener('click', function() {
            if (numeroCandidato.length < 2) { // Limita o número a 2 dígitos
                numeroCandidato += this.getAttribute('data-num');
                document.getElementById('numero-candidato').textContent = numeroCandidato;
                buscarCandidato(numeroCandidato);
                const som = document.getElementById('somClick');
                // Reproduz o som
                som.play();
                if (numeroCandidato.length === 2) {
                    // Adicione qualquer lógica adicional se necessário
                }
            }
        });
    });

    // Adiciona evento ao botão de CORRIGIR
    document.getElementById('corrigir').addEventListener('click', function() {
        numeroCandidato = "";
        candidatoEncontrado = false; // Reseta a flag ao corrigir
        document.getElementById('numero-candidato').textContent = "";
        document.getElementById('nome-candidato').textContent = "";
        document.getElementById('partido-candidato').textContent = "";
        document.getElementById('foto-candidato').style.display = 'none';
        document.getElementById('mensagem').textContent = "";
    });

    // Adiciona evento ao botão de BRANCO
    document.getElementById('branco').addEventListener('click', function() {
        const som = document.getElementById('somClick');
        // Reproduz o som
        som.play();

        setTimeout(() => {
            som.play();
        }, 1000);

        numeroCandidato = "Branco";
        candidatoEncontrado = true; // Define como encontrado
        document.getElementById('nome-candidato').textContent = "Voto em Branco";
        document.getElementById('numero-candidato').textContent = "Branco";
        document.getElementById('partido-candidato').textContent = "";
        document.getElementById('foto-candidato').style.display = 'none';
        document.getElementById('mensagem').textContent = "";
    });

    // Adiciona evento ao botão de CONFIRMAR
    document.getElementById('confirmar').addEventListener('click', function() {
        if (numeroCandidato) {
            if (candidatoEncontrado) {
                confirmarVoto(numeroCandidato);
            } else {
                // document.getElementById('mensagem').textContent = "Candidato não encontrado. O voto não será registrado.";
            }
        } else {
            // document.getElementById('mensagem').textContent = "Digite um número de candidato.";
        }
    });

    // Função para buscar dados do candidato
    function buscarCandidato(numero) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'buscar_candidato.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (numero === "00") {
                // Se o número for "00", exibe "Voto Nulo"
                document.getElementById('nome-candidato').textContent = "Voto Nulo";
                document.getElementById('partido-candidato').textContent = "";
                document.getElementById('foto-candidato').style.display = 'none';
                candidatoEncontrado = true; // Define como encontrado
            } else {
                const candidato = JSON.parse(this.responseText);
                if (numeroCandidato.length ===2) {
                    document.getElementById('nome-candidato').textContent = "Nome: " + candidato.nome;
                    document.getElementById('partido-candidato').textContent = "Partido: " + candidato.partido;
                    document.getElementById('foto-candidato').src = candidato.foto;
                    document.getElementById('foto-candidato').style.display = 'block';
                    candidatoEncontrado = true; // Define como encontrado
                } else {
                    document.getElementById('nome-candidato').textContent = "Candidato não encontrado";
                    document.getElementById('partido-candidato').textContent = "";
                    document.getElementById('foto-candidato').style.display = 'none';
                    candidatoEncontrado = false; // Define como não encontrado
                }
            }
        }
        xhr.send('numeroEleitoral=' + numero);
    }

    // Função para confirmar o voto
    function confirmarVoto(numero) {
        let votoTipo;

        if (numero === "Branco") {
            votoTipo = "branco";
        } else if (numero === "00") {
            votoTipo = "nulo";
        } else if (numero.length === 2 ) {
            votoTipo = "candidato";
        } else if (numero.length === 1 ) {
            votoTipo = "candidato";
        }else {
            votoTipo = "nulo";
        }

        // Bloqueia botões
        document.getElementById('corrigir').disabled = true;
        document.getElementById('branco').disabled = true;
        document.getElementById('confirmar').disabled = true;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'votar.php', true);

        const som = document.getElementById('somConfirma');
        // Reproduz o som
        som.play();

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            const mensagem = document.getElementById('mensagem');
            const nomeCandidato = document.getElementById('nome-candidato');
            const partidoCandidato = document.getElementById('partido-candidato');
            const fotoCandidato = document.getElementById('foto-candidato');
            const numeroCandidato = document.getElementById('numero-candidato');
            const imagemFim = document.getElementById('imagem-fim');

            if (this.responseText === '"Voto registrado com sucesso!"') {
                // Exibe a mensagem na tela da urna
                numeroCandidato.textContent = this.responseText;
                partidoCandidato.textContent = "";
                nomeCandidato.textContent = "";
                fotoCandidato.style.display = 'none'; // Oculta a foto
                mensagem.textContent = ""; // Limpa a mensagem

                // Limpa a tela da urna após 3 segundos
                setTimeout(() => {
                    imagemFim.style.display = 'block'; // Exibe a imagem
                    mensagem.textContent = ""; // Limpa a mensagem
                    numeroCandidato.textContent = "";
                    nomeCandidato.textContent = "";
                    partidoCandidato.textContent = "";
                    numeroCandidato = ""; // Reseta o número do candidato
                }, 3000); // Limpa após 3 segundos

                // Recarregar a página
                setTimeout(() => {
                    location.reload();
                }, 30000);
            } else {
                numeroCandidato.textContent = "";
                nomeCandidato.textContent = "";
                partidoCandidato.textContent = this.responseText;
                fotoCandidato.style.display = 'none';
                mensagem.textContent = "";
            }
        }
        xhr.send('numeroEleitoral=' + numero + '&votoTipo=' + votoTipo);
    }
});
