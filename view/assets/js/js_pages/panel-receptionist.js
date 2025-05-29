import { validatePassword, validateName, validateEmail } from  './validate.js';

const setStatusInput = (isValid, input, span, showSuccess) => {
    span.classList.toggle('d-none', isValid);
    input.classList.toggle('input-error', !isValid);
    if(showSuccess) input.classList.toggle('input-success', isValid);
    return isValid;
}

const formEditNameAndEmail = document.querySelector("#formEditNameAndEmail");
const name = document.querySelector("input[name='name_receptionist']");
const email = document.querySelector("input[name='email_receptionist']");
const spansFormEditNameAndEmail = formEditNameAndEmail.querySelectorAll(".spanFormEditNameAndEmail");
const btnSubmitEdit = formEditNameAndEmail.querySelector('button[type=submit]');

formEditNameAndEmail.addEventListener('submit', (evt) => {
    evt.preventDefault();  
  
    setStatusInput(validateName(name), name, spansFormEditNameAndEmail[0], true);
    setStatusInput(validateEmail(email), email, spansFormEditNameAndEmail[1], true);
   
    if (validateName(name) && validateEmail(email)){   
        formEditNameAndEmail.submit();
        btnSubmitEdit.disabled = true;
        btnSubmitEdit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});

name.addEventListener('input', () => setStatusInput(validateName(name), name, spansFormEditNameAndEmail[0], true));
email.addEventListener('input', () => setStatusInput(validateEmail(email), email, spansFormEditNameAndEmail[1], true));

const formEditPassword = document.querySelector("#formEditPassword");
const newPassword = formEditPassword.querySelector("input[name='new_password_receptionist']");
const password = formEditPassword.querySelector("input[name='password_receptionist']");
const spansFormEditPassword = formEditPassword.querySelectorAll(".spanFormEditPassword");
const btnSubmitEditPassword = formEditPassword.querySelector('button[type=submit]');

formEditPassword.addEventListener('submit', (evt) => {
    evt.preventDefault();
  
    setStatusInput(validatePassword(newPassword), newPassword, spansFormEditPassword[0], true);
    setStatusInput(validatePassword(password), password, spansFormEditPassword[1], true);
   
    if (validatePassword(password) && validatePassword(newPassword)){   
        formEditPassword.submit();
        btnSubmitEditPassword.disabled = true;
        btnSubmitEditPassword.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});

password.addEventListener('input', () => setStatusInput(validatePassword(password), password, spansFormEditPassword[0], true));
newPassword.addEventListener('input', () => setStatusInput(validatePassword(newPassword), newPassword, spansFormEditPassword[1], true));

const btnViewCurrentPassword = formEditPassword.querySelector("#btn-view-current-password");
const btnViewNewPassword = formEditPassword.querySelector("#btn-view-new-password");

btnViewCurrentPassword.addEventListener("click", () => {
    if(password.type === 'text'){
        password.type = 'password';
        btnViewCurrentPassword.innerHTML = `<i class="bi-eye-fill"></i>`;
    } else{
        password.type = 'text';
        btnViewCurrentPassword.innerHTML = `<i class="bi-eye-slash-fill"></i>`;
    }
});

btnViewNewPassword.addEventListener("click", () => {
    if(newPassword.type === 'text'){
        newPassword.type = 'password';
        btnViewNewPassword.innerHTML = `<i class="bi-eye-fill"></i>`;
    } else{
        newPassword.type = 'text';
        btnViewNewPassword.innerHTML = `<i class="bi-eye-slash-fill"></i>`;
    }
});

const btnDeleteReceptionist = document.querySelector('#btnDeleteReceptionist');
let intervalo = null;
let segundos = 5;

const atualizarCronometro = () => {
    if (segundos > 0) {
        segundos--;
        btnDeleteReceptionist.innerHTML = `Deletar (${segundos})`;
    }
    if (segundos === 0) {
        clearInterval(intervalo);
        intervalo = null;
        btnDeleteReceptionist.innerHTML = `Deletar`;
        btnDeleteReceptionist.classList.remove('disabled'); 
        btnDeleteReceptionist.addEventListener('click', () => {
            btnDeleteReceptionist.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Deletando...";
        });
    }
}

const iniciar = ()  => {
    segundos = 5;
    btnDeleteReceptionist.innerHTML = `Deletar (${segundos})`;
    btnDeleteReceptionist.classList.add('disabled');
  
    if (intervalo === null) {
        intervalo = setInterval(atualizarCronometro, 1000);
    }
}

document.querySelector('#btnOpenModalDeleteReceptionist').addEventListener('click', iniciar);

const alerts = document.querySelectorAll(".alert");
if(alerts){
    alerts.forEach((a) => {
        setTimeout(()=> {
            a.remove();
        }, 5000);
    });
}