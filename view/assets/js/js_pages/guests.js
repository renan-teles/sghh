import { validateName, validateDate, validate, validateSelect, validateTelephone, validateEmail, validateCPF, setStatusInput } from "./validate.js";

//Functions
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

const ValidateDateInput = (input, form) => {
    input.addEventListener('input', () => {
        setStatusInput(validateDate(input.value), input);
        
        const divContainCpfResponsableGuest = form.querySelector("#divContainCpfResponsableGuest");
        const divCpfResponsable = form.querySelector("#divCpfResponsableGuest");

        let idade = new Date().getFullYear() - input.value.split("-")[0];

        if(idade < 18 && !divCpfResponsable){
            const wrapper = document.createElement('div');
            wrapper.id = "divCpfResponsableGuest"; 
            wrapper.classList.add("col-12", "mb-3");
    
            wrapper.innerHTML = `
                <label for="cpf_responsable_guest">CPF do Responsável:</label>
                <input type="text" name="cpf_responsable_guest" id="cpf_responsable_guest" placeholder="Digite o CPF do responsável..." class="form-control">
            `;
           
            const inputCpfResponsable = wrapper.querySelector("#cpf_responsable_guest");
            //setStatusInput(validateCPF(inputCpfResponsable.value), inputCpfResponsable);
            validateCPFInput(inputCpfResponsable);

            divContainCpfResponsableGuest.classList.remove("d-none");
            divContainCpfResponsableGuest.appendChild(wrapper);
        } 
        
        if(idade > 18 && divCpfResponsable){
            divCpfResponsable.remove();
            divContainCpfResponsableGuest.classList.add("d-none");
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
            s.addEventListener('input', () => setStatusInput(validate(s), s));
            if(!setStatusInput(validate(s), s)){
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
            if(!validateCPF(s.value)){
                aproved = false;
            }
        }
        
        if(s.id === "complementCPFResponsible"){
            if(!validateCPF(s.value)){
                aproved = false;
            }
        }
        
        if(s.id === "complementTelephone"){
            if(!validateTelephone(s.value)){
                aproved = false;
            }
        }
    });
    return aproved;
}

//Validate Form Register
formAddGuest.addEventListener('submit', (evt) => {
    evt.preventDefault();

    const divCpfResponsable = formAddGuest.querySelector("#divCpfResponsableGuest");

    setStatusInput(validateName(formAddGuest.name_guest), formAddGuest.name_guest);
    setStatusInput(validateEmail(formAddGuest.email_guest), formAddGuest.email_guest);
    setStatusInput(validateCPF(formAddGuest.cpf_guest.value), formAddGuest.cpf_guest);
    setStatusInput(validateDate(formAddGuest.date_birth_guest.value), formAddGuest.date_birth_guest);
    setStatusInput(validateTelephone(formAddGuest.telephone_guest.value), formAddGuest.telephone_guest);
    if(divCpfResponsable)
        setStatusInput(validateCPF(formAddGuest.cpf_responsable_guest.value), formAddGuest.cpf_responsable_guest);
    
    if (
        validateName(formAddGuest.name_guest) 
        && validateEmail(formAddGuest.email_guest) 
        && validateCPF(formAddGuest.cpf_guest.value)
        && validateTelephone(formAddGuest.telephone_guest.value)
        && validateDate(formAddGuest.date_birth_guest.value)
    ) 
    { 
        if(divCpfResponsable){
            if(!validateCPF(formAddGuest.cpf_responsable_guest.value)){
                return false;
            }
        }
        formAddGuest.submit();
        formAddGuest.btn_submit.disabled = true;
        formAddGuest.btn_submit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Cadastrando...";
    }
});

//Events Inputs
formAddGuest.name_guest.addEventListener('input', () => setStatusInput(validateName(formAddGuest.name_guest), formAddGuest.name_guest));
formAddGuest.email_guest.addEventListener('input', () => setStatusInput(validateEmail(formAddGuest.email_guest), formAddGuest.email_guest));
validateCPFInput(formAddGuest.cpf_guest);
validateTelephoneInput(formAddGuest.telephone_guest);
ValidateDateInput(formAddGuest.date_birth_guest, formAddGuest);

btnClose1.addEventListener('click', () => {
    const inputs = [formAddGuest.name_guest, formAddGuest.email_guest,formAddGuest.cpf_guest, formAddGuest.telephone_guest, formAddGuest.date_birth_guest];
    
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }
    
    const divCpfResponsable = formAddGuest.querySelector("#divCpfResponsableGuest");
    const divContainCpfResponsableGuest = formAddGuest.querySelector("#divContainCpfResponsableGuest");
    
    if(divCpfResponsable){
        divCpfResponsable.remove();
        divContainCpfResponsableGuest.classList.add("d-none");
    }
});

