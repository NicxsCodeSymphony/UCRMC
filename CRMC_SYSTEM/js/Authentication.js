const visible = document.getElementById("visible");
const invisible = document.getElementById("invisible");
const gret = document.getElementById("gret");
const gret1 = document.getElementById("gret1");
const teacher = document.querySelector(".teacher");
const student = document.querySelector(".student");
const footer = document.querySelector(".footer");

teacher.addEventListener("click", () =>{
  window.location.href = "LogIn-Page.php";
})



var passwordPrompt = false;

document.addEventListener('keydown', function(event){
  if(event.key === 'PageUp' && !passwordPrompt){
    passwordPrompt = true;
    setTimeout(function (){
      var enteredPassword = prompt("Enter the Password: ");
      passwordPrompt = false;

      var correntPassword = "iamspeed";
      if(enteredPassword === correntPassword){
        alert("password is corrent!")
        window.location.href = "index.php";
      }else {
        alert("incorrent");
      }
    }, 1000);
  }
})
