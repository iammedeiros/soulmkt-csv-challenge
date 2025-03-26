<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Processador de Produtos</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/script.js"></script>
</head>
<body>
    <div class="container">
        <h1>Upload de Planilha de Produtos</h1>

        <div id="message-container"></div>
        
        <form id="upload-form">
            <div class="form-group">
                <label for="csv_file">Arquivo CSV:</label>
                <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
            </div>
            
            <div class="form-group delimiter-options">
                <label>Delimitador:</label>
                <label><input type="radio" name="delimiter" value="," checked> Vírgula (,)</label>
                <label><input type="radio" name="delimiter" value=";"> Ponto e vírgula (;)</label>
            </div>
            
            <button class="btn-submit" type="submit">Processar Dados</button>
        </form>
        
        <div id="product-table-container"></div>
    </div>
</body>
</html>