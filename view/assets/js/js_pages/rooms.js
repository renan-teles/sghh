import { validateNumber, defaultValidate, validateSelect, setStatusInput } from "./validate.js";

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
        s.addEventListener('input', () => setStatusInput(defaultValidate(s), s));
        if(!setStatusInput(defaultValidate(s), s)){
            aproved = false;
        }
    });
    return aproved;
}

const windowOnScroll = (divSeach, btn) => {
    window.onscroll = () => {
        const offsetTop = divSeach.getBoundingClientRect().top;
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) 
        {
          btn.style.display = "block";
        } else {
          btn.style.display = "none";
        }
        divSeach.classList.toggle("margin-on-top", offsetTop <= 0);
    };
    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });   
    });
}

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
         <div class="col-md-1 d-flex justify-content-end justify-content-md-center align-items-center">
             <button class="btn btn text-danger mt-3 me-md-3 btn-remove-filter" type="button"><i class="bi-trash-fill"></i></button>
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
         <div class="col-md-1 d-flex justify-content-end justify-content-md-center align-items-center">
             <button class="btn btn text-danger mt-3 me-md-3 btn-remove-filter" type="button"><i class="bi-trash-fill"></i></button>
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

const formCustomSearchRooms = document.querySelector("#formCustomSearchRooms"); 
const btnSubmitFormCustomSearchRoom = formCustomSearchRooms.querySelector("#btnSubmitFormCustomSearchRoom");

const filters = {
    number: 0,
    incrementNumber: () => {
        filters.number += 1;
    },
    decrementNumber: () => {
        filters.number -= 1;
    },
    verifyNumber: () => {
        btnSubmitFormCustomSearchRoom.disabled = (filters.number <= 0);
    }
}

filters.verifyNumber();

const divFiltersSearch = formCustomSearchRooms.querySelector("#divFiltersSearch");

const filterSearchRoomNumber = formCustomSearchRooms.querySelector("#filterSearchRoomNumber");
filterSearchRoomNumber.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="number">Número</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchRoomNumber.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterSearchRoomNumber.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

const filterSearchRoomCapacity = formCustomSearchRooms.querySelector("#filterSearchRoomCapacity");
filterSearchRoomCapacity.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="capacity">Capacidade</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchRoomCapacity.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterSearchRoomCapacity.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

const filterSearchRoomDailyPrice = formCustomSearchRooms.querySelector("#filterSearchRoomDailyPrice");
filterSearchRoomDailyPrice.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="daily_price">Preço da Diária</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchRoomDailyPrice.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterSearchRoomDailyPrice.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

const filterSearchRoomTypeRoom = formCustomSearchRooms.querySelector("#filterSearchRoomTypeRoom");
filterSearchRoomTypeRoom.addEventListener('click', () => {
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
        filterSearchRoomTypeRoom.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterSearchRoomTypeRoom.disabled = true;

    divFiltersSearch.appendChild(wrapper);
}); 

const filterSearchRoomAvailability = formCustomSearchRooms.querySelector("#filterSearchRoomAvailability");
filterSearchRoomAvailability.addEventListener('click', () => {
    const wrapper = document.createElement('div');

    wrapper.classList.add('row'); 

    let complementsOptions = `
        <option value="1">Disponível</option>
        <option value="2">Ocupado</option>
        <option value="3">Indiponível</option>
    ` ;
    let columnOption = `<option value="id_availability_room">Disponibilidade</option>`;

    wrapper.innerHTML = selectFilter(columnOption, complementsOptions);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filters.decrementNumber();
        filters.verifyNumber();
        filterSearchRoomAvailability.disabled = false;
        wrapper.remove();
    });

    filters.incrementNumber();
    filters.verifyNumber();

    filterSearchRoomAvailability.disabled = true;

    divFiltersSearch.appendChild(wrapper);
});

formCustomSearchRooms.addEventListener('submit', (evt) => {
    evt.preventDefault();
    
    const columns = formCustomSearchRooms.querySelectorAll(".columns");
    const conditions = formCustomSearchRooms.querySelectorAll(".conditions");
    const complements = formCustomSearchRooms.querySelectorAll(".complements");

    const listValidColumns = ["number", "id_type_room", "capacity", "id_availability_room", "daily_price"]; 
    const listValidConditions = ["lt","gt","lte","gte","eq"]; 
    
    if (
        validateAllSelects(columns, listValidColumns)
        && validateAllSelects(conditions, listValidConditions)
        && validateComplements(complements)
    ) 
    { 
        formCustomSearchRooms.submit();
        btnSubmitFormCustomSearchRoom.disabled = true;
        btnSubmitFormCustomSearchRoom.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Pesquisando...";
    }
}); 

const formRegisterRoom = document.querySelector("#formRegisterRoom");
const btnSubmitFormRegisterRoom = formRegisterRoom.querySelector("#btnSubmitFormRegisterRoom");

const numberRoomFormRegisterRoom = formRegisterRoom.querySelector("#number_room");
const floorRoomFormRegisterRoom = formRegisterRoom.querySelector("#floor_room");
const capacityRoomFormRegisterRoom = formRegisterRoom.querySelector("#capacity_room");
const dailyPriceRoomFormRegisterRoom = formRegisterRoom.querySelector("#daily_price_room");
const typeRoomFormRegisterRoom = formRegisterRoom.querySelector("#type_room");
const availabiliyRoomFormRegisterRoom = formRegisterRoom.querySelector("#availability_room");

