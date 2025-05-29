import { validateName, validateDate, defaultValidate, validateSelect, validateTelephone, validateEmail, validateCPF, setStatusInput } from "./validate.js";

const validateCPFInput = (input) => {
    input.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        e.target.value = value;
        input.maxLength = "14";
        setStatusInput(validateCPF(input.value), input);
    });
}

const validateTelephoneInput = (input) => {
    input.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, ''); 
        if (value.length > 0) value = '(' + value;
        if (value.length > 3) value = value.replace(/^(\(\d{2})(\d)/, '$1) $2');
        if (value.length > 9) {
            value = value.replace(/(\d{5})(\d{4})$/, '$1-$2'); 
        } else if (value.length > 8) {
            value = value.replace(/(\d{4})(\d{4})$/, '$1-$2');
        }
        e.target.value = value;
        input.maxLength = "14";
        setStatusInput(validateTelephone(input.value), input);
    });
}

const ValidateDateInput = (input, inputCpfResponsible) => {
    input.addEventListener('input', () => {
        setStatusInput(validateDate(input.value), input);

        let age = Number(new Date().getFullYear()) - Number(input.value.split("-")[0]);
       
        if(age > 18){
            inputCpfResponsible.classList.remove('input-error');
            inputCpfResponsible.classList.remove('input-success');
            inputCpfResponsible.value = '';
            inputCpfResponsible.disabled = true;
        } else{
            inputCpfResponsible.disabled = false;
        }
    });
}

const validateAllSelects = (selects, list) => {
    let isAproved = true;
    selects.forEach((s) => {
        s.addEventListener('input', () => setStatusInput(validateSelect(list, s), s));
        if(!setStatusInput(validateSelect(list, s), s)){
            isAproved = false;
        }
    });
    return isAproved;
}

const validateComplements = (selects) => {
    let aproved = true;
    selects.forEach((s) => {
        if(s.id === "complementName"){
            s.addEventListener('input', () => setStatusInput(defaultValidate(s), s));
            if(!setStatusInput(defaultValidate(s), s)){
                aproved = false;
            }
        }
      
        if(s.id === "complementEmail") {
            s.addEventListener('input', () => setStatusInput(validateEmail(s), s));
            if(!setStatusInput(validateEmail(s), s)){
                aproved = false;
            }
        }
        
        if(s.id === "complementCPF"){
            setStatusInput(validateCPF(s.value), s);
            if(!validateCPF(s.value)){
                aproved = false;
            }
        }
        
        if(s.id === "complementCPFResponsible"){
            setStatusInput(validateCPF(s.value), s);
            if(!validateCPF(s.value)){
                aproved = false;
            }
        }
        
        if(s.id === "complementTelephone"){
            setStatusInput(validateTelephone(s.value), s);
            if(!validateTelephone(s.value)){
                aproved = false;
            }
        }
    });
    return aproved;
}

const writeFilter = (option, complementId) => {
    return ` 
         <div class='col-md-3 mb-3'>
             <label class='form-label'>Onde:</label>
             <select name='columns[]' class='form-select columns'>
                 ${option}
             </select>
         </div>
 
         <div class='col-md-3 mb-3'>
             <label class='form-label'>For:</label>
             <select name='conditions[]' class='form-select conditions'>
                 <option value="eq">Igual a</option>
             </select>
         </div>
 
         <div class="col-md-5">
             <label class="form-label">Complemento:</label>
             <div id="type_complement">
                 <input id="${complementId}" class="form-control complements" name="complements[]" placeholder="Digite o complemento da pesquisa..." type="text">
             </div>
         </div>  
         <div class="col-md-1 d-flex justify-content-end justify-content-md-center align-items-center">
             <button class="btn btn text-danger mt-3 me-md-4 btn-remove-filter" type="button"><i class="bi-trash-fill"></i></button>
         </div>
     `;
}

const alerts = document.querySelectorAll(".alert");
if(alerts){
    alerts.forEach((a) => {
        setTimeout(()=> {
            a.remove();
        }, 10000);
    });
}

const formCustomSearchGuest = document.querySelector("#formCustomSearchGuest"); 
const btnSubmitFormCustomSearchGuest = formCustomSearchGuest.querySelector("#btnSubmitFormSearchGuests"); 

