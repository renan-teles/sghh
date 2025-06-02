import { validateNumber, defaultValidate, validateDate, validateCPF, validateSelect, setStatusInput } from "./validate.js";

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

const validateDiffOfDate = (dateToCheck) => {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
  
    const check = new Date(dateToCheck);
    check.setHours(0, 0, 0, 0);
  
    return check >= today;
}

const parseLocalDate = (dateStr) => {
    const [year, month, day] = dateStr.split('-').map(Number);
    return new Date(year, month - 1, day);
}

const calculateDiffDays = (start, end) => {
    const oneDay = 1000 * 60 * 60 * 24;
    const diff = end - start;
    const days = Math.ceil(diff / oneDay);
    return days >= 1 ? days : 1;
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

const inputCPF = () => {
    return ` 
        <div class="col-11">
            <label for="cpf_guest">CPF do Hóspede:</label>
            <input type="text" name="cpf_guests[]" id="cpf_guest" placeholder="Digite o CPF do hóspede..." class="form-control cpfGuests">
        </div>
        <div class="col-1 d-flex justify-content-center align-items-center">
            <button class="btn btn text-danger btn-remove-cpf-guest mt-4 me-2" type="button"><i class="bi-trash-fill"></i></button>
        </div>
    `;
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
             <button class="btn text-danger mt-3 me-md-4 btn-remove-filter" type="button"><i class="bi-trash-fill"></i></button>
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

const formCustomSearchRooms = document.querySelector("#formCustomSearchRooms"); 
const btnSubmitFormCustomSearchRooms = formCustomSearchRooms.querySelector("#btnSubmitCustomSearchRooms");

const filtersRooms = {
    number: 0,
    incrementNumber: () => {
        filtersRooms.number += 1;
    },
    decrementNumber: () => {
        filtersRooms.number -= 1;
    },
    verifyNumber: () => {
        btnSubmitFormCustomSearchRooms.disabled = (filtersRooms.number <= 0);
    }
}

filtersRooms.verifyNumber();

const divFiltersSearchRooms = formCustomSearchRooms.querySelector("#divFiltersSearchRooms");

const filterSearchRoomNumber = formCustomSearchRooms.querySelector("#filterSearchRoomNumber");
filterSearchRoomNumber.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="number">Número</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filtersRooms.decrementNumber();
        filtersRooms.verifyNumber();
        filterSearchRoomNumber.disabled = false;
        wrapper.remove();
    });

    filtersRooms.incrementNumber();
    filtersRooms.verifyNumber();

    filterSearchRoomNumber.disabled = true;

    divFiltersSearchRooms.appendChild(wrapper);
});

const filterSearchRoomCapacity = formCustomSearchRooms.querySelector("#filterSearchRoomCapacity");
filterSearchRoomCapacity.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="capacity">Capacidade</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filtersRooms.decrementNumber();
        filtersRooms.verifyNumber();
        filterSearchRoomCapacity.disabled = false;
        wrapper.remove();
    });

    filtersRooms.incrementNumber();
    filtersRooms.verifyNumber();

    filterSearchRoomCapacity.disabled = true;

    divFiltersSearchRooms.appendChild(wrapper);
});

const filterSearchRoomDailyPrice = formCustomSearchRooms.querySelector("#filterSearchRoomDailyPrice");
filterSearchRoomDailyPrice.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="daily_price">Preço da Diária</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filtersRooms.decrementNumber();
        filtersRooms.verifyNumber();
        filterSearchRoomDailyPrice.disabled = false;
        wrapper.remove();
    });

    filtersRooms.incrementNumber();
    filtersRooms.verifyNumber();

    filterSearchRoomDailyPrice.disabled = true;

    divFiltersSearchRooms.appendChild(wrapper);
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
        filtersRooms.decrementNumber();
        filtersRooms.verifyNumber();
        filterSearchRoomTypeRoom.disabled = false;
        wrapper.remove();
    });

    filtersRooms.incrementNumber();
    filtersRooms.verifyNumber();

    filterSearchRoomTypeRoom.disabled = true;

    divFiltersSearchRooms.appendChild(wrapper);
}); 

