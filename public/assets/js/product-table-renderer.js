class ProductTableRenderer {
    static render( products ) {
        let tableHtml = `
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Preço</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
        `;

        products.forEach( product => {
            tableHtml += this.renderProductRow( product );
        } );

        tableHtml += `</tbody></table>`;
        return tableHtml;
    }

    static renderProductRow( product ) {
        const rowClass = product.hasNegativePrice ? 'negative-price' : '';
        const productJSON = JSON.stringify( product );

        const actionButton = product.hasEvenNumberInCode
            ? `<button class="copy-json-btn" data-product='${productJSON}'>
                  Copiar JSON
               </button>`
            : '';

        return `
            <tr class="${rowClass}">
                <td>${product.name}</td>
                <td>${product.code}</td>
                <td>${product.price.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</td>
                <td>${actionButton}</td>
            </tr>
        `;
    }

    static copyToClipboard( productData ) {
        try {
            const product = JSON.parse( productData );
            navigator.clipboard.writeText( JSON.stringify( product, null, 2 ) )
                .then( () => alert('Copiado para a área de transferência.'))
                .catch( err => console.error( 'Erro ao copiar:', err ) );
        } catch ( e ) {
            console.error( 'Erro ao parsear JSON:', e );
        }
    }

    static initCopyButtons() {
        document.removeEventListener('click', ProductTableRenderer.copyButtonHandler);
        document.addEventListener('click', ProductTableRenderer.copyButtonHandler);
    }
    
    static copyButtonHandler(e) {
        if (e.target.classList.contains('copy-json-btn')) {
            const productData = e.target.getAttribute('data-product');
            ProductTableRenderer.copyToClipboard(productData);
        }
    }
}