
document.addEventListener('DOMContentLoaded', function() {
    // Toggle input visibility for all fields
    document.querySelectorAll('.form-check-input-adv-search[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const inputId = this.id.replace('Checkbox', 'Input');
            const inputElement = document.getElementById(inputId);
            const inputGroupElement = document.getElementById(
                `${this.id.replace('Checkbox', 'InputGroup')}`);

            if (this.checked) {
                if (inputElement) {
                    inputElement.classList.remove('d-none');
                    inputElement.removeAttribute('disabled');
                }
                if (inputGroupElement) {
                    inputGroupElement.classList.remove('d-none');
                    inputGroupElement.querySelectorAll('input').forEach(input => input
                        .removeAttribute('disabled'));
                }
            } else {
                if (inputElement) {
                    inputElement.classList.add('d-none');
                    inputElement.setAttribute('disabled', 'disabled');
                }
                if (inputGroupElement) {
                    inputGroupElement.classList.add('d-none');
                    inputGroupElement.querySelectorAll('input').forEach(input => input
                        .setAttribute('disabled', 'disabled'));
                }
            }
        });
    });

    // Reset Filters
    document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = window.location.pathname; // Reset to the original URL
    });
});