const filters = {
    number: 0,
    incrementNumber: () => {
        filters.number += 1;
    },
    decrementNumber: () => {
        filters.number -= 1;
    },
    verifyNumber: () => {
        btnSubmitFormCustomSearchGuest.disabled = (filters.number <= 0);
    }
}

filters.verifyNumber();

const divFiltersSearch = formCustomSearchGuest.querySelector("#divFiltersSearch");

const filterSearchGuestName = formCustomSearchGuest.querySelector("#filterSearchGuestName");
filterSearchGuestName.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="name">Nome</option>`, `complementName`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchGuestName.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterSearchGuestName.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

const filterSearchGuestEmail = formCustomSearchGuest.querySelector("#filterSearchGuestEmail");
filterSearchGuestEmail.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="email">Email</option>`, `complementEmail`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchGuestEmail.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterSearchGuestEmail.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

const filterSearchGuestCpf = formCustomSearchGuest.querySelector("#filterSearchGuestCPF");
filterSearchGuestCpf.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="cpf">CPF</option>`, `complementCPF`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchGuestCpf.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    validateCPFInput(wrapper.querySelector("#complementCPF"));

    filterSearchGuestCpf.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

const filterSearchGuestCPFResposible = formCustomSearchGuest.querySelector("#filterSearchGuestCPFResposible"); 
filterSearchGuestCPFResposible.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="cpf_responsible">CPF do Responsável</option>`, `complementCPFResponsible`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchGuestCPFResposible.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    validateCPFInput(wrapper.querySelector("#complementCPFResponsible"));

    filterSearchGuestCPFResposible.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

