import { validatePassword, validateEmail } from './validate.js';

const setStatusInput = (isValid, input, span, showSuccess) => {
    span.classList.toggle('d-none', isValid);
    input.classList.toggle('input-error', !isValid);
    if(showSuccess) input.classList.toggle('input-success', isValid);
    return isValid;
}

const form = document.querySelector('#form');        
const email = form.querySelector("input[name='email_receptionist']");
const password = form.querySelector("input[name='password_receptionist']");
const spans = [...form.querySelectorAll('.form-text')];
const btnSubmit = form.querySelector('button[type=submit]');

form.addEventListener('submit', (evt) => {
    evt.preventDefault();
    
    setStatusInput(validateEmail(email), email, spans[0], true);
    setStatusInput(validatePassword(password), password, spans[1], true);   
    
    email.addEventListener('input', () => setStatusInput(validateEmail(email), email, spans[0]));
    password.addEventListener('input', () => setStatusInput(validatePassword(password), password, spans[1]));
    
    if (validateEmail(email) && validatePassword(password)){   
        form.submit();
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Entrando com sua conta...";
    }
});

const alerts = document.querySelectorAll(".alert");
if(alerts){
    alerts.forEach((a) => {
        setTimeout(()=> {
            a.remove();
        }, 5000);
    });
}