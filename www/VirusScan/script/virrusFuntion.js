//dangnhap trang index
function DangNhap()
{
    let tendn = document.getElementById('username').value;
    let matkhau = document.getElementById('password').value;
    if(tendn == '' || matkhau == ''){
      alert("Enter your username and password");
      document.getElementById("username").focus();
      return false;
    }
    else{
      document.getElementById('dnForm').action = './Login_action.php';
      return true;
    }
}

//check mail
function ThongBao()
{
    let tendn = document.getElementById('uname').value;
    let matkhau = document.getElementById('email').value;
    if(tendn == '' || matkhau == ''){
      document.getElementById("uname").focus();
      return false;
    }
    else if(checkMail(matkhau))
        {
            alert("Please enter your mail correctly");
            document.getElementById("email").focus();
            return false;
        }
    else{
      alert("The new password have been sent to your email!");
      return true;
    }
}     
function checkMail(myMail)
{
    for (let index = 0; index < myMail.length; index++) {
         if(myMail[index]=='@')
         {
             return false;
         }
    }
    return true;
}