const filterSearchGuestTelephone = formCustomSearchGuest.querySelector("#filterSearchGuestTelephone"); 
filterSearchGuestTelephone.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="telephone">Telefone</option>`, `complementTelephone`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchGuestTelephone.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    validateTelephoneInput(wrapper.querySelector("#complementTelephone"));

    filterSearchGuestTelephone.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

formCustomSearchGuest.addEventListener('submit', (evt) => {
    evt.preventDefault();
    
    const columns = formCustomSearchGuest.querySelectorAll(".columns");
    const conditions = formCustomSearchGuest.querySelectorAll(".conditions");
    const complements = formCustomSearchGuest.querySelectorAll(".complements");

    const listValidColumns = ["name", "email", "cpf", "cpf_responsible", "telephone"]; 
    const listValidConditions = ["eq"]; 
    
    if (
        validateAllSelects(columns, listValidColumns)
        && validateAllSelects(conditions, listValidConditions)
        && validateComplements(complements)
    ) 
    { 
        formCustomSearchGuest.submit();
        btnSubmitFormCustomSearchGuest.disabled = true;
        btnSubmitFormCustomSearchGuest.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Pesquisando...";
    }
}); 

const formRegisterGuest = document.querySelector("#formRegisterGuest");
const btnSubmitFormRegisterGuest = formRegisterGuest.querySelector("btnSubmitFormCreateGuest");

const nameGuestFormRegisterGuest = formRegisterGuest.querySelector("#name_guest");
const emailGuestFormRegisterGuest = formRegisterGuest.querySelector("#email_guest");
const cpfGuestFormRegisterGuest = formRegisterGuest.querySelector("#cpf_guest");
const telephoneGuestFormRegisterGuest = formRegisterGuest.querySelector("#telephone_guest");
const dateBirthGuestFormRegisterGuest = formRegisterGuest.querySelector("#date_birth_guest");
const cpfResponsibleGuestFormRegisterGuest = formRegisterGuest.querySelector("#cpf_responsible_guest");
cpfResponsibleGuestFormRegisterGuest.disabled = true;

nameGuestFormRegisterGuest.addEventListener('input', () => setStatusInput(validateName(nameGuestFormRegisterGuest), nameGuestFormRegisterGuest));
emailGuestFormRegisterGuest.addEventListener('input', () => setStatusInput(validateEmail(emailGuestFormRegisterGuest), emailGuestFormRegisterGuest));
validateCPFInput(cpfGuestFormRegisterGuest);
validateCPFInput(cpfResponsibleGuestFormRegisterGuest);
validateTelephoneInput(telephoneGuestFormRegisterGuest);
ValidateDateInput(dateBirthGuestFormRegisterGuest, cpfResponsibleGuestFormRegisterGuest);

formRegisterGuest.addEventListener('submit', (evt) => {
    evt.preventDefault();

    setStatusInput(validateName(nameGuestFormRegisterGuest), nameGuestFormRegisterGuest);
    setStatusInput(validateEmail(emailGuestFormRegisterGuest), emailGuestFormRegisterGuest);
    setStatusInput(validateCPF(cpfGuestFormRegisterGuest.value), cpfGuestFormRegisterGuest);
    setStatusInput(validateDate(dateBirthGuestFormRegisterGuest.value), dateBirthGuestFormRegisterGuest);
    setStatusInput(validateTelephone(telephoneGuestFormRegisterGuest.value), telephoneGuestFormRegisterGuest);

    if(!cpfResponsibleGuestFormRegisterGuest.disabled){
        setStatusInput(validateCPF(cpfResponsibleGuestFormRegisterGuest.value), cpfResponsibleGuestFormRegisterGuest);
    }

    if (
        validateName(nameGuestFormRegisterGuest) 
        && validateEmail(emailGuestFormRegisterGuest) 
        && validateCPF(cpfGuestFormRegisterGuest.value)
        && validateTelephone(telephoneGuestFormRegisterGuest.value)
        && validateDate(dateBirthGuestFormRegisterGuest.value)
    ) 
    { 
        if(!cpfResponsibleGuestFormRegisterGuest.disabled){
            if(!validateCPF(cpfResponsibleGuestFormRegisterGuest.value)){
                return false;
            }
        }
        formRegisterGuest.submit();
        btnSubmitFormRegisterGuest.disabled = true;
        btnSubmitFormRegisterGuest.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Cadastrando...";
    }
});

document.querySelector("#btnCloseModalFormRegisterGuest").addEventListener('click', () => {
    const inputs = [
        nameGuestFormRegisterGuest, 
        emailGuestFormRegisterGuest,
        cpfGuestFormRegisterGuest, 
        cpfResponsibleGuestFormRegisterGuest, 
        telephoneGuestFormRegisterGuest, 
        dateBirthGuestFormRegisterGuest
    ];
    
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }

    cpfResponsibleGuestFormRegisterGuest.disabled = true;
});

const formEditGuest = document.querySelector("#formEditGuest");
const btnSubmitFormEditGuest = formEditGuest.querySelector("btnSubmitFormEditGuest");

const nameGuestFormEditGuest = formEditGuest.querySelector("#name_guest");
const emailGuestFormEditGuest = formEditGuest.querySelector("#email_guest");
const cpfGuestFormEditGuest = formEditGuest.querySelector("#cpf_guest");
const telephoneGuestFormEditGuest = formEditGuest.querySelector("#telephone_guest");
const dateBirthGuestFormEditGuest = formEditGuest.querySelector("#date_birth_guest");
const cpfResponsibleGuestFormEditGuest = formEditGuest.querySelector("#cpf_responsible_guest");
cpfResponsibleGuestFormEditGuest.disabled = true;

nameGuestFormEditGuest.addEventListener('input', () => setStatusInput(validateName(nameGuestFormEditGuest), nameGuestFormEditGuest));
emailGuestFormEditGuest.addEventListener('input', () => setStatusInput(validateEmail(emailGuestFormEditGuest), emailGuestFormEditGuest));
validateCPFInput(cpfGuestFormEditGuest);
validateCPFInput(cpfResponsibleGuestFormEditGuest);
validateTelephoneInput(telephoneGuestFormEditGuest);
ValidateDateInput(dateBirthGuestFormEditGuest, cpfResponsibleGuestFormEditGuest);

formEditGuest.addEventListener('submit', (evt) => {
    evt.preventDefault();

    setStatusInput(validateName(nameGuestFormEditGuest), nameGuestFormEditGuest);
    setStatusInput(validateEmail(emailGuestFormEditGuest), emailGuestFormEditGuest);
    setStatusInput(validateCPF(cpfGuestFormEditGuest.value), cpfGuestFormEditGuest);
    setStatusInput(validateDate(dateBirthGuestFormEditGuest.value), dateBirthGuestFormEditGuest);
    setStatusInput(validateTelephone(telephoneGuestFormEditGuest.value), telephoneGuestFormEditGuest);

    if(!cpfResponsibleGuestFormEditGuest.disabled){
        setStatusInput(validateCPF(cpfResponsibleGuestFormEditGuest.value), cpfResponsibleGuestFormEditGuest);
    }

    if (
        validateName(nameGuestFormEditGuest) 
        && validateEmail(emailGuestFormEditGuest) 
        && validateCPF(cpfGuestFormEditGuest.value)
        && validateTelephone(telephoneGuestFormEditGuest.value)
        && validateDate(dateBirthGuestFormEditGuest.value)
    ) 
    { 
        if(!cpfResponsibleGuestFormEditGuest.disabled){
            if(!validateCPF(cpfResponsibleGuestFormEditGuest.value)){
                return false;
            }
        }
        formEditGuest.submit();
        btnSubmitFormEditGuest.disabled = true;
        btnSubmitFormEditGuest.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});

document.querySelector("#btnCloseModalFormEditGuest").addEventListener('click', () => {
    const inputs = [
        nameGuestFormEditGuest, 
        emailGuestFormEditGuest,
        cpfGuestFormEditGuest, 
        cpfResponsibleGuestFormEditGuest,
        telephoneGuestFormEditGuest, 
        dateBirthGuestFormEditGuest
    ];
    
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }
    
    cpfResponsibleGuestFormEditGuest.disabled = true;
});

const btnsOpenModalEdit = document.querySelectorAll('.btnOpenModalEdit');
if(btnsOpenModalEdit){
    btnsOpenModalEdit.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            
            const tr = document.querySelector(`#${idFull}`);
            
            const inputs = [
                nameGuestFormEditGuest, 
                emailGuestFormEditGuest,
                cpfGuestFormEditGuest, 
                cpfResponsibleGuestFormEditGuest,
                telephoneGuestFormEditGuest, 
                dateBirthGuestFormEditGuest
            ];
            
            const idsTds = [
                '#viewSearchNameGuest',  
                '#viewSearchEmailGuest', 
                '#viewSearchCpfGuest', 
                '#viewSearchCpfResponsibleGuest', 
                '#viewSearchTelephoneGuest', 
                '#viewSearchDateBirthGuest'
            ];
            
            for(let i=0;i<inputs.length; i++){
               inputs[i].classList.remove('input-error');
               
               if(inputs[i].id === "date_birth_guest") {
                    const [dia, mes, ano] = tr.querySelector(idsTds[i]).innerHTML.split('/');
                    
                    let age = Number(new Date().getFullYear()) - Number(ano);

                    cpfResponsibleGuestFormEditGuest.disabled = age > 18;

                    inputs[i].value = `${ano}-${mes}-${dia}`;
                    continue;
                }

               inputs[i].value = tr.querySelector(idsTds[i]).innerHTML;
            }

            formEditGuest.querySelector("#guestId").value = idFull.split("_")[1];
        });
    });
}