formRegisterRoom.addEventListener('submit', (evt) => {
    evt.preventDefault();
    
    validateNumberInput(numberRoomFormRegisterRoom);
    validateNumberInput(floorRoomFormRegisterRoom);
    validateNumberInput(capacityRoomFormRegisterRoom);
    validateNumberInput(dailyPriceRoomFormRegisterRoom);
    validateNumberInput(availabiliyRoomFormRegisterRoom);
    validateNumberInput(typeRoomFormRegisterRoom);

    if (
        validateNumber(numberRoomFormRegisterRoom) 
        && validateNumber(floorRoomFormRegisterRoom) 
        && validateNumber(capacityRoomFormRegisterRoom)
        && validateNumber(dailyPriceRoomFormRegisterRoom)
        && validateNumber(availabiliyRoomFormRegisterRoom)
        && validateNumber(typeRoomFormRegisterRoom)
    ) 
    { 
        formRegisterRoom.submit();
        btnSubmitFormRegisterRoom.disabled = true;
        btnSubmitFormRegisterRoom.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Cadastrando...";
    }
});

document.querySelector('#btnCloseFormRegisterRoom').addEventListener('click', () => {
    const inputs = [
        numberRoomFormRegisterRoom, 
        floorRoomFormRegisterRoom, 
        capacityRoomFormRegisterRoom, 
        dailyPriceRoomFormRegisterRoom, 
        availabiliyRoomFormRegisterRoom,
        typeRoomFormRegisterRoom
    ];
    
    for(let i=0; i<inputs.length; i++){
        if(inputs[i].id !== "type_room" && inputs[i].id !== "availability_room") inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }
});

const formEditRoom = document.querySelector("#formEditRoom");
const btnSubmitFormEditRoom = formEditRoom.querySelector("#btnSubmitFormEditRoom");

const numberRoomFormEditRoom = formEditRoom.querySelector("#number_room");
const floorRoomFormEditRoom = formEditRoom.querySelector("#floor_room");
const capacityRoomFormEditRoom = formEditRoom.querySelector("#capacity_room");
const dailyPriceRoomFormEditRoom = formEditRoom.querySelector("#daily_price_room");
const typeRoomFormEditRoom = formEditRoom.querySelector("#type_room");
const availabiliyRoomFormEditRoom = formEditRoom.querySelector("#availability_room");

formEditRoom.addEventListener('submit', (evt) => {
    evt.preventDefault();

    validateNumberInput(numberRoomFormEditRoom);
    validateNumberInput(floorRoomFormEditRoom);
    validateNumberInput(capacityRoomFormEditRoom);
    validateNumberInput(dailyPriceRoomFormEditRoom);
    validateNumberInput(availabiliyRoomFormEditRoom);
    validateNumberInput(typeRoomFormEditRoom);

    if (
        validateNumber(numberRoomFormEditRoom) 
        && validateNumber(floorRoomFormEditRoom) 
        && validateNumber(capacityRoomFormEditRoom)
        && validateNumber(dailyPriceRoomFormEditRoom)
        && validateNumber(availabiliyRoomFormEditRoom)
        && validateNumber(typeRoomFormEditRoom)
    ) 
    { 
        formEditRoom.submit();
        btnSubmitFormEditRoom.disabled = true;
        btnSubmitFormEditRoom.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});

document.querySelector('#btnCloseModalFormEditRoom').addEventListener('click', () => {
    const inputs = [
        numberRoomFormEditRoom, 
        floorRoomFormEditRoom, 
        capacityRoomFormEditRoom, 
        dailyPriceRoomFormEditRoom, 
        typeRoomFormEditRoom
    ];
    
    for(let i=0; i<inputs.length; i++){
        if(inputs[i].id !== "type_room") inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }
});

const btnsOpenModalEdit = [...document.querySelectorAll('.btnOpenModalEdit')];
if(btnsOpenModalEdit){
    btnsOpenModalEdit.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            
            const tr = document.querySelector(`#${idFull}`);

            const inputs = [
                numberRoomFormEditRoom, 
                floorRoomFormEditRoom, 
                capacityRoomFormEditRoom, 
                dailyPriceRoomFormEditRoom, 
                availabiliyRoomFormEditRoom,
                typeRoomFormEditRoom
            ];
           
            const idsTds = [
                '#viewSearchNumberRoom',  
                '#viewSearchFloorRoom', 
                '#viewSearchCapacityRoom', 
                '#viewSearchDailyPriceRoom', 
                '#viewSearchAvailabilityRoom',
                '#viewSearchTypeRoom'
            ];

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

                if(inputs[i].id === "availability_room"){
                    const availabilitysRooms = new Map();

                    availabilitysRooms.set("Disponível", "1");
                    availabilitysRooms.set("Ocupado", "2");
                    availabilitysRooms.set("Indisponível", "3");

                    inputs[i].value = availabilitysRooms.get(tr.querySelector(idsTds[i]).innerHTML);
                    continue;
                }
            
               inputs[i].value = tr.querySelector(idsTds[i]).innerHTML;
            }

            formEditRoom.querySelector("#roomId").value = idFull.split("_")[1];
        });
    });
}

const formDeleteRoom = document.querySelector("#formDeleteRoom");
const btnOpenModalDelete = [...document.querySelectorAll('.btnOpenModalDelete')];
if(btnOpenModalDelete){
    btnOpenModalDelete.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formDeleteRoom.querySelector("#roomId").value = idFull.split("_")[1]; 
             
            const tr = document.querySelector(`#${idFull}`);
            formDeleteRoom.querySelector("#roomNumber").value = tr.querySelector("#viewSearchNumberRoom").innerHTML;
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

windowOnScroll(document.querySelector("#title-page"), document.querySelector("#btnTop"));