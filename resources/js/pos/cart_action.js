import { addToCart, renderCart, clearCart } from './cart_renderer.js';
const EXCHANGE_RATE = 4000;

document.addEventListener('DOMContentLoaded', () => {
    setInterval(() => {
        const clockEl = document.getElementById('pos-clock');
        if (clockEl) clockEl.innerText = new Date().toLocaleTimeString();
    }, 1000);

    document.querySelectorAll('.product-item').forEach(item => {
        item.addEventListener('click', (e) => {
            const targetCard = e.currentTarget;
            const id = targetCard.getAttribute('data-id');
            const name = targetCard.getAttribute('data-name');
            const price = parseFloat(targetCard.getAttribute('data-price')) || 0;
            const unitId = targetCard.getAttribute('data-unit-id') || 1;
            const unitSymbol = targetCard.getAttribute('data-unit-symbol') || 'unit';

            addToCart(id, name, price, EXCHANGE_RATE, unitId, unitSymbol);
        });
    });

    document.getElementById('btnClearCart')?.addEventListener('click', () => {
        clearCart(EXCHANGE_RATE);
    });

    document.getElementById('discountInput')?.addEventListener('input', () => renderCart(EXCHANGE_RATE));
    document.getElementById('searchInput')?.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            item.style.display = name.includes(term) ? 'block' : 'none';
        });
    });

    document.querySelectorAll('.category-filter').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const categoryId = e.target.value;
            document.querySelectorAll('.product-item').forEach(item => {
                const itemCategory = item.getAttribute('data-category-id');
                if (categoryId === "" || itemCategory === categoryId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    document.getElementById('btnPay')?.addEventListener('click', () => {
        calculatePaymentTotals();
        document.getElementById('paymentModal')?.classList.remove('hidden');
        document.getElementById('paymentModal')?.classList.add('flex');
    });

    document.getElementById('closePaymentModal')?.addEventListener('click', closePaymentModal);
    document.getElementById('cancelPayment')?.addEventListener('click', closePaymentModal);

    document.querySelectorAll('.discount-type').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.discount-type').forEach(b => {
                b.classList.remove('main-bg', 'text-white');
                b.classList.add('border');
            });
            btn.classList.add('main-bg', 'text-white');
            btn.classList.remove('border');

            currentDiscountType = btn.getAttribute('data-type');
            const discountTypeInput = document.getElementById('discountType');
            if (discountTypeInput) discountTypeInput.value = currentDiscountType;
            calculatePaymentTotals();
        });
    });

    document.querySelectorAll('.discount-preset').forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.getAttribute('data-type');
            const val = parseFloat(btn.getAttribute('data-value')) || 0;
            const discountValInput = document.getElementById('discountValue');
            if (discountValInput) discountValInput.value = val.toFixed(3);

            if (type === 'percent') {
                document.querySelector('[data-type="percent"].discount-type')?.click();
            } else {
                document.querySelector('[data-type="amount"].discount-type')?.click();
            }
            calculatePaymentTotals();
        });
    });

    document.getElementById('discountValue')?.addEventListener('input', calculatePaymentTotals);

    document.querySelectorAll('.receive-currency').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.receive-currency').forEach(b => {
                b.classList.remove('main-bg', 'text-white');
                b.classList.add('border');
            });
            btn.classList.add('main-bg', 'text-white');
            btn.classList.remove('border');

            currentReceiveCurrency = btn.getAttribute('data-currency');
            const receiveCurrInput = document.getElementById('receiveCurrency');
            if (receiveCurrInput) receiveCurrInput.value = currentReceiveCurrency;

            const receivedInput = document.getElementById('receivedAmount');
            if (receivedInput) {
                receivedInput.value = '';
                receivedInput.placeholder = currentReceiveCurrency === 'USD' ? '0.000' : '0';
            }
            calculatePaymentTotals();
        });
    });

    document.querySelectorAll('.payment-method').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.payment-method').forEach(b => {
                b.classList.remove('main-bg', 'text-white');
                b.classList.add('border');
            });
            btn.classList.add('main-bg', 'text-white');
            btn.classList.remove('border');

            currentPaymentMethod = btn.getAttribute('data-method');
            const paymentMethodInput = document.getElementById('paymentMethod');
            if (paymentMethodInput) paymentMethodInput.value = currentPaymentMethod;
        });
    });

    document.getElementById('receivedAmount')?.addEventListener('input', calculatePaymentTotals);
});

let currentDiscountType = 'amount';
let currentReceiveCurrency = 'USD';
let currentPaymentMethod = 'cash';

function closePaymentModal() {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
}

function calculatePaymentTotals() {
    let subtotal = window.cart ? window.cart.reduce((sum, i) => sum + (i.price * i.qty), 0) : 0;
    const discInputEl = document.getElementById('discountValue');
    let discInput = discInputEl ? parseFloat(discInputEl.value) || 0 : 0;

    let discountAmount = 0;
    if (currentDiscountType === 'percent') {
        discountAmount = subtotal * (discInput / 100);
    } else {
        discountAmount = discInput;
    }

    let totalUSD = Math.max(0, subtotal - discountAmount);
    let totalKHR = totalUSD * EXCHANGE_RATE;

    const discDisplay = document.getElementById('discountDisplay');
    const payTotal = document.getElementById('paymentTotal');
    const payTotalKHR = document.getElementById('paymentTotalKHR');

    if (discDisplay) discDisplay.innerText = `$${discountAmount.toFixed(3)}`;
    if (payTotal) payTotal.innerText = `$${totalUSD.toFixed(3)}`;
    if (payTotalKHR) payTotalKHR.innerText = `៛${totalKHR.toLocaleString()}`;

    const receivedInputEl = document.getElementById('receivedAmount');
    let receivedInput = receivedInputEl ? parseFloat(receivedInputEl.value) || 0 : 0;
    let receivedUSD = currentReceiveCurrency === 'USD' ? receivedInput : receivedInput / EXCHANGE_RATE;

    let changeUSD = Math.max(0, receivedUSD - totalUSD);
    let changeKHR = changeUSD * EXCHANGE_RATE;

    const recDisp = document.getElementById('receivedDisplay');
    const chgAmt = document.getElementById('changeAmount');
    const chgAmtKHR = document.getElementById('changeAmountKHR');

    if (recDisp) {
        recDisp.innerText = currentReceiveCurrency === 'USD' ?
            `៛${(receivedUSD * EXCHANGE_RATE).toLocaleString()}` :
            `$${receivedUSD.toFixed(3)}`;
    }
    if (chgAmt) chgAmt.innerText = `$${changeUSD.toFixed(3)}`;
    if (chgAmtKHR) chgAmtKHR.innerText = `៛${changeKHR.toLocaleString()}`;
}

document.getElementById('btnCloseSuccessModal')?.addEventListener('click', () => {
    const successModal = document.getElementById('successModal');
    if (successModal) {
        successModal.classList.remove('flex');
        successModal.classList.add('hidden');
    }
});
