<?php

include_once("connect.php");

if(isset($_POST["name"]))
{
 $name = cleanData($_POST["name"]);
 $email = cleanData($_POST['email']);
 $message = cleanData($_POST['message']);
 $query = "INSERT INTO `queries`(`name`, `email`, `message`) VALUES ('$name','$email','$message')";
 $res= $mysqli->query($query);
  if(!$res)
          echo $mysqli->error;
  else
   {
    $res= mailc($name,$message,$email);
    if($res)
      echo 1;
    else echo 0;
  }
}
function cleanData($data)
    {
        //$data=mysql_real_escape_string($data);
        $data=trim($data);
        $data=stripcslashes($data);
        $data=htmlspecialchars($data);
        $data=strip_tags($data);
        return $data;
    }
 function mailc($name , $tn, $e)
 {
  $to = "sardanaaman@gmail.com";
  $subject = "new codeplay Query by - ".$name ;
  $contact_email="support@csivit.com";
  $fr="From: $contact_email";
  $headers="MIME-Version: 1.0\r\n";
  $headers.= "Content-type: text/html; charset=ISO-8859-1\r\n";
  $headers.= $fr . "\r\n"; 
  $message = "<table style='width:500px;padding:0;margin:0;'>
                                    <tr>
                                        <td>    
                                               query by $name <br>
                                               Email: $e <br>
                                               Query: $tn <br> 
                                        </td>
                                    </tr>
                                </table>";
  $res = mail($to,$subject,$message,$headers);
  if ($res)
    return true;
 }
?>
