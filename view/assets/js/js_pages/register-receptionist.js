import { validatePassword, validateName, validateEmail } from './validate.js';

const setStatusInput = (isValid, input, span, showSuccess) => {
    span.classList.toggle('d-none', isValid);
    input.classList.toggle('input-error', !isValid);
    if(showSuccess) input.classList.toggle('input-success', isValid);
    return isValid;
}

const form = document.querySelector('#form');
const name = form.querySelector("input[name='name_receptionist']");
const email = form.querySelector("input[name='email_receptionist']");
const password = form.querySelector("input[name='password_receptionist']");
const spans = [...form.querySelectorAll('.form-text')];
const btnSubmit = form.querySelector("button[type=submit]");

form.addEventListener('submit', (evt) => {
    evt.preventDefault();

    setStatusInput(validateName(name), name, spans[0], true);
    setStatusInput(validateEmail(email), email, spans[1], true);
    setStatusInput(validatePassword(password), password, spans[2], true);

    if (validateName(name) && validateEmail(email) && validatePassword(password)){   
        form.submit();
        btnSubmit .disabled = true;
        btnSubmit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Criando conta de recepcionista...";
    }
});

name.addEventListener('input', () => setStatusInput(validateName(name), name, spans[0], true));
email.addEventListener('input', () => setStatusInput(validateEmail(email), email, spans[1], true));
password.addEventListener('input', () =>  setStatusInput(validatePassword(password), password, spans[2], true));

const btnViewPassword = form.querySelector("#view-password");
btnViewPassword.addEventListener('click', ()=> {
    if(password.type === 'text'){
        password.type = 'password';
        btnViewPassword.innerHTML = `<i class="bi-eye-fill"></i>`;
    } else{
        password.type = 'text';
        btnViewPassword.innerHTML = `<i class="bi-eye-slash-fill"></i>`;
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
