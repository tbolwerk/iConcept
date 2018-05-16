function confirmation(firstField, confirmationField) {
  if (document.getElementById(firstField).value != document.getElementById(confirmationField).value) {
    document.getElementById(confirmationField).setCustomValidity("Velden komen niet overeen");
  } else {
    document.getElementById(confirmationField).setCustomValidity("");
  }
}

function upperCaseF(a){
  setTimeout(function(){
    a.value = a.value.toUpperCase();
  }, 1);
}