const filterSearchRoomAvailability = formCustomSearchRooms.querySelector("#filterSearchRoomAvailability");
filterSearchRoomAvailability.addEventListener('click', () => {
    const wrapper = document.createElement('div');

    wrapper.classList.add('row'); 

    let complementsOptions = `
        <option value="1">Disponível</option>
    ` ;
    let columnOption = `<option value="id_availability_room">Disponibilidade</option>`;

    wrapper.innerHTML = selectFilter(columnOption, complementsOptions);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filtersRooms.decrementNumber();
        filtersRooms.verifyNumber();
        filterSearchRoomTypeRoom.disabled = false;
        wrapper.remove();
    });

    filtersRooms.incrementNumber();
    filtersRooms.verifyNumber();

    filterSearchRoomTypeRoom.disabled = true;

    divFiltersSearchRooms.appendChild(wrapper);
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
        btnSubmitFormCustomSearchRooms.disabled = true;
        btnSubmitFormCustomSearchRooms.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Pesquisando...";
    }
}); 

const formCustomSearchAccommodations = document.querySelector("#formCustomSearchAccommodations"); 
const btnSubmitFormCustomSearchAccommodations = formCustomSearchAccommodations.querySelector("#btnSubmitCustomSearchAccommodations");

const filtersAccommodations = {
    number: 0,
    incrementNumber: () => {
        filtersAccommodations.number += 1;
    },
    decrementNumber: () => {
        filtersAccommodations.number -= 1;
    },
    verifyNumber: () => {
        btnSubmitFormCustomSearchAccommodations.disabled = (filtersAccommodations.number <= 0);
    }
}

filtersAccommodations.verifyNumber();

const divFiltersSearchAccommodations = formCustomSearchAccommodations.querySelector("#divFiltersSearchAccommodations");

const filterSearchAccommodationNumberRoom = document.querySelector("#filterSearchAccommodationNumberRoom");
filterSearchAccommodationNumberRoom.addEventListener('click', () => {
    const wrapper = document.createElement('div');
 
    wrapper.classList.add('row'); 
    wrapper.innerHTML = writeFilter(`<option value="a.number_room">Número</option>`);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filtersAccommodations.decrementNumber();
        filtersAccommodations.verifyNumber();
        filterSearchAccommodationNumberRoom.disabled = false;
        wrapper.remove();
    });

    filtersAccommodations.incrementNumber();
    filtersAccommodations.verifyNumber();

    filterSearchAccommodationNumberRoom.disabled = true;

    divFiltersSearchAccommodations.appendChild(wrapper);
});

const filterSearchAccommodationStatusAccommodation = document.querySelector("#filterSearchAccommodationStatusAccommodation");
filterSearchAccommodationStatusAccommodation.addEventListener('click', () => {
    const wrapper = document.createElement('div');

    wrapper.classList.add('row'); 

    let complementsOptions = `
        <option value="1">Ativa</option>
        <option value="2">Finalizada</option>
        <option value="3">Cancelada</option>
    ` ;
    let columnOption = `<option value="a.id_status_accommodation">Status de Hospedagem</option>`;

    wrapper.innerHTML = selectFilter(columnOption, complementsOptions);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filtersAccommodations.decrementNumber();
        filtersAccommodations.verifyNumber();
        filterSearchAccommodationStatusAccommodation.disabled = false;
        wrapper.remove();
    });

    filtersAccommodations.incrementNumber();
    filtersAccommodations.verifyNumber();

    filterSearchAccommodationStatusAccommodation.disabled = true;

    divFiltersSearchAccommodations.appendChild(wrapper);
}); 

const filterSearchAccommodationStatusPayment = document.querySelector("#filterSearchAccommodationStatusPayment");
filterSearchAccommodationStatusPayment.addEventListener('click', () => {
    const wrapper = document.createElement('div');

    wrapper.classList.add('row'); 

    let complementsOptions = `
        <option value="1">Pago</option>
        <option value="2">Pendente</option>
    ` ;
    let columnOption = `<option value="a.id_status_payment">Status de Pagamento</option>`;

    wrapper.innerHTML = selectFilter(columnOption, complementsOptions);
   
    wrapper.querySelector('.btn-remove-filter').addEventListener('click', () => {
        filtersAccommodations.decrementNumber();
        filtersAccommodations.verifyNumber();
        filterSearchAccommodationStatusPayment.disabled = false;
        wrapper.remove();
    });

    filtersAccommodations.incrementNumber();
    filtersAccommodations.verifyNumber();

    filterSearchAccommodationStatusPayment.disabled = true;

    divFiltersSearchAccommodations.appendChild(wrapper);
}); 

