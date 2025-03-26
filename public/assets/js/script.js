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
                <td>${product.price.toFixed( 2 )}</td>
                <td>${actionButton}</td>
            </tr>
        `;
    }

    static copyToClipboard( productData ) {
        try {
            const product = JSON.parse( productData );
            navigator.clipboard.writeText( JSON.stringify( product, null, 2 ) )
                .then( () => showMessage('Copiado para área de transferência!', 'success' ) )
                .catch( err => console.error( 'Erro ao copiar:', err ) );
        } catch ( e ) {
            console.error( 'Erro ao parsear JSON:', e );
        }
    }

    static initCopyButtons() {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('copy-json-btn')) {
                const productData = e.target.getAttribute('data-product');
                ProductTableRenderer.copyToClipboard(productData);
            }
        });
    }
}

const showMessage = function(message, type = 'error') {
    const messageContainer = document.querySelector('#message-container');
    
    messageContainer.innerHTML = `
        <div class="status-message ${type}-message">
            ${message}
        </div>
    `;
    
    setTimeout(() => {
        messageContainer.innerHTML = '';
    }, 5000);
}


$( document ).ready( function () {
    $( '#upload-form' ).on( 'submit', function ( e ) {
        e.preventDefault();

        const formData = new FormData( this );
        formData.append( 'action', 'upload' );

        $.ajax( {
            url: '/index.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function ( response ) {
                console.log(response);
                $( '#product-table-container' ).html( ProductTableRenderer.render( response ) );
                ProductTableRenderer.initCopyButtons();
                showMessage('Arquivo processado com sucesso!', 'success');
            },
            error: function ( reject ) {
                showMessage(JSON.parse(reject.responseText).error, 'error');
            }
        } );
    } );
} );