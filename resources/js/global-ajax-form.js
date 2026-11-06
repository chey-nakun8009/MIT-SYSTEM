console.log('load global-ajax-form.js');

document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!form.classList.contains('ajax-form')) return;
    e.preventDefault();
    const submitBtn = form.querySelector('[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    form.querySelectorAll('.invalid-feedback').forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
    });
    form.querySelectorAll('.text-danger').forEach(label => {
        label.classList.remove('text-danger');
    });

    const formData = new FormData(form);
    form.querySelectorAll('select[multiple]').forEach(select => {
        formData.delete(select.name);
        formData.delete(select.name + '[]');
        const fieldName = select.name.endsWith('[]') ? select.name : select.name + '[]';
        Array.from(select.options).forEach(option => {
            if (option.selected) {
                formData.append(fieldName, option.value);
            }
        });
    });
    form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        formData.set(checkbox.name, checkbox.checked ? '1' : '0');
    });

    let fetchUrl = form.action;
    let fetchMethod = form.method || 'POST';

    fetch(fetchUrl, {
        method: fetchMethod,
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                if (typeof Toast !== 'undefined') {
                    Toast.error(data.message || 'An unexpected error occurred.');
                } else {
                    alert(data.message || 'An unexpected error occurred.');
                }
                if (response.status === 422 && data.errors) {
                    handleValidationErrors(form, data.errors);
                }

                if (submitBtn) submitBtn.disabled = false;
                return;
            }
            if (data.status === 'error') {
                if (typeof Toast !== 'undefined') {
                    Toast.error(data.message || 'Please check the form for validation errors.');
                } else {
                    alert(data.message || 'Please check the form for validation errors.');
                }
                if (data.errors) {
                    handleValidationErrors(form, data.errors);
                }
                if (submitBtn) submitBtn.disabled = false;
                return;
            }
            if (data.status === 'success' || response.ok) {
                if (typeof Toast !== 'undefined') {
                    Toast.success(data.message || 'Operation successful!');
                } else {
                    alert(data.message || 'Operation successful!');
                }
                setTimeout(() => {
                    window.location.href = data.redirect || window.location.href;
                }, 800);
            }
        })
        .catch(error => {
            // console.error('AJAX Form Error:', error);
            if (typeof Toast !== 'undefined') {
                Toast.error('A network error occurred.');
            }
            if (submitBtn) submitBtn.disabled = false;
        });
});
function handleValidationErrors(form, errors) {
    for (const [field, messages] of Object.entries(errors)) {
        const input = form.querySelector(`[name="${field}"]`) || form.querySelector(`[name="${field}[]"]`);
        if (input) {
            input.classList.add('is-invalid');
            const container = input.closest('.mb-3') || input.parentElement;
            let feedback = container.querySelector('.invalid-feedback');

            if (feedback) {
                feedback.textContent = messages[0];
                feedback.style.display = 'block';
            } else {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback d-block';
                feedback.textContent = messages[0];
                container.appendChild(feedback);
            }
        }
    }
}