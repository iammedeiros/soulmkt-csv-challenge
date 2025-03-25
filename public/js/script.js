class ProductTableRenderer {
    static render(products) {
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
        
        products.forEach(product => {
            tableHtml += this.renderProductRow(product);
        });
        
        tableHtml += `</tbody></table>`;
        return tableHtml;
    }
}
