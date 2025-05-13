import { validateNumber, validate, validateSelect, setStatusInput } from "./validate.js";

//Functions
const validateNumberInput = (input) => {
    input.addEventListener('input', () => setStatusInput(validateNumber(input), input));
    setStatusInput(validateNumber(input), input);
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
        s.addEventListener('input', () => setStatusInput(validate(s), s));
        if(!setStatusInput(validate(s), s)){
            aproved = false;
        }
    });
    return aproved;
}

//Validate Form Register Room
formAddRoom.addEventListener('submit', (evt) => {
    evt.preventDefault();
    validateNumberInput(formAddRoom.number_room);
    validateNumberInput(formAddRoom.floor_room);
    validateNumberInput(formAddRoom.capacity_room);
    validateNumberInput(formAddRoom.daily_price_room);
    validateNumberInput(formAddRoom.type_room);
    if (
        validateNumber(formAddRoom.number_room) 
        && validateNumber(formAddRoom.floor_room) 
        && validateNumber(formAddRoom.capacity_room)
        && validateNumber(formAddRoom.daily_price_room)
        && validateNumber(formAddRoom.type_room)
    ) 
    { 
        formAddRoom.submit();
        formAddRoom.btn_submit.disabled = true;
        formAddRoom.btn_submit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Cadastrando...";
    }
});

document.querySelector('#btnClose1').addEventListener('click', () => {
    const inputs = [formAddRoom.number_room, formAddRoom.floor_room, formAddRoom.capacity_room, formAddRoom.daily_price_room, formAddRoom.type_room];
    for(let i=0; i<inputs.length; i++){
        if(inputs[i].id !== "type_room"){
            inputs[i].value = '';    
        }
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }
});

//Validate Form Edit Room
formEditRoom.addEventListener('submit', (evt) => {
    evt.preventDefault();
    validateNumberInput(formEditRoom.number_room);
    validateNumberInput(formEditRoom.floor_room);
    validateNumberInput(formEditRoom.capacity_room);
    validateNumberInput(formEditRoom.daily_price_room);
    validateNumberInput(formEditRoom.type_room);
    if (
        validateNumber(formEditRoom.number_room) 
        && validateNumber(formEditRoom.floor_room) 
        && validateNumber(formEditRoom.capacity_room)
        && validateNumber(formEditRoom.daily_price_room)
        && validateNumber(formEditRoom.type_room)
    ) 
    { 
        formEditRoom.submit();
        formEditRoom.btn_submit.disabled = true;
        formEditRoom.btn_submit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});

document.querySelector('#btnClose2').addEventListener('click', () => {
    const inputs = [formEditRoom.number_room, formEditRoom.floor_room, formEditRoom.capacity_room, formEditRoom.daily_price_room, formEditRoom.type_room];
    for(let i=0; i<inputs.length; i++){
        if(inputs[i].id !== "type_room"){
            inputs[i].value = '';    
        }
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }
});

//Add Informations on Modal Edit Room
const btnsOpenModalEdit = [...document.querySelectorAll('.btnOpenModalEdit')];
if(btnsOpenModalEdit){
    btnsOpenModalEdit.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            
            const tr = document.querySelector(`#${idFull}`);
            
            const inputs = [formEditRoom.number_room, formEditRoom.floor_room, formEditRoom.capacity_room, formEditRoom.daily_price_room, formEditRoom.type_room];
            const idsTds = ['#numberRoom',  '#floorRoom', '#capacityRoom', '#dailyPriceRoom', '#typeRoom'];
            
            for(let i=0;i<inputs.length; i++){
               inputs[i].classList.remove('input-error');

               if(inputs[i].id === "type_room") {                
                    const typesRooms = new Map();

                    typesRooms.set("Simples", "1");
                    typesRooms.set("Suíte", "2");
                    typesRooms.set("Luxuoso", "3");
                    
                    inputs[i].value = typesRooms.get(tr.querySelector(idsTds[i]).innerHTML);
                    continue;
                }
            
               inputs[i].value = tr.querySelector(idsTds[i]).innerHTML;
            }

            formEditRoom.roomId.value = idFull.split("_")[1];
        });
    });
}

