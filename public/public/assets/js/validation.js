/**
 * Validaciones del lado del cliente
 */

/**
 * Valida un email
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Valida una contraseña
 */
function validatePassword(password) {
    return password.length >= 6;
}

/**
 * Valida que dos contraseñas coincidan
 */
function validatePasswordMatch(password, passwordConfirm) {
    return password === passwordConfirm;
}

/**
 * Valida un formulario de registro
 */
function validateRegisterForm(formElement) {
    const username = formElement.querySelector('[name="username"]')?.value;
    const email = formElement.querySelector('[name="email"]')?.value;
    const password = formElement.querySelector('[name="password"]')?.value;
    const passwordConfirm = formElement.querySelector('[name="password_confirm"]')?.value;

    const errors = [];

    if (!username || username.length < 3) {
        errors.push('El nombre de usuario debe tener al menos 3 caracteres');
    }

    if (!email || !validateEmail(email)) {
        errors.push('Email inválido');
    }

    if (!password || !validatePassword(password)) {
        errors.push('La contraseña debe tener al menos 6 caracteres');
    }

    if (password !== passwordConfirm) {
        errors.push('Las contraseñas no coinciden');
    }

    return {
        valid: errors.length === 0,
        errors: errors
    };
}

/**
 * Valida un formulario de login
 */
function validateLoginForm(formElement) {
    const email = formElement.querySelector('[name="email"]')?.value;
    const password = formElement.querySelector('[name="password"]')?.value;

    const errors = [];

    if (!email || !validateEmail(email)) {
        errors.push('Email inválido');
    }

    if (!password) {
        errors.push('La contraseña es requerida');
    }

    return {
        valid: errors.length === 0,
        errors: errors
    };
}

/**
 * Valida un formulario de producto (admin)
 */
function validateProductForm(formElement) {
    const name = formElement.querySelector('[name="name"]')?.value;
    const price = formElement.querySelector('[name="price"]')?.value;
    const categoryId = formElement.querySelector('[name="category_id"]')?.value;

    const errors = [];

    if (!name || name.trim().length === 0) {
        errors.push('El nombre es requerido');
    }

    if (!price || parseFloat(price) <= 0) {
        errors.push('El precio debe ser mayor que 0');
    }

    if (!categoryId) {
        errors.push('Debes seleccionar una categoría');
    }

    return {
        valid: errors.length === 0,
        errors: errors
    };
}

/**
 * Valida un formulario de checkout
 */
function validateCheckoutForm(formElement) {
    const shippingAddress = formElement.querySelector('[name="shipping_address"]')?.value;
    const paymentMethod = formElement.querySelector('[name="payment_method"]')?.value;

    const errors = [];

    if (!shippingAddress || shippingAddress.trim().length === 0) {
        errors.push('La dirección de envío es requerida');
    }

    if (!paymentMethod) {
        errors.push('Debes seleccionar un método de pago');
    }

    return {
        valid: errors.length === 0,
        errors: errors
    };
}

/**
 * Muestra errores de validación en el formulario
 */
function showFormErrors(formElement, errors) {
    // Eliminar errores anteriores
    const previousErrors = formElement.querySelectorAll('.validation-error');
    previousErrors.forEach(error => error.remove());

    // Crear contenedor de errores
    const errorContainer = document.createElement('div');
    errorContainer.className = 'validation-error alert alert-error mb-4';
    errorContainer.innerHTML = '<ul class="list-disc list-inside">' + 
        errors.map(error => `<li>${error}</li>`).join('') + 
        '</ul>';

    // Insertar al principio del formulario
    formElement.insertBefore(errorContainer, formElement.firstChild);

    // Scroll al formulario
    formElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/**
 * Validación en tiempo real para inputs
 */
function setupRealtimeValidation() {
    // Email validation
    document.querySelectorAll('input[type="email"]').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && !validateEmail(this.value)) {
                this.classList.add('input-error');
                showInputError(this, 'Email inválido');
            } else {
                this.classList.remove('input-error');
                hideInputError(this);
            }
        });
    });

    // Password validation
    document.querySelectorAll('input[name="password"]').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value && !validatePassword(this.value)) {
                this.classList.add('input-error');
                showInputError(this, 'Mínimo 6 caracteres');
            } else {
                this.classList.remove('input-error');
                hideInputError(this);
            }
        });
    });

    // Password confirmation
    const passwordInput = document.querySelector('input[name="password"]');
    const passwordConfirmInput = document.querySelector('input[name="password_confirm"]');
    
    if (passwordInput && passwordConfirmInput) {
        passwordConfirmInput.addEventListener('input', function() {
            if (this.value && !validatePasswordMatch(passwordInput.value, this.value)) {
                this.classList.add('input-error');
                showInputError(this, 'Las contraseñas no coinciden');
            } else {
                this.classList.remove('input-error');
                hideInputError(this);
            }
        });
    }
}

/**
 * Muestra un error específico para un input
 */
function showInputError(inputElement, message) {
    hideInputError(inputElement);
    
    const errorSpan = document.createElement('span');
    errorSpan.className = 'text-error text-sm mt-1 input-error-message';
    errorSpan.textContent = message;
    
    inputElement.parentElement.appendChild(errorSpan);
}

/**
 * Oculta el error de un input
 */
function hideInputError(inputElement) {
    const errorMessage = inputElement.parentElement.querySelector('.input-error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

/**
 * Inicializar validaciones al cargar la página
 */
document.addEventListener('DOMContentLoaded', function() {
    setupRealtimeValidation();

    // Validar formulario de registro si existe
    const registerForm = document.querySelector('form[action="/register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const validation = validateRegisterForm(this);
            if (!validation.valid) {
                e.preventDefault();
                showFormErrors(this, validation.errors);
            }
        });
    }

    // Validar formulario de login si existe
    const loginForm = document.querySelector('form[action="/login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const validation = validateLoginForm(this);
            if (!validation.valid) {
                e.preventDefault();
                showFormErrors(this, validation.errors);
            }
        });
    }

    // Validar formulario de checkout si existe
    const checkoutForm = document.querySelector('form[action="/orders/process"]');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            const validation = validateCheckoutForm(this);
            if (!validation.valid) {
                e.preventDefault();
                showFormErrors(this, validation.errors);
            }
        });
    }
});