const formDeleteGuest = document.querySelector("#formDeleteGuest");
const btnOpenModalDelete = document.querySelectorAll('.btnOpenModalDelete');
if(btnOpenModalDelete){
    btnOpenModalDelete.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formDeleteGuest.querySelector("#guestId").value = idFull.split("_")[1];
            const tr = document.querySelector(`#${idFull}`);
            formDeleteGuest.querySelector("#guestCpf").value = tr.querySelector("#viewSearchCpfGuest").innerHTML;
        });
    });
}

const btnDelete = document.querySelector('#btnDelete');
let intervalo = null;
let segundos = 5;

const atualizarCronometro = () => {
    if (segundos > 0) 
    {
        segundos--;
        btnDelete.innerHTML = `Deletar (${segundos})`;
    }
    if (segundos === 0) 
    {
        clearInterval(intervalo);
        intervalo = null;
        btnDelete.innerHTML = `Deletar`;
        btnDelete.classList.remove('disabled'); 
        btnDelete.addEventListener('click', () => {
            btnDelete.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Deletando...";
        });
    }
}

const iniciar = () => {
    segundos = 5;
    btnDelete.innerHTML = `Deletar (${segundos})`;
    btnDelete.classList.add('disabled');
    if (intervalo === null) 
    {
        intervalo = setInterval(atualizarCronometro, 1000);
    }
}

const btns = document.querySelectorAll('.btnOpenModalDelete');
if(btns){
    btns.forEach((el) => {
        el.addEventListener('click', iniciar);
    });
}