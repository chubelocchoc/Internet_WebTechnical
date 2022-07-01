<?php
    // define variables and set to empty values
    $firstName = $email = $userName = $password = $state = $country = $remarks = "";
    $flag = 0;
    $userName = val_input($_POST["userName"]);
    $firstName = val_input($_POST["firstName"]);
    $email = val_input($_POST["email"]);
    $password = val_input($_POST["password"]);
    $state = val_input($_POST["state"]);
    $country = val_input($_POST["country"]);
    $remarks = val_input($_POST["remarks"]);
    $fileName = $_FILES['avatar']['name'];
    $filetmpName = $_FILES['avatar']['tmp_name'];
    move_uploaded_file($filetmpName, './images/' .$userName . '.png');

    //covert data funtion
    function val_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //create an account file
    $myfile = fopen("./filescan/account.txt", "a") or die("Unable to open file!"); 
    fclose($myfile);

    //open account file to read
    $myfile = fopen("./filescan/account.txt", "r") or die("Unable to open file!");
    while(!feof($myfile)) {
        $line = fgets($myfile);
        $serUser = get_user($line);
        if(checkData($userName, $serUser))
            {
                $flag = 1;
                
                break;
            }
    }
    fclose($myfile);
    if($flag==1)
        {
            Co();
        }
        else
        {
            KhongCo($userName,$password,$email,$firstName,$state,$country,$remarks);
        }
    



    function Co(){
        $pagecontent = <<< EOPAGE
        <!DOCTYPE html>
        <html>
        <head></head>
        <body>
        <script language="javascript" type="text/javascript">
        alert("The UserName already exists, please choose another one!");
        </script>
        </body>
        </html>
        EOPAGE;
        echo $pagecontent;
        $cofile = fopen("./SignUp.html", "r") or die("Unable to open file!");
        while(!feof($cofile)) {
            $pagecontent = fgets($cofile);
            echo $pagecontent;
          }
        fclose($cofile);
    }





    function KhongCo($userName,$password,$email,$firstName,$state,$country,$remarks){
        $myfile = fopen("./filescan/account.txt", "a") or die("Unable to open file!");
        $txt =",";
        fwrite($myfile, $userName .$txt .$password .$txt .$email .$txt .$firstName .$txt .$state .$txt .$country .$txt .$remarks);
        fwrite($myfile, "\n");
        fclose($myfile);
        $pagecontent = <<< EOPAGE
        <!DOCTYPE html>
        <html>
        <head></head>
        <body>
        <script language="javascript" type="text/javascript">
        alert("Successfully");
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


    
    function checkData($u1,$u2){
        if($u1==$u2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    
?>