//Validate Form Register
formEditGuest.addEventListener('submit', (evt) => {
    evt.preventDefault();

    const divCpfResponsable = formEditGuest.querySelector("#divCpfResponsableGuest");

    setStatusInput(validateName(formEditGuest.name_guest), formEditGuest.name_guest);
    setStatusInput(validateEmail(formEditGuest.email_guest), formEditGuest.email_guest);
    setStatusInput(validateCPF(formEditGuest.cpf_guest.value), formEditGuest.cpf_guest);
    setStatusInput(validateDate(formEditGuest.date_birth_guest.value), formEditGuest.date_birth_guest);
    setStatusInput(validateTelephone(formEditGuest.telephone_guest.value), formEditGuest.telephone_guest);
    if(divCpfResponsable)
        setStatusInput(validateCPF(formEditGuest.cpf_responsable_guest.value), formEditGuest.cpf_responsable_guest);
    
    if (
        validateName(formEditGuest.name_guest) 
        && validateEmail(formEditGuest.email_guest) 
        && validateCPF(formEditGuest.cpf_guest.value)
        && validateTelephone(formEditGuest.telephone_guest.value)
        && validateDate(formEditGuest.date_birth_guest.value)
    ) 
    { 
        if(divCpfResponsable){
            if(!validateCPF(formEditGuest.cpf_responsable_guest.value)){
                return false;
            }
        }
        formEditGuest.submit();
        formEditGuest.btn_submit.disabled = true;
        formEditGuest.btn_submit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});

//Events Inputs
formEditGuest.name_guest.addEventListener('input', () => setStatusInput(validateName(formEditGuest.name_guest), formEditGuest.name_guest));
formEditGuest.email_guest.addEventListener('input', () => setStatusInput(validateEmail(formEditGuest.email_guest), formEditGuest.email_guest));
validateCPFInput(formEditGuest.cpf_guest);
validateTelephoneInput(formEditGuest.telephone_guest);
ValidateDateInput(formEditGuest.date_birth_guest, formEditGuest);

btnClose2.addEventListener('click', () => {
    const inputs = [formEditGuest.name_guest, formEditGuest.email_guest,formEditGuest.cpf_guest, formEditGuest.telephone_guest, formEditGuest.date_birth_guest];
    
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }
    
    const divCpfResponsable = formEditGuest.querySelector("#divCpfResponsableGuest");
    const divContainCpfResponsableGuest = formEditGuest.querySelector("#divContainCpfResponsableGuest");
    
    if(divCpfResponsable){
        divCpfResponsable.remove();
        divContainCpfResponsableGuest.classList.add("d-none");
    }
});

//Add Informations on Modal Edit Guest
const btnsOpenModalEdit = [...document.querySelectorAll('.btnOpenModalEdit')];
if(btnsOpenModalEdit){
    btnsOpenModalEdit.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            
            const tr = document.querySelector(`#${idFull}`);
            
            const inputs = [formEditGuest.name_guest, formEditGuest.email_guest, formEditGuest.cpf_guest, formEditGuest.telephone_guest, formEditGuest.date_birth_guest];
            const idsTds = ['#nameGuest',  '#emailGuest', '#cpfGuest', '#telephoneGuest', '#dateBirthGuest'];
            
            for(let i=0;i<inputs.length; i++){
               inputs[i].classList.remove('input-error');
               
               if(inputs[i].id === "date_birth_guest") {
                    const [dia, mes, ano] = tr.querySelector(idsTds[i]).innerHTML.split('/');

                    const divCpfResponsable = formEditGuest.querySelector("#divCpfResponsableGuest");
                    const divContainCpfResponsableGuest = formEditGuest.querySelector("#divContainCpfResponsableGuest");

                    let idade = new Date().getFullYear() - ano;

                    if(idade < 18 && !divCpfResponsable){
                        const wrapper = document.createElement('div');
                        wrapper.id = "divCpfResponsableGuest"; 
                        wrapper.classList.add("col-12", "mb-3");
    
                        wrapper.innerHTML = `
                            <label for="cpf_responsable_guest">CPF do Responsável:</label>
                            <input type="text" name="cpf_responsable_guest" id="cpf_responsable_guest" placeholder="Digite o CPF do responsável..." class="form-control">
                        `;
           
                        const inputCpfResponsable = wrapper.querySelector("#cpf_responsable_guest");
                        inputCpfResponsable.value = tr.querySelector("#cpfResponsibleGuest").innerHTML;
                        validateCPFInput(inputCpfResponsable);
                            
                        divContainCpfResponsableGuest.classList.remove("d-none");
                        divContainCpfResponsableGuest.appendChild(wrapper);
                    } 
                    
                    if(idade > 18 && divCpfResponsable){
                        divCpfResponsable.remove();
                        divContainCpfResponsableGuest.classList.add("d-none");
                    }              

                    inputs[i].value = `${ano}-${mes}-${dia}`;
                    continue;
                }

               inputs[i].value = tr.querySelector(idsTds[i]).innerHTML;
            }

            formEditGuest.guestId.value = idFull.split("_")[1];
        });
    });
}