formCustomSearchAccommodations.addEventListener('submit', (evt) => {
    evt.preventDefault();
    
    const columns = formCustomSearchAccommodations.querySelectorAll(".columns");
    const conditions = formCustomSearchAccommodations.querySelectorAll(".conditions");
    const complements = formCustomSearchAccommodations.querySelectorAll(".complements");

    const listValidColumns = ["a.number_room", "a.id_status_payment", "a.id_status_accommodation"]; 
    const listValidConditions = ["lt","gt","lte","gte","eq"]; 
    
    if (
        validateAllSelects(columns, listValidColumns)
        && validateAllSelects(conditions, listValidConditions)
        && validateComplements(complements)
    ) 
    { 
        formCustomSearchAccommodations.submit();
        btnSubmitFormCustomSearchAccommodations.disabled = true;
        btnSubmitFormCustomSearchAccommodations.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Pesquisando...";
    }
}); 

const formCreateAccommodation = document.querySelector("#formCreateAccommodation");
const btnSubmitFormCreateAccommodation = formCreateAccommodation.querySelector("#btnSubmitFormCreateAccommodation");

const cpfGuests = {
    quantCurr: 0,
    quantMax: 0, 
    increment: () => {
        cpfGuests.quantCurr += 1;
    },
    decrement: () => {
        cpfGuests.quantCurr -= 1;
    },
    setQuantMax: (max) => {
        cpfGuests.quantMax = max; 
    },
    verify: () => {
        return cpfGuests.quantCurr < cpfGuests.quantMax;
    }
}

formCreateAccommodation.querySelector("#btnAddCpfGuest").addEventListener('click', () => {
    cpfGuests.setQuantMax(formCreateAccommodation.querySelector("#capacity_room").value);
    
    if(cpfGuests.verify()){    
        const wrapper = document.createElement('div');
        wrapper.classList.add('row', 'mb-3'); 

        wrapper.innerHTML = inputCPF();

        wrapper.querySelector('.btn-remove-cpf-guest').addEventListener('click', () => {
            cpfGuests.decrement();
            wrapper.remove();
        });
      
        validateCPFInput(wrapper.querySelector('#cpf_guest'));

        cpfGuests.increment();

        formCreateAccommodation.querySelector("#divContainerCpfGuests").appendChild(wrapper);
    }
});

const dateCheckinFormCreateAccommodation = formCreateAccommodation.querySelector("#date_checkin");
const dateCheckoutFormCreateAccommodation = formCreateAccommodation.querySelector("#date_checkout");
const valueTotalDaysFormCreateAccommodation = formCreateAccommodation.querySelector("#valueTotalDays");
const dailyPriceRoomFormCreateAccommodation = formCreateAccommodation.querySelector("#daily_price_room");

dateCheckinFormCreateAccommodation.addEventListener('input', () => {
    const checkin = parseLocalDate(dateCheckinFormCreateAccommodation.value);
    const checkout = parseLocalDate(dateCheckoutFormCreateAccommodation.value);

    setStatusInput(validateDate(dateCheckinFormCreateAccommodation.value), dateCheckinFormCreateAccommodation);
    setStatusInput(validateDiffOfDate(checkin), dateCheckinFormCreateAccommodation);
    
    if(!(validateDiffOfDate(checkin) && validateDiffOfDate(checkout))){
        valueTotalDaysFormCreateAccommodation.innerHTML = `R$0,00`;
        return;
    }

    let quantDays = calculateDiffDays(checkin, checkout);
    let dailyPrice = parseFloat(dailyPriceRoomFormCreateAccommodation.value.replace(',', '.')) || 0;
    
    let total = quantDays * dailyPrice;

    valueTotalDaysFormCreateAccommodation.innerHTML = `R$${total.toFixed(2).replace('.',',')}`;
});

dateCheckoutFormCreateAccommodation.addEventListener('input', () => {
    const checkin = parseLocalDate(dateCheckinFormCreateAccommodation.value);
    const checkout = parseLocalDate(dateCheckoutFormCreateAccommodation.value);

    setStatusInput(validateDate(dateCheckoutFormCreateAccommodation.value), dateCheckoutFormCreateAccommodation);
    setStatusInput(validateDiffOfDate(checkout), dateCheckoutFormCreateAccommodation);

    if(!(validateDiffOfDate(checkout) && validateDiffOfDate(checkin))){
        valueTotalDaysFormCreateAccommodation.innerHTML = `R$0,00`;
        return;
    }

    let quantDays = calculateDiffDays(checkin, checkout);
    let dailyPrice = parseFloat(dailyPriceRoomFormCreateAccommodation.value.replace(',', '.')) || 0;
    
    let total = quantDays * dailyPrice;
    
    valueTotalDaysFormCreateAccommodation.innerHTML = `R$${total.toFixed(2).replace('.',',')}`;
});

