<?php
session_start();
$report='null';


if(isset($_FILES['myFile']['name']))
{
    //File info
    $fileName = $_FILES['myFile']['name'];
    $filetmpName = $_FILES['myFile']['tmp_name'];
    $fileEnd = substr($fileName, strrpos($fileName, '.')+1);
    $fileSize = $_FILES['myFile']['size'];
    $fileType = $_FILES['myFile']['type'];
    $filemd5   =  md5_file($filetmpName);
    $filesha1   =  sha1_file($filetmpName);

    //Place to write file to
    //$up_path = '../../../../clamav/';
    //s$scan_path = $up_path .$fileName;
    $scan = 'MULTISCAN ' .$filetmpName;
    $report = Scan($scan);
    $ver = Scan('VERSION');
    //print_r($_SESSION);
    //     if (move_uploaded_file($filetmpName, $scan_path)){
    //         $message = 'SCAN ' .$filetmpName;
    //         $report = Scan($message);
    //     }
    //     else{
    //         echo "Failed";
    //     }
}



function Scan($message){
    //create the socket
    if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        
        die("Couldn't create socket: [$errorcode] $errormsg <br>");
    }

    //connect socket to server
    if(!socket_connect($sock , '127.0.0.1' , 3310))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        
        die("Could not connect: [$errorcode] $errormsg \n");
    }

    //send the message to the server
    if (!socket_send($sock, $message, strlen($message), 0))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);

        die("Could not send data: [$erroecode] $errormsg <br>");
    }

    //Now receive reply from server
    if(socket_recv ( $sock , $buf , 2045 , 0 ) === FALSE)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        
        die("Could not receive data: [$errorcode] $errormsg \n");
    }
    $repor = $buf;
    socket_close($sock);
    return $repor;
}
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="./css/bootstrap.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function checkdn()
            {
                document.getElementById('user').innerHTML = "<?php echo $_SESSION['username']; ?>" //getCookie('user');
            }
            function getCookie(cname) {
                let name = cname + "=";
                let ca = document.cookie.split(';');
                for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
                }
                return "";
            }
            function dx(){
                sessionStorage.clear();
            }
        </script>
    </head>
    <body onload="checkdn();">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-2">
            <a class="navbar-brand" href="./home.html"><img src="./images/virus.jpg" alt="Logo" style="width: 40px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
          <div class="col-sm-10">
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link" href="./home.html">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Blog</a>
                    <div class="dropdown-menu">
                        <a target="_blank" class="dropdown-item text-info" href="https://itbloginfo.com/8-trang-web-quet-va-diet-virus-truc-tuyen-mien-phi-tot-nhat/">1.OnlScanners</a>
                        <a target="_blank" class="dropdown-item text-info" href="https://vi.safetydetectives.com/blog/">2.SaftyDetective</a>
                        <a target="_blank" class="dropdown-item text-info" href="https://www.gteltsc.vn/blog/tong-hop-phan-tich-nghien-cuu-ma-doc-industroyercrashoverride-p1-9677.html">3.IndustroyerMalware</a>
                        <a target="_blank" class="dropdown-item text-info" href="https://voz.vn/t/phan-tich-ky-thuat-dong-ma-doc-moi-duoc-su-dung-de-tan-cong-chuoi-cung-ung-nham-vao-ban-co-yeu-chinh-phu-viet-nam-cua-nhom-tin-tac-panda-tq-phan-1.234279/">4.VOZ</a>
              
              
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Releases</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li> 
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="collapse navbar-collapse col-md-2" id="collapsibleNavbar">
        <a href="#" style="color:whitesmoke; padding: 5px; text-align: center; margin-top: 2px;" id="user">
        </a>
        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
          <img id="avatar" src="<?php echo './images/' .$_SESSION['username'] .'.png' ?>" alt="avatar" style="width: 30px;">
        </a>
        <div class="dropdown-menu">
          <hr>
          <a onclick="return dx();" class="nav-link" href="index.html">Log out</a>
        </div>        
      </div>
    </nav>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                        <a class="nav-link active" href="#result">Result</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#detail">Detail</a>
                        </li>
                    </ul>
                </div>
            </div>
            <br>
        <!-- Tab panes -->
            <div class="tab-content mb-3 text-center justify-content-center">
                <div id="result" class=" tab-pane active text-left">
                    <p class="text-danger">
                        <?php
                            $kp = substr( $report, strrpos( $report, ': ' ) + 1);
                            echo '<span class="text-info">The "' .$fileName .'" file is: </span>' .$kp;
                        ?>
                        <br>
                        <?php
                            echo '<span class="text-info">Engine version: </span>' .$ver;
                        ?>

                    </p>
                </div>
                <div id="detail" class="col-md-12 tab-pane fade text-left text-danger">
                    <div class="">
                        <span class="text-info">File name: </span>
                        <?php
                            echo $fileName ;
                        ?>
                    </div>
                    <div>
                        <span class="text-info">File size: </span>
                         
                        <?php
                            echo $fileSize .'<span class="text-info"> (bytes)</span>' ;
                        ?>
                    </div>
                    <div>
                        
                        <span class="text-info">File type: </span>
                        <?php
                            echo $fileType;
                        ?>
                    </div>
                    <div>
                        <span class="text-info">File MD5: </span>
                        <?php
                            echo $filemd5;
                        ?>
                    </div>
                    <div>
                        
                        <span class="text-info">File SHA1: </span>
                        <?php
                            echo $filesha1;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        
        <script>
            $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
            $('.nav-tabs a').on('shown.bs.tab', function(event){
                var x = $(event.target).text();         // active tab
                var y = $(event.relatedTarget).text();  // previous tab
                $(".act span").text(x);
                $(".prev span").text(y);
            });
            });
        </script>
    </body>
</html>