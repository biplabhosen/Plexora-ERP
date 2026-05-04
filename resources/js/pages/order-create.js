import Cart from '../cart';

const orderForm = document.querySelector('#orderForm');

if (orderForm) {
    const cart = new Cart('plexora-order-cart');
    const orderItemsTable = document.querySelector('#orderItemsTable tbody');
    const addOrderRow = document.querySelector('#addOrderRow');
    const draftProduct = document.querySelector('#draftProduct');
    const draftQuantity = document.querySelector('#draftQuantity');
    const draftDiscount = document.querySelector('#draftDiscount');
    const draftUnitPrice = document.querySelector('#draftUnitPrice');
    const draftLineTotal = document.querySelector('#draftLineTotal');
    const subtotalDisplay = document.querySelector('#subtotalDisplay');
    const itemDiscountDisplay = document.querySelector('#itemDiscountDisplay');
    const grandTotalDisplay = document.querySelector('#grandTotalDisplay');
    const orderDiscount = document.querySelector('#discount');

    function money(value) {
        return Number(value || 0).toFixed(2);
    }

    function selectedDraftProduct() {
        return draftProduct.options[draftProduct.selectedIndex];
    }

    function draftValues() {
        const option = selectedDraftProduct();
        const productId = draftProduct.value;
        const quantity = Math.max(1, Number(draftQuantity.value || 1));
        const price = productId ? Number(option.dataset.price || 0) : 0;
        const lineSubtotal = price * quantity;
        const discount = Math.min(Math.max(0, Number(draftDiscount.value || 0)), lineSubtotal);

        return {
            id: productId,
            productName: option?.dataset.name || '',
            sku: option?.dataset.sku || '',
            qty: quantity,
            price,
            discount,
        };
    }

    function updateDraftTotals() {
        const values = draftValues();
        draftUnitPrice.textContent = money(values.price);
        draftLineTotal.textContent = money((values.price * values.qty) - values.discount);
    }

    function renderCart() {
        orderItemsTable.querySelectorAll('.order-item-row').forEach((row) => row.remove());

        cart.getData().forEach((item) => {
            const lineTotal = Math.max(0, (Number(item.price) * Number(item.qty)) - Number(item.discount || 0));
            const row = document.createElement('tr');

            row.className = 'order-item-row';
            row.dataset.productId = item.id;
            row.dataset.price = item.price;
            row.dataset.quantity = item.qty;
            row.dataset.discount = item.discount || 0;
            row.innerHTML = `
                <td class="item-number"></td>
                <td>
                    <span class="fw-semibold"></span>
                    <span class="text-muted small d-block"></span>
                    <input type="hidden" data-name="product_id" value="${item.id}">
                </td>
                <td class="text-end">
                    ${item.qty}
                    <input type="hidden" data-name="quantity" value="${item.qty}">
                </td>
                <td class="text-end">${money(item.price)}</td>
                <td class="text-end">
                    ${money(item.discount)}
                    <input type="hidden" data-name="discount" value="${item.discount || 0}">
                </td>
                <td class="text-end fw-semibold">${money(lineTotal)}</td>
                <td class="text-end">
                    <button type="button" class="btn btn-outline-danger remove-order-row">Remove</button>
                </td>
            `;

            row.querySelector('.fw-semibold').textContent = item.productName;
            row.querySelector('.text-muted').textContent = item.sku;
            orderItemsTable.appendChild(row);
        });

        renameOrderRows();
        updateTotals();
    }

    function hydrateServerRows() {
        const items = Array.from(orderItemsTable.querySelectorAll('.order-item-row')).map((row) => ({
            id: row.dataset.productId,
            productName: row.dataset.productName,
            sku: row.dataset.productSku,
            qty: Number(row.dataset.quantity || 1),
            price: Number(row.dataset.price || 0),
            discount: Number(row.dataset.discount || 0),
        }));

        if (items.length > 0) {
            cart.setData(items);
        }
    }

    function addDraftRow() {
        const values = draftValues();

        if (! values.id) {
            draftProduct.focus();
            return false;
        }

        cart.addItem(values);
        draftProduct.value = '';
        draftQuantity.value = 1;
        draftDiscount.value = 0;
        updateDraftTotals();
        renderCart();

        return true;
    }

    function renameOrderRows() {
        orderItemsTable.querySelectorAll('.order-item-row').forEach((row, index) => {
            row.querySelector('.item-number').textContent = index + 1;
            row.querySelectorAll('[data-name]').forEach((input) => {
                input.name = `items[${index}][${input.dataset.name}]`;
            });
        });
    }

    function updateTotals() {
        let subtotal = 0;
        let lineDiscount = 0;

        cart.getData().forEach((item) => {
            subtotal += Number(item.price || 0) * Number(item.qty || 0);
            lineDiscount += Number(item.discount || 0);
        });

        const additionalDiscount = Math.max(0, Number(orderDiscount.value || 0));
        const grandTotal = Math.max(0, subtotal - lineDiscount - additionalDiscount);

        subtotalDisplay.textContent = money(subtotal);
        itemDiscountDisplay.textContent = money(lineDiscount);
        grandTotalDisplay.textContent = money(grandTotal);
    }

    addOrderRow.addEventListener('click', addDraftRow);
    draftProduct.addEventListener('change', updateDraftTotals);
    draftQuantity.addEventListener('input', updateDraftTotals);
    draftDiscount.addEventListener('input', updateDraftTotals);
    orderDiscount.addEventListener('input', updateTotals);

    orderItemsTable.addEventListener('click', (event) => {
        const button = event.target.closest('.remove-order-row');

        if (! button) {
            return;
        }

        cart.delItem(button.closest('.order-item-row').dataset.productId);
        renderCart();
    });

    orderForm.addEventListener('submit', (event) => {
        if (cart.getData().length === 0 && draftProduct.value) {
            addDraftRow();
        }

        if (cart.getData().length === 0) {
            event.preventDefault();
            draftProduct.focus();
        }
    });

    hydrateServerRows();
    renderCart();
    updateDraftTotals();
}