const numberRoomFormCreateAccommodation = formCreateAccommodation.querySelector("#number_room");
const capacityRoomFormCreateAccommodation = formCreateAccommodation.querySelector("#capacity_room");

formCreateAccommodation.addEventListener('submit', (evt) => {
    evt.preventDefault();

    setStatusInput(validateNumber(numberRoomFormCreateAccommodation), numberRoomFormCreateAccommodation);
    setStatusInput(validateNumber(capacityRoomFormCreateAccommodation), capacityRoomFormCreateAccommodation);
    setStatusInput(validateNumber(dailyPriceRoomFormCreateAccommodation), dailyPriceRoomFormCreateAccommodation);
    setStatusInput(validateDate(dateCheckinFormCreateAccommodation.value), dateCheckinFormCreateAccommodation);
    setStatusInput(validateDate(dateCheckoutFormCreateAccommodation.value), dateCheckoutFormCreateAccommodation);

    const checkin = parseLocalDate(dateCheckinFormCreateAccommodation.value);
    setStatusInput(validateDiffOfDate(checkin), dateCheckinFormCreateAccommodation);

    const checkout = parseLocalDate(dateCheckoutFormCreateAccommodation.value);
    setStatusInput(validateDiffOfDate(checkout), dateCheckoutFormCreateAccommodation);

    if (
        cpfGuests.quantCurr > 0
        && validateNumber(numberRoomFormCreateAccommodation) 
        && validateNumber(capacityRoomFormCreateAccommodation) 
        && validateNumber(dailyPriceRoomFormCreateAccommodation) 
        && validateDate(dateCheckinFormCreateAccommodation.value)
        && validateDate(dateCheckoutFormCreateAccommodation.value)
        && validateDiffOfDate(checkin)
        && validateDiffOfDate(checkout)
    ) 
    { 
        let isValid = true;

        const cpfGuests = formCreateAccommodation.querySelectorAll(".cpfGuests");
        if(cpfGuests){
            cpfGuests.forEach((el) => {
                setStatusInput(validateCPF(el.value), el);
    
                if(!validateCPF(el.value)){
                   isValid = false;
                }
            });

            if(!isValid){
                return false;
            }
        }

        formCreateAccommodation.submit();
        btnSubmitFormCreateAccommodation.disabled = true;
        btnSubmitFormCreateAccommodation.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Realizando...";
    }
});

document.querySelector("#btnCloseModalFormCreateAccommodations").addEventListener('click', () => {
    formCreateAccommodation.querySelector("#divContainerCpfGuests").innerHTML = "";

    const inputs = [
        numberRoomFormCreateAccommodation, 
        capacityRoomFormCreateAccommodation, 
        dailyPriceRoomFormCreateAccommodation, 
        dateCheckinFormCreateAccommodation, 
        dateCheckoutFormCreateAccommodation
    ];
    
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }

    cpfGuests.quantCurr = 0;
    cpfGuests.quantMax = 0;

    formCreateAccommodation.querySelector("#valueTotalDays").innerHTML = `R$0,00`;
});

const btnsOpenModalCreateAccommodation = [...document.querySelectorAll('.btnOpenModalCreateAccmmodation')];
if(btnsOpenModalCreateAccommodation){
    btnsOpenModalCreateAccommodation.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            
            const accordionViewRooms = document.querySelector("#accordionViewRooms");
            const tr = accordionViewRooms.querySelector(`#${idFull}`);

            const inputs = [
                numberRoomFormCreateAccommodation, 
                capacityRoomFormCreateAccommodation, 
                dailyPriceRoomFormCreateAccommodation, 
            ];
            
            const idsTds = ['#viewSearchNumberRoom', '#viewSearchCapacityRoom', '#viewSearchDailyPriceRoom'];
            
            for(let i=0;i<inputs.length; i++){
               inputs[i].value = tr.querySelector(idsTds[i]).innerHTML;
            }        
        });
    });
}

