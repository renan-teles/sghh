//Validate Functions
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

export const validate = (input) => {
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

export const validateSelect = (selects, input) => {
  let valueInput = input.value.trim();  
   
  if(valueInput === ""){
    return false;
  }

  return selects.includes(valueInput);
} 

export const setStatusInput = (isValid, input) => {
  input.classList.toggle('input-error', !isValid);
  input.classList.toggle('input-success', isValid);
  return isValid;
}