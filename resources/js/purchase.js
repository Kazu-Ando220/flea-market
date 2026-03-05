document.addEventListener('DOMContentLoaded', function () {
    const paymentSelect = document.querySelector('.js-payment-select');
    const paymentDisplay = document.querySelector('.js-payment-display');
    const changeLink = document.querySelector('.link-change');

    if (!paymentSelect || !paymentDisplay) return;

    function updatePaymentDisplay() {
        paymentDisplay.textContent = paymentSelect.value || '';
    }

    paymentSelect.addEventListener('change', updatePaymentDisplay);
    updatePaymentDisplay();

    if (!changeLink) return;

    changeLink.addEventListener('click', () => {
        const paymentMethod = paymentSelect.value;

        if (!paymentMethod) return;

        const url = new URL(changeLink.href);
        url.searchParams.set('payment_method', paymentMethod);
        changeLink.href = url.toString();

    });
});