const formEditAccommodation = document.querySelector("#formEditAccommodation");
const btnSubmitFormEditAccommodation = formEditAccommodation.querySelector("#btnSubmitFormEditAccommodation");

const dateCheckinFormEditAccommodation = formEditAccommodation.querySelector("#date_checkin");
const dateCheckoutFormEditAccommodation = formEditAccommodation.querySelector("#date_checkout");
const dailyPriceRoomFormEditAccommodation = formEditAccommodation.querySelector("#daily_price_room");
const valueTotalDaysFormEditAccommodation = formEditAccommodation.querySelector("#valueTotalDays");

dateCheckinFormEditAccommodation.addEventListener('input', () => {
    const checkin = parseLocalDate(dateCheckinFormEditAccommodation.value);
    const checkout = parseLocalDate(dateCheckoutFormEditAccommodation.value);

    setStatusInput(validateDate(dateCheckinFormEditAccommodation.value), dateCheckinFormEditAccommodation);
    setStatusInput(validateDiffOfDate(checkin), dateCheckinFormEditAccommodation);
    
    if(!(validateDiffOfDate(checkin) && validateDiffOfDate(checkout))){
        valueTotalDaysFormEditAccommodation.innerHTML = `R$0,00`;
        return;
    }

    let quantDays = calculateDiffDays(checkin, checkout);
    let dailyPrice = parseFloat(dailyPriceRoomFormEditAccommodation.value.replace(',', '.')) || 0;
    
    let total = quantDays * dailyPrice;
    
    valueTotalDaysFormEditAccommodation.innerHTML = `R$${total.toFixed(2).replace('.',',')}`;
});

dateCheckoutFormEditAccommodation.addEventListener('input', () => {
    const checkin = parseLocalDate(dateCheckinFormEditAccommodation.value);
    const checkout = parseLocalDate(dateCheckoutFormEditAccommodation.value);

    setStatusInput(validateDate(dateCheckoutFormEditAccommodation.value), dateCheckoutFormEditAccommodation);
    setStatusInput(validateDiffOfDate(checkout), dateCheckoutFormEditAccommodation);

    if(!(validateDiffOfDate(checkout) && validateDiffOfDate(checkin))){
        valueTotalDaysFormEditAccommodation.innerHTML = `R$0,00`;
        return;
    }

    let quantDays = calculateDiffDays(checkin, checkout) || 0;
    let dailyPrice = parseFloat(dailyPriceRoomFormEditAccommodation.value.replace(',', '.')) || 0;
    
    let total = quantDays * dailyPrice;
    
    valueTotalDaysFormEditAccommodation.innerHTML = `R$${total.toFixed(2).replace('.',',')}`;
});

const numberRoomFormEditAccommodation = formEditAccommodation.querySelector("#number_room");
const capacityRoomFormEditAccommodation = formEditAccommodation.querySelector("#capacity_room");

formEditAccommodation.addEventListener('submit', (evt) => {
    evt.preventDefault();

    setStatusInput(validateNumber(numberRoomFormEditAccommodation), numberRoomFormEditAccommodation);
    setStatusInput(validateNumber(capacityRoomFormEditAccommodation), capacityRoomFormEditAccommodation);
    setStatusInput(validateNumber(dailyPriceRoomFormEditAccommodation), dailyPriceRoomFormEditAccommodation);
    setStatusInput(validateDate(dateCheckinFormEditAccommodation.value), dateCheckinFormEditAccommodation);
    setStatusInput(validateDate(dateCheckoutFormEditAccommodation.value), dateCheckoutFormEditAccommodation);

    const checkin = parseLocalDate(dateCheckinFormEditAccommodation.value);
    setStatusInput(validateDiffOfDate(checkin), dateCheckinFormEditAccommodation);

    const checkout = parseLocalDate(dateCheckoutFormEditAccommodation.value);
    setStatusInput(validateDiffOfDate(checkout), dateCheckoutFormEditAccommodation);

    if (
        validateNumber(numberRoomFormEditAccommodation) 
        && validateNumber(capacityRoomFormEditAccommodation) 
        && validateNumber(dailyPriceRoomFormEditAccommodation) 
        && validateDate(dateCheckinFormEditAccommodation.value)
        && validateDate(dateCheckoutFormEditAccommodation.value)
        && validateDiffOfDate(checkin)
        && validateDiffOfDate(checkout)
    ) 
    { 
        formEditAccommodation.submit();
        btnSubmitFormEditAccommodation.disabled = true;
        btnSubmitFormEditAccommodation.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Editando...";
    }
});

