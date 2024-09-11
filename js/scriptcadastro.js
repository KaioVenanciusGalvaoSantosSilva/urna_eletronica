// Para a foto do candidato
document.getElementById('file-input').addEventListener('change', function() {
    var fileInput = document.getElementById('file-input');
    var fileName = fileInput.files[0].name;
    var filePath = '/img/' + fileName;
    document.getElementById('foto').value = filePath;
});

// Para a foto do vice
document.getElementById('file-input-vice').addEventListener('change', function() {
    var fileInputVice = document.getElementById('file-input-vice');
    var fileNameVice = fileInputVice.files[0].name;
    var filePathVice = '/img/' + fileNameVice;
    document.getElementById('foto-vice').value = filePathVice;
});

// Para o número eleitoral (somente números)
document.getElementById('numero').addEventListener('input', function() {
    var input = this.value;
    // Remove caracteres não numéricos
    var validNumber = input.replace(/[^0-9]/g, '');
    // Atualiza o campo com o valor válido
    this.value = validNumber;
});
