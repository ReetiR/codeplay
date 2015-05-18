<?php 
include_once("connect.php"); 
if(!empty($_REQUEST['mode']))
{

  $name = cleanData($_POST['q1']);
  $reg_no = cleanData($_POST['q2']);
  $lreg_no = cleanData($_POST['q3']);
  $ph_no = cleanData($_POST['q5']);
  $email = cleanData($_POST['q4']);
  $team_name = cleanData($_POST['q8']);
  $p_desc = cleanData($_POST['q9']);
  $track = cleanData($_POST['q7']);
  $requirements = cleanData($_POST['q10']);
  $history = cleanData($_POST['q11']);
  $color = cleanData($_POST['q6']);
  $pdate=date("Y-m-d h:i:s");

  $sql_check = $mysqli->query("SELECT reg_no FROM registrations WHERE reg_no='$reg_no' AND ph_no='$ph_no' AND email='$email'");
        //$qry_check=$mysqli->query($sql_check);
  $finalcount= $sql_check->num_rows;
  if($finalcount == '1')
  {
   header("Location:register.html#openModal1");
  }
  else
  {

      $sql_ch = $mysqli->query("SELECT * FROM team_leader WHERE reg_no='$lreg_no'");
      $fetch_data= $sql_ch->fetch_array();
      $finalcount= $sql_ch->num_rows;
      $t_id= $fetch_data['id'];
      $ptrack= $fetch_data['track'];
      if($finalcount == '1')
      {
        $count= $fetch_data['count'];
        if($count<5)
        {
        $count++;
        $query = "UPDATE team_leader SET 
        `count`='$count'
        WHERE reg_no= '$lreg_no';";
        $res= $mysqli->query($query);
        $query = "INSERT INTO registrations SET 
        `reg_no`='$reg_no',
        `name`='$name',
        `email`='$email',
        `ph_no`='$ph_no',
        `color`='$color',
        `team_id`= '$t_id',
        `description`='$p_desc',
        `requirements`='$requirements',
        `history`='$history',
        `created_at`='".$pdate."';"; 
        $res= $mysqli->query($query);
        if(!$res)
         echo $mysqli->error;
       else
         {
          header("Location:register.html#openModal");
        }
        }
        else
          header("Location:register.html#openModal2");
      }
      else
      {
        $query = "INSERT INTO team_leader SET 
        `reg_no`='$lreg_no',
        `team_name`='$team_name',
        `track`= '$track';";
        $res= $mysqli->query($query);
      $sql_ch = $mysqli->query("SELECT * FROM team_leader WHERE reg_no='$lreg_no'");
      $fetch_data= $sql_ch->fetch_array();
      $t_id= $fetch_data['id'];
        $query = "INSERT INTO registrations SET 
        `reg_no`='$reg_no',
        `name`='$name',
        `email`='$email',
        `ph_no`='$ph_no',
        `color`='$color',
        `team_id`= '$t_id',
        `description`='$p_desc',
        `requirements`='$requirements',
        `history`='$history',
        `created_at`='".$pdate."';"; 
        $res= $mysqli->query($query);
        if(!$res)
         echo $mysqli->error;
       else
         {
          mailc($name,$team_name, $track, $p_desc);
          header("Location:register.html#openModal");
        }
      }
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
function mailc($name , $tn, $track, $p_desc)
{
  $to = "sardanaaman@gmail.com";
  $subject = "new codeplay registration - ".$name ;
  $contact_email="support@csivit.com";
  $fr="From: $contact_email";
  $headers="MIME-Version: 1.0\r\n";
  $headers.= "Content-type: text/html; charset=ISO-8859-1\r\n";
  $headers.= $fr . "\r\n"; 
  $message = "<table style='width:500px;padding:0;margin:0;'>
  <tr>
  <td>    
  New registration <br> team : $tn <br> 
  track: $track <br>
  idea: $p_desc <br>
  by $name   
  </td>
  </tr>
  </table>";
  $res = mail($to,$subject,$message,$headers);
}
?>