document.querySelector("#btnCloseModalFormEditAccommodation").addEventListener('click', () => {
    const inputs = [
        numberRoomFormEditAccommodation, 
        capacityRoomFormEditAccommodation, 
        dailyPriceRoomFormEditAccommodation, 
        dateCheckinFormEditAccommodation, 
        dateCheckoutFormEditAccommodation
    ];
    
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = '';    
        inputs[i].classList.remove('input-error');
        inputs[i].classList.remove('input-success');
    }

    formEditAccommodation.querySelector("#valueTotalDays").innerHTML = `R$0,00`;
});

const btnOpenModalEditAccmmodation = document.querySelectorAll('.btnOpenModalEdit');
if(btnOpenModalEditAccmmodation){
    btnOpenModalEditAccmmodation.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
        
            const inputs = [
                numberRoomFormEditAccommodation, 
                capacityRoomFormEditAccommodation, 
                dailyPriceRoomFormEditAccommodation, 
                dateCheckinFormEditAccommodation, 
                dateCheckoutFormEditAccommodation
            ];

            const idsTds = [
                '#viewSearchNumberRoom', 
                '#viewSearchCapacityRoom',
                '#viewSearchDailyPriceRoom', 
                '#viewSearchDateCheckin', 
                '#viewSearchDateCheckout'
            ];
            
            const accordionViewAccommodations = document.querySelector("#accordionViewAccommodations");
            const tr = accordionViewAccommodations.querySelector(`#${idFull}`); 

            for(let i=0;i<inputs.length; i++){
               if(inputs[i].id === 'date_checkin' || inputs[i].id === 'date_checkout'){
                    const [day, mes, year] = tr.querySelector(idsTds[i]).innerHTML.split('/');
                    inputs[i].value = `${year}-${mes}-${day}`;
                    continue;
                }

               inputs[i].value = tr.querySelector(idsTds[i]).innerHTML;
            }        

            valueTotalDaysFormEditAccommodation.innerHTML = `R$${tr.querySelector("#viewSearchTotalValue").innerHTML}`;
            formEditAccommodation.querySelector("#accommId").value = idFull.split("_")[1];
        });
    });
}


const formCanceledAccommodation = document.querySelector("#formCanceledAccommodation");
const btnOpenModalCanceled = document.querySelectorAll('.btnOpenModalCanceled');
if(btnOpenModalCanceled){
    btnOpenModalCanceled.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formCanceledAccommodation.querySelector("#accommId").value = idFull.split("_")[1];
        });
    });
}

const formEndAccommodation = document.querySelector("#formEndAccommodation");
const btnOpenModalEnd = document.querySelectorAll('.btnOpenModalEnd');
if(btnOpenModalEnd){
    btnOpenModalEnd.forEach(btn => {
        btn.addEventListener('click', (evt) => {
            const idFull = evt.target.id;
            formEndAccommodation.querySelector("#accommId").value = idFull.split("_")[1];
        });
    });
}

const btnCancel = formCanceledAccommodation.querySelector('#btnCancel');
let intervalo = null;
let segundos = 5;

const atualizarCronometro = () => {
    if (segundos > 0) 
    {
        segundos--;
        btnCancel.innerHTML = `Cancelar (${segundos})`;
    }
    if (segundos === 0) 
    {
        clearInterval(intervalo);
        intervalo = null;
        btnCancel.innerHTML = `Cancelar`;
        btnCancel.classList.remove('disabled'); 
        btnCancel.addEventListener('click', () => {
            btnCancel.innerHTML = "<div class='spinner-border spinner-border-sm me-2' role='status'><span class='visually-hidden'></span></div>Cancelando...";
        });
    }   
}

const iniciar = () => {
    segundos = 5;
    btnCancel.innerHTML = `Cancelar (${segundos})`;
    btnCancel.classList.add('disabled');
    if (intervalo === null) 
    {
        intervalo = setInterval(atualizarCronometro, 1000);
    }
}

const btns = document.querySelectorAll('.btnOpenModalCanceled');
if(btns){
    btns.forEach((el) => {
        el.addEventListener('click', iniciar);
    });
}

windowOnScroll(document.querySelector("#title-page"), document.querySelector("#btnTop"));