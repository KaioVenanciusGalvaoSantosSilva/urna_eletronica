document.getElementById('file-input').addEventListener('change', function() {
    var fileInput = document.getElementById('file-input');
    var fileName = fileInput.files[0].name;
    var filePath = '/img/' + fileName;
    document.getElementById('foto').value = filePath;
});

document.getElementById('numero').addEventListener('input', function() {
    var input = this.value;
    // Remove caracteres não numéricos
    var validNumber = input.replace(/[^0-9]/g, '');
    // Atualiza o campo com o valor válido
    this.value = validNumber;
});
