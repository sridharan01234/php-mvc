const toggleForm = () => {
  const container = document.querySelector(".container");
  container.classList.toggle("active");
};

var password = "";

function ValidatePassword() {
  password = document.getElementById("NewPassword").value;
  function containsLowercase(input) {
    var lowercaseRegex = /[a-z]/;

    return lowercaseRegex.test(input);
  }
  function containsUppercase(input) {
    var uppercaseRegex = /[A-Z]/;

    return uppercaseRegex.test(input);
  }
  function containsNumeric(input) {
    var numericRegex = /[0-9]/;

    return numericRegex.test(input);
  }
  function containsSpecialCharacter(input) {
    var specialCharacterRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    return specialCharacterRegex.test(input);
  }

  $("#Length").removeClass(
    password.length > 6 ? "glyphicon-remove" : "glyphicon-ok"
  );
  $("#Length").addClass(
    password.length > 6 ? "glyphicon-ok" : "glyphicon-remove"
  );
  if (containsLowercase(password)) {
    document.getElementById("LowerCase").style.color = "green";
  } else {
    document.getElementById("LowerCase").style.color = "red";
  }
  if (containsNumeric(password)) {
    document.getElementById("Numbers").style.color = "green";
  } else {
    document.getElementById("Numbers").style.color = "red";
  }
  if (containsUppercase(password)) {
    document.getElementById("UpperCase").style.color = "green";
  } else {
    document.getElementById("UpperCase").style.color = "red";
  }
  if (containsSpecialCharacter(password)) {
    document.getElementById("Symbols").style.color = "green";
  } else {
    document.getElementById("Symbols").style.color = "red";
  }
}

$(document).ready(function () {
  $("#NewPassword").on("keyup", ValidatePassword);
});
var confirmPasswordField = document.getElementById("ConfirmPassword");

confirmPasswordField.addEventListener("input", function () {
  document.getElementById("Match").style.display = "block";
  if (password === confirmPasswordField.value) {
    document.getElementById("Match").style.color = "green";
    document.getElementById("Match").innerHTML = "Password Matched";
    document.getElementById("SignUp-btn").style.cursor = "pointer";
  } else {
    document.getElementById("Match").style.color = "red";
    document.getElementById("Match").innerHTML = "Password Does Not Match";
    document.getElementById("SignUp-btn").style.cursor = "not-allowed";
  }
});

document.getElementById("Email").addEventListener("input", function () {
  document.getElementById("Valid-Email").style.display = "block";
  var email = document.getElementById("Email").value;
  var booking_email = email.toString();
  console.log(booking_email);
  if (
    booking_email == "" ||
    booking_email.indexOf("@") == -1 ||
    booking_email.indexOf(".") == -1
  ) {
    document.getElementById("Valid-Email").style.color = "Red";
    document.getElementById("Valid-Email").innerHTML = "InValid Email";
  } else {
    document.getElementById("Valid-Email").style.color = "green";
    document.getElementById("Valid-Email").innerHTML = "Valid Email";
  }
});

function profileEntry() {
  document.getElementById('entry-form').style.display = "block";
}

var check = false;

function changeVal(el) {
  var qt = parseFloat(el.parent().children(".qt").html());
  var price = parseFloat(el.parent().children(".price").html());
  var eq = Math.round(price * qt * 100) / 100;
  
  el.parent().children(".full-price").html( eq + "€" );
  
  changeTotal();			
}

function changeTotal() {
  
  var price = 0;
  
  $(".full-price").each(function(index){
    price += parseFloat($(".full-price").eq(index).html());
  });
  
  price = Math.round(price * 100) / 100;
  var tax = Math.round(price * 0.05 * 100) / 100
  var shipping = parseFloat($(".shipping span").html());
  var fullPrice = Math.round((price + tax + shipping) *100) / 100;
  
  if(price == 0) {
    fullPrice = 0;
  }
  
  $(".subtotal span").html(price);
  $(".tax span").html(tax);
  $(".total span").html(fullPrice);
}

$(document).ready(function(){
  
  $(".remove").click(function(){
    var el = $(this);
    el.parent().parent().addClass("removed");
    window.setTimeout(
      function(){
        el.parent().parent().slideUp('fast', function() { 
          el.parent().parent().remove(); 
          if($(".product").length == 0) {
            if(check) {
              $("#cart").html("<h1>The shop does not function, yet!</h1><p>If you liked my shopping cart, please take a second and heart this Pen on <a href='https://codepen.io/ziga-miklic/pen/xhpob'>CodePen</a>. Thank you!</p>");
            } else {
              $("#cart").html("<h1>No products!</h1>");
            }
          }
          changeTotal(); 
        });
      }, 200);
  });
  
  $(".qt-plus").click(function(){
    $(this).parent().children(".qt").html(parseInt($(this).parent().children(".qt").html()) + 1);
    
    $(this).parent().children(".full-price").addClass("added");
    
    var el = $(this);
    window.setTimeout(function(){el.parent().children(".full-price").removeClass("added"); changeVal(el);}, 150);
  });
  
  $(".qt-minus").click(function(){
    
    child = $(this).parent().children(".qt");
    
    if(parseInt(child.html()) > 1) {
      child.html(parseInt(child.html()) - 1);
    }
    
    $(this).parent().children(".full-price").addClass("minused");
    
    var el = $(this);
    window.setTimeout(function(){el.parent().children(".full-price").removeClass("minused"); changeVal(el);}, 150);
  });
  
  window.setTimeout(function(){$(".is-open").removeClass("is-open")}, 1200);
  
  $(".btn").click(function(){
    check = true;
    $(".remove").click();
  });
});