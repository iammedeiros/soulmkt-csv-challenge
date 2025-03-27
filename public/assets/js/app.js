const showMessage = function ( message, type = 'error' ) {
    const messageContainer = document.querySelector( '#message-container' );

    messageContainer.innerHTML = `
        <div class="status-message ${type}-message">
            ${message}
        </div>
    `;

    setTimeout( () => {
        messageContainer.innerHTML = '';
    }, 10000 );
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
                $( '#product-table-container' ).html( ProductTableRenderer.render( response ) );
                ProductTableRenderer.initCopyButtons();
                showMessage( 'Arquivo processado com sucesso!', 'success' );
            },
            error: function ( reject ) {
                showMessage( JSON.parse( reject.responseText ).error, 'error' );
            }
        } );
    } );
} );