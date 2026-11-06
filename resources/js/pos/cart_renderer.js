export let cart = [];
window.updateQty = updateQty;
window.removeFromCart = removeFromCart;
window.updateItemPrice = updateItemPrice;
window.setExactQty = setExactQty;

export function addToCart(id, name, price, EXCHANGE_RATE, unitId = 1, unitSymbol = 'unit') {
    const existing = cart.find(i => i.id === id);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id, name, price, qty: 1, unit_id: unitId, unit_symbol: unitSymbol });
    }
    window.cart = cart;
    renderCart(EXCHANGE_RATE);
}

export function updateQty(id, delta, EXCHANGE_RATE = 4000) {
    const item = cart.find(i => i.id === id);
    if (item) {
        item.qty += delta;
        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        }
    }
    window.cart = cart;
    renderCart(EXCHANGE_RATE);
}

export function removeFromCart(id, EXCHANGE_RATE = 4000) {
    cart = cart.filter(i => i.id !== id);
    window.cart = cart;
    renderCart(EXCHANGE_RATE);
}

export function updateItemPrice(id, newPrice, EXCHANGE_RATE = 4000) {
    const item = cart.find(i => i.id === id);
    if (item) {
        const parsedPrice = parseFloat(newPrice);
        item.price = isNaN(parsedPrice) || parsedPrice < 0 ? 0 : parsedPrice;
        window.cart = cart;
        renderCart(EXCHANGE_RATE);
    }
}

export function setExactQty(id, newQty, EXCHANGE_RATE = 4000) {
    const item = cart.find(i => i.id === id);
    if (item) {
        const parsedQty = parseInt(newQty);
        if (isNaN(parsedQty) || parsedQty <= 0) {
            cart = cart.filter(i => i.id !== id);
        } else {
            item.qty = parsedQty;
        }
        window.cart = cart;
        renderCart(EXCHANGE_RATE);
    }
}

export function clearCart(EXCHANGE_RATE = 4000) {
    cart = [];
    window.cart = cart;
    renderCart(EXCHANGE_RATE);
}

export function renderCart(EXCHANGE_RATE = 4000) {
    const tbody = document.getElementById('cartBody');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (cart.length === 0) {
        tbody.innerHTML = `
            <tr id="emptyCartRow">
                <td colspan="5" class="text-center text-muted py-4">
                    <i class="bi bi-basket fs-3 d-block mb-1"></i>
                    មិនមានទំនិញក្នុងកន្ទ្រក់នៅឡើយ
                </td>
            </tr>`;
        const btnPay = document.getElementById('btnPay');
        if (btnPay) btnPay.disabled = true;
        updateTotals(0, EXCHANGE_RATE);
        return;
    }

    const btnPay = document.getElementById('btnPay');
    if (btnPay) btnPay.disabled = false;
    let subtotal = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.qty;
        subtotal += itemTotal;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="py-2 align-middle">
                <span class="fw-semibold text-success text-truncate d-block" style="max-width: 150px;" title="${item.name}">
                    ${item.name} (${item.unit_symbol || 'unit'})
                </span>
            </td>
            <td class="text-center align-middle">
                <div class="d-inline-flex align-items-center border rounded-2 overflow-hidden bg-white">
                    <button type="button" class="btn btn-light btn-sm border-0 rounded-0 px-1 qty-btn" onclick="updateQty('${item.id}', -1)"><i class="bi bi-dash"></i></button>
                    <input type="number" class="form-control form-control-sm text-center border-0 p-0 fw-bold shadow-none" style="width: 35px; background: transparent;" value="${item.qty}" min="1" onchange="setExactQty('${item.id}', this.value)">
                    <button type="button" class="btn btn-light btn-sm border-0 rounded-0 px-1 qty-btn" onclick="updateQty('${item.id}', 1)"><i class="bi bi-plus"></i></button>
                </div>
            </td>
            <td class="text-end align-middle">
                <div class="input-group input-group-sm ms-auto" style="width: 95px;">
                    <span class="input-group-text px-1">$</span>
                    <input type="number" class="form-control form-control-sm px-1 text-end" 
                           value="${item.price.toFixed(2)}" step="0.01" min="0" 
                           onchange="updateItemPrice('${item.id}', this.value)">
                </div>
            </td>
            <td class="text-end align-middle fw-bold text-dark">
                $${itemTotal.toFixed(2)}
            </td>
            <td class="text-end align-middle">
                <button type="button" class="btn btn-sm btn-light text-danger border-0 rounded-circle" style="width: 28px; height: 28px;" onclick="removeFromCart('${item.id}')" title="Remove">
                    <i class="bi bi-trash3"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    updateTotals(subtotal, EXCHANGE_RATE);
}

export function updateTotals(subtotal, EXCHANGE_RATE = 4000) {
    const discountInput = document.getElementById('discountInput');
    const discount = discountInput ? parseFloat(discountInput.value) || 0 : 0;
    const total = Math.max(0, subtotal - discount);
    const totalKHR = total * EXCHANGE_RATE;

    const subEl = document.getElementById('subtotalAmount');
    const totUSD = document.getElementById('totalUSD');
    const totKHR = document.getElementById('totalKHR');

    if (subEl) subEl.innerText = `$${subtotal.toFixed(2)}`;
    if (totUSD) totUSD.innerText = `$${total.toFixed(2)}`;
    if (totKHR) totKHR.innerText = `${totalKHR.toLocaleString()} ៛`;
}