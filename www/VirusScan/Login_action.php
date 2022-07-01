<?php
session_start();
$value = $_POST["username"];
$myUser = $myPass = "";
$serUser = $serPass = "";
$flag = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $myUser = val_input($_POST["username"]);
    $myPass = val_input($_POST["password"]);
    $myFile = fopen("./filescan/account.txt", "r") or die("Unable to open file!");
    while(!feof($myFile)) {
        $line = fgets($myFile);
        $serUser = get_user($line);
        $serPass = get_pass($line);
        if(checkData($myUser, $serUser, $myPass, $serPass))
            {
                setcookie("user", $value, time() + (86400 * 10), '/');
                $_SESSION['username'] = $_POST["username"];
                $_SESSION['password'] = $_POST["password"];
                dangnhapthanhcong();
                //print_r($_SESSION);
                $flag = 1;
                break;
            }
    }
    fclose($myFile);
    if($flag==0)
    {
        dangnhapthatbai();
    }
}

//check data
function checkData($u1,$u2,$p1,$p2){
    if($u1==$u2 && $p1==$p2)
    {
        return true;
    }
    else
    {
        return false;
    }
}

//covert data funtion
function val_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

//lay user vs matkhau
function get_user($le)
{
    $u ='';
    for ($i=0; $i < strlen($le); $i++) { 
        if($le[$i]==",")
        {
            return $u;
        }
        else
        {
            $u = $u .$le[$i];
            
        }
    }
}
function get_pass($le)
{
    $p ='';
    $dem = 0;
    for ($i=0; $i < strlen($le); $i++) { 
        if($le[$i]==',' && $dem == 0)
        {
            $dem++;
        }
        elseif($le[$i]==',' && $dem == 1)
        {
            return $p;
        }
        elseif($dem==1)
        {
            $p = $p .$le[$i];
        }

    }
}

//so sanh mat khau
function Comparepass($pass1, $pass2){
 if ($pass1 == $pass2){
     return true;
 }
 return false;
}
//so sanh ten dang nhap
function Compareuser($u1, $passu22)
{
    if ($u1 == $u2){
        return true;
    }
    return false;
}

function dangnhapthatbai()
{
    $pagecontent = <<< EOPAGE
     <!DOCTYPE html>
     <html>
     <head></head>
     <body>
     <script language="javascript" type="text/javascript">
     alert("Your Name OR Your Password Is Incorrect. Please try again!");
     </script>
     </body>
     </html>
     EOPAGE;
     echo $pagecontent;
     $myfile = fopen("./index.html", "r") or die("Unable to open file!");
     while(!feof($myfile)) {
         $pagecontent = fgets($myfile);
         echo $pagecontent;
       }
     fclose($myfile);

}
function dangnhapthanhcong()
{
    $pagecontent = '';
    $myfile = fopen("./home.html", "r") or die("Unable to open file!");
    while(!feof($myfile)) {
        $pagecontent = fgets($myfile);
        echo $pagecontent;
    }
    fclose($myfile);

}

?>