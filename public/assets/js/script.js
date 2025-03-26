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
        const actionButton = product.hasEvenNumberInCode
            ? `<button onclick="ProductTableRenderer.copyToClipboard(${JSON.stringify( product )})">Copiar JSON</button>`
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
        navigator.clipboard.writeText( JSON.stringify( productData, null, 2 ) )
            .then( () => alert( 'Copiado para área de transferência!' ) )
            .catch( err => console.error( 'Erro ao copiar:', err ) );
    }
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
                $( '#product-table-container' ).html(ProductTableRenderer.render( response ) );
            },
            error: function ( xhr ) {
                alert( xhr.responseJSON?.error || 'Erro ao processar arquivo' );
            }
        } );
    } );
} );