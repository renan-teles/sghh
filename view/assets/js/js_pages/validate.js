export const validateNumber = (input) => {
  let inputValue = input.value.trim();
    
  if (inputValue === "") {
    return false;
  }
    
  inputValue = inputValue.replace(/\./g, '').replace(',', '.');
    
  const n = Number(inputValue);
  if (isNaN(n) || n <= 0) {
    return false;
  }

  return true;
}

export const defaultValidate = (input) => {
  const inputValue = input.value.trim();
  let aproved = true;
    
  const regex = /[<>=\-@#$%&*{}[\]\\\/]/;
    
  if (inputValue === "") {
    aproved = false;
  }
    
  if (regex.test(inputValue)) {
    aproved = false;
  }
    
  const numericValue = Number(inputValue.replace(/\./g, '').replace(',', '.'));
    
  if (!isNaN(numericValue)) {
    if (numericValue < 0) {
      aproved = false;
    }
  }
    
  return aproved;
}

export const validateDate = (input) => {
  const regex = /^(\d{4})-(\d{2})-(\d{2})$/;
  return regex.test(input);
}

export const validateSelect = (selects, input) => {
  let valueInput = input.value.trim();  
   
  if(valueInput === ""){
    return false;
  }

  return selects.includes(valueInput);
} 

export const validateEmail = (email) => {
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return emailRegex.test(email.value.trim());
}

export const validateName = (name) => {
  const nameRegex = /^[a-zA-ZÀ-ÿ\s]+$/;
  return nameRegex.test(name.value.trim()) && name.value.trim().length >= 4;
}

export const validateCPF = (cpf) => {
  cpf = cpf.replace(/[^\d]+/g, '');

  if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

  let soma = 0;
  for (let i = 0; i < 9; i++) {
      soma += parseInt(cpf.charAt(i)) * (10 - i);
  }

  let resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.charAt(9))) return false;

  soma = 0;
  for (let i = 0; i < 10; i++) {
      soma += parseInt(cpf.charAt(i)) * (11 - i);
  }

  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;

  return resto === parseInt(cpf.charAt(10));
}

export const validateTelephone = (telefone) => {
  const numeros = telefone.replace(/\D/g, '');

  if (!(numeros.length === 10 || numeros.length === 11)) return false;

  const ddd = numeros.substring(0, 2);
  const inicial = numeros[2];

  if (parseInt(ddd) < 11 || parseInt(ddd) > 99) return false;

  if (numeros.length === 11 && inicial !== '9') return false;

  if (numeros.length === 10 && !['2', '3', '4', '5'].includes(inicial)) return false;

  return true;
}

export const validatePassword = (password) => {
  const regex = /^[\p{L}\p{N}]+$/u;
  return password.value.trim().length > 6 && regex.test(password.value);
}

export const setStatusInput = (isValid, input) => {
  input.classList.toggle('input-error', !isValid);
  input.classList.toggle('input-success', isValid);
  return isValid;
}