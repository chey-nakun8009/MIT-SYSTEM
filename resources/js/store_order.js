document.addEventListener('DOMContentLoaded', () => {
    const confirmBtn = document.getElementById('completeOrder') || document.getElementById('btnConfirmPay');

    if (confirmBtn) {
        confirmBtn.addEventListener('click', async () => {
            console.log('success loaded pos.js checkout handler');

            const activeCart = window.cart || [];

            if (activeCart.length === 0) {
                alert('Cart is empty. Please add items before checking out.');
                return;
            }

            const payload = {
                customer_id: document.getElementById('customerSelect')?.value || 'walkin',
                discount_type: document.getElementById('discountType')?.value || 'amount',
                discount_value: parseFloat(document.getElementById('discountValue')?.value) || 0,
                cart_discount: parseFloat(document.getElementById('discountInput')?.value) || 0,
                receive_currency: document.getElementById('receiveCurrency')?.value || 'USD',
                received_amount: parseFloat(document.getElementById('receivedAmount')?.value) || 0,
                payment_method: document.getElementById('paymentMethod')?.value || 'cash',
                items: activeCart.map(item => ({
                    id: item.id,
                    qty: item.qty,
                    price: item.price,
                    unit_id: item.unit_id
                }))
            };

            try {
                const response = await fetch('/api/pos/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.success) {
                    const modalEl = document.getElementById('paymentModal');
                    if (modalEl) {
                        modalEl.classList.remove('flex');
                        modalEl.classList.add('hidden');
                    }

                    // Extract order details and precisely calculate/format change values
                    const orderNum = result.order?.order_number || result.order_number || '';
                    const changeUSD = parseFloat(result.order?.change_usd ?? result.change_usd ?? 0);

                    let changeKHR = parseFloat(result.order?.change_khr ?? result.change_khr ?? 0);
                    if (!changeKHR || changeKHR === 0) {
                        const receiveCurrency = document.getElementById('receiveCurrency')?.value || 'USD';
                        const receivedAmt = parseFloat(document.getElementById('receivedAmount')?.value) || 0;

                        if (receiveCurrency === 'KHR') {
                            const totalUSD = parseFloat(result.order?.grand_total ?? result.order?.total ?? 0);
                            const receivedUSD = receivedAmt / 4000;
                            changeKHR = Math.max(0, (receivedUSD - totalUSD) * 4000);
                        } else {
                            changeKHR = changeUSD * 4000;
                        }
                    }

                    // Populate Success Modal fields
                    const invEl = document.getElementById('successInvoiceNo');
                    const chgUsdEl = document.getElementById('successChangeUSD');
                    const chgKhrEl = document.getElementById('successChangeKHR');

                    if (invEl) invEl.innerText = orderNum;
                    if (chgUsdEl) chgUsdEl.innerText = `$${changeUSD.toFixed(3)}`;
                    if (chgKhrEl) chgKhrEl.innerText = `៛${Math.round(changeKHR).toLocaleString()}`;

                    const successModal = document.getElementById('successModal');
                    if (successModal) {
                        successModal.classList.remove('hidden');
                        successModal.classList.add('flex');
                    }

                    const printBtn = document.getElementById('btnPrintReceipt');
                    if (printBtn && result.order?.id) {
                        printBtn.onclick = () => {
                            window.open(`/pos/receipt/${result.order.id}`, '_blank');
                            window.location.href = '/pos';
                        };
                    }

                    const closeSuccessBtn = document.getElementById('btnCloseSuccessModal');
                    if (closeSuccessBtn) {
                        closeSuccessBtn.onclick = () => {
                            window.location.href = '/pos';
                        };
                    }

                    if (typeof window.clearCart === 'function') {
                        window.clearCart(4000);
                    } else {
                        window.cart = [];
                        if (typeof window.renderCart === 'function') {
                            window.renderCart(4000);
                        }
                    }

                    const discountInput = document.getElementById('discountInput');
                    if (discountInput) discountInput.value = '0';

                    const receivedAmount = document.getElementById('receivedAmount');
                    if (receivedAmount) receivedAmount.value = '';

                    const discountValue = document.getElementById('discountValue');
                    if (discountValue) discountValue.value = '0.000';

                } else {
                    alert('Error processing order: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Checkout error:', error);
                alert('An error occurred while processing the checkout.');
            }
        });
    }
});