//Add Informations on Modal Delete Room
const btnOpenModalDelete = [...document.querySelectorAll('.btnOpenModalDelete')];
if(btnOpenModalDelete){
    btnOpenModalDelete.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formDeleteRoom.roomId.value = idFull.split("_")[1];
        });
    });
}

//Validate Form Search Rooms
const formCustomSearchRooms = document.querySelector("#formCustomSearchRooms"); 
formCustomSearchRooms.addEventListener('submit', (evt) => {
    evt.preventDefault();
    
    const columns = formCustomSearchRooms.querySelectorAll(".columns");
    const conditions = formCustomSearchRooms.querySelectorAll(".conditions");
    const complements = formCustomSearchRooms.querySelectorAll(".complements");

    const listValidColumns = ["number", "id_type_room", "capacity", "is_available", "daily_price"]; 
    const listValidConditions = ["lt","gt","lte","gte","eq"]; 
    
    if (
        validateAllSelects(columns, listValidColumns)
        && validateAllSelects(conditions, listValidConditions)
        && validateComplements(complements)
    ) 
    { 
        formCustomSearchRooms.submit();
        formCustomSearchRooms.btn_submit.disabled = true;
        formCustomSearchRooms.btn_submit.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Pesquisando...";
    }
}); 

//TimeOut Alerts
const alerts = document.querySelectorAll(".alert");
if(alerts){
    alerts.forEach((a) => {
        setTimeout(()=> {
            a.remove();
        }, 10000);
    });
}

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
        formCustomSearchRooms.btn_submit.disabled = (filters.number <= 0);
    }
}

filters.verifyNumber();

//Filters HTML
const writeFilter = (option) => {
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
                <option value="lt">Menor que</option>
                <option value="gt">Maior que</option>
                <option value="lte">Menor ou igual a</option>
                <option value="gte">Maior ou igual a</option>
                <option value="eq">Igual a</option>
            </select>
        </div>

        <div class="col-md-5">
            <label class="form-label">Complemento:</label>
            <div id="type_complement">
                <input class="form-control complements" name="complements[]" placeholder="Digite o complemento da pesquisa..." type="text">
            </div>
        </div>  
        <div class="col-md-1 d-flex justify-content-center align-items-center">
            <label class="form-label"></label>
            <button class="btn btn text-danger mt-3 btn-remove-filter" type="button"><i class="bi-trash-fill"></i></button>
        </div>
    `;
}

const selectFilter = (columnOption, complementsOptions) => {
    return `
        <div class='col-md-3 mb-3'>
            <label class='form-label'>Onde:</label>
            <select name='columns[]' class='form-select columns'>
                ${columnOption}
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
                <select name='complements[]' class='form-select complements'>
                    ${complementsOptions}
                </select>
            </div>
        </div>  
        <div class="col-md-1 d-flex justify-content-center align-items-center">
            <label class="form-label"></label>
            <button class="btn btn text-danger mt-3 btn-remove-filter" type="button"><i class="bi-trash-fill"></i></button>
        </div>
    `;
}

//Add and Remove Filters on Search Rooms
filterNumber.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="number">Número</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterNumber.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterNumber.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

filterCapacity.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="capacity">Capacidade</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterCapacity.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterCapacity.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

filterDailyPrice.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="daily_price">Preço da Diária</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterDailyPrice.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterDailyPrice.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

filterTypeRoom.addEventListener('click', () => {
    const wrapper = document.createElement('div');

    wrapper.classList.add('row'); 

    let complementsOptions = `
        <option value="1">Simples</option>
        <option value="2">Suíte</option>
        <option value="3">Luxuoso</option>
    ` ;
    let columnOption = `<option value="id_type_room">Tipo</option>`;

    wrapper.innerHTML = selectFilter(columnOption, complementsOptions);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterTypeRoom.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterTypeRoom.disabled = true;

    divFiltersSearch.appendChild(wrapper);
}); 

filterAvailability.addEventListener('click', () => {
    const wrapper = document.createElement('div');

    wrapper.classList.add('row'); 

    let complementsOptions = `
        <option value="1">Disponível</option>
        <option value="0">Indisponível</option>
    ` ;
    let columnOption = `<option value="is_available">Disponibilidade</option>`;

    wrapper.innerHTML = selectFilter(columnOption, complementsOptions);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterAvailability.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterAvailability.disabled = true;

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