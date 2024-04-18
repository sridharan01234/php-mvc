function validateLoginForm() {
  if (document.getElementById('loginEmail').value == "" || document.getElementById('loginPassword').value == "" ) {
    alert("All the Fields must be Filled");
    return false;
  }
}