//Add Informations on Modal Delete Guest
const btnOpenModalDelete = [...document.querySelectorAll('.btnOpenModalDelete')];
if(btnOpenModalDelete){
    btnOpenModalDelete.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formDeleteGuest.guestId.value = idFull.split("_")[1];
        });
    });
}

//TimeoutAlerts
const alerts = document.querySelectorAll(".alert");
if(alerts){
    alerts.forEach((a) => {
        setTimeout(()=> {
            a.remove();
        }, 10000);
    });
}

//Validate Form Search Rooms
const formCustomSearchGuest = document.querySelector("#formCustomSearchGuest"); 
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
        formCustomSearchGuest.btn_submit.disabled = true;
        formCustomSearchGuest.btn_submit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Pesquisando...";
    }
}); 

//Control Filters
const filters = {
    number: 0,
    incrementNumber: () => {
        filters.number += 1;
    },
    decrementNumber: () => {
        filters.number -= 1;
    },
    verifyNumber: () => {
        formCustomSearchGuest.btn_submit.disabled = (filters.number <= 0);
    }
}

filters.verifyNumber();

//Filters HTML
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
        <div class="col-md-1 d-flex justify-content-center align-items-center">
            <label class="form-label"></label>
            <button class="btn btn text-danger mt-3 btn-remove-filter" type="button"><i class="bi-trash-fill"></i></button>
        </div>
    `;
}

//Add and Remove Filters on Search Rooms
filterName.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="name">Nome</option>`, `complementName`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterName.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterName.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

filterEmail.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="email">Email</option>`, `complementEmail`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterEmail.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterEmail.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

filterCPF.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="cpf">CPF</option>`, `complementCPF`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterCPF.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    validateCPFInput(wrapper.querySelector("#complementCPF"));

    filterCPF.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

filterCPFResposible.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="cpf_responsible">CPF do Responsável</option>`, `complementCPFResponsible`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterCPFResposible.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    validateCPFInput(wrapper.querySelector("#complementCPFResponsible"));

    filterCPFResposible.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

filterTelephone.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="telephone">Telefone</option>`, `complementTelephone`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterTelephone.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    validateTelephoneInput(wrapper.querySelector("#complementTelephone"));

    filterTelephone.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

//Event BTN Delete Guest
const btnDeleteUser = document.querySelector('#btnDelete');

let intervalo = null;
let segundos = 5;

const atualizarCronometro = () => {
    if (segundos > 0) 
    {
        segundos--;
        btnDeleteUser.innerHTML = `Excluir (${segundos})`;
    }
    if (segundos === 0) 
    {
        clearInterval(intervalo);
        intervalo = null;
        btnDeleteUser.innerHTML = `Excluir`;
        btnDeleteUser.classList.remove('disabled'); 
        btnDeleteUser.addEventListener('click', () => {
            btnDeleteUser.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Excluindo...";
        });
    }
}

const iniciar = () => {
    segundos = 5;
    btnDeleteUser.innerHTML = `Excluir (${segundos})`;
    btnDeleteUser.classList.add('disabled');
    if (intervalo === null) 
    {
        intervalo = setInterval(atualizarCronometro, 1000);
    }
}

const btns = document.querySelectorAll('.btnOpenModalDelete');
btns.forEach((el) => {
    el.addEventListener('click', iniciar);
});