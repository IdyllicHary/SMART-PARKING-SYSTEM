function showSuccess(message) {
    Swal.fire({
        title: 'Success!',
        text: message,
        showConfirmButton: false,
        timer: 2500,
        customClass: {
            popup: 'animated bounceIn',
            icon: 'no-border'
        },
        background: '#fff',
        html: `
            <div class="success-checkmark">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                </div>
            </div>
            <div class="swal2-text">${message}</div>
        `,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    });
}

function showError(message) {
    Swal.fire({
        title: 'Error!',
        text: message,
        showConfirmButton: false,
        timer: 2500,
        customClass: {
            popup: 'animated shake',
            icon: 'no-border'
        },
        background: '#fff',
        html: `
            <div class="error-x">
                <div class="x-icon">
                    <span class="x-line-1"></span>
                    <span class="x-line-2"></span>
                </div>
            </div>
            <div class="swal2-text">${message}</div>
        `,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    });
}
