<?php
//secure this file
include("Functions.php");
session_start();
$function = new DatabaseClasses;
    if(isset($_GET['send-mail'])){
        $data = $_POST['data'];
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: RNR Digital Consultancy <rnrdigitalconsultancy.com>' . "\r\n";
        $receiver = $data[0];
        $subject =  $data[1];
        $message = $data[2];

        $result = mail($receiver,$subject,$message,$headers);
        print_r($result);
    }

    if(isset($_GET['validateEmail'])){
        $data = $_POST['data'];
        $query = $function->PDO(true,"SELECT count(*) FROM leads WHERE email = '{$data}'");
        print_r($count);
    }

    if(isset($_GET['set-leads'])){
        $id = $function->PDO_IDGenerator('leads','id');
        $date = $function->PDO_DateAndTime();
        $data = $_POST['data'];
        
        $name = $function->escape($data[0]['value']);
        $email = $function->escape($data[1]['value']);
        $phone = $function->escape($data[2]['value']);
        $skill = $function->escape($data[3]['value']);
        $address = $function->escape($data[4]['value']);
        $dream = $function->escape($data[5]['value']);

        $query = $function->PDO(false,"INSERT INTO leads(id,name,email,phone,address,skill,dream,`date`) VALUES ('{$id}',{$name},{$email},{$phone},{$skill},{$address},{$dream},'{$date}')");
        if($query->execute()){
            $subject =  "PSU Developers Guild - Account sign up";
            $message = "<div class='box' style='width: 800px; height: 550px; box-shadow: 0 0 0 0 rgba(0, 0, 0, 0), 0 0 0 rgba(0, 0, 0, 0); center; margin: 0 auto; ; border-radius: 10px; font-family: arial;'>
                        <div class='box' style='width: 500px; margin:auto; '>
                            <div style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius: 10px;overflow: hidden; border: 1px solid #ccc;'>
                                <div class='header' style='background: rgb(173, 55, 193); border-top-right-radius: 10px; border-top-left-radius: 10px; padding: 50px 0px 50px 0px; text-align: center;'>
                                    <img src='http://developers.psu-csit.com/images/side.png' style='width: 100px; ' align='center'>
                                </div>
                                <div class='container' style='text-align: center; background: white;padding: 50px;'>
                                    <div style=' font-size: 90px; font-family: Freestyle Script;'>
                                        Thank you!
                                    </div>
                                    <div style='text-align:left'>
                                        <ul type='none'>
                                            <li>Name: {$name}</li>
                                            <li>Email: {$email}</li>
                                            <li>Phone: {$phone}</li>
                                            <li>Address: {$address}</li>
                                            <li>Skill: {$skill}</li>
                                            <li>Goal: {$dream}</li>
                                        </ul>
                                    </div>
                                    <div style='font-size: 20px; margin-top: 40px; text-transform: initial;'>
                                        <p>Please keep intouch with this email and website for announcement.<br/>For inquiries, please email us at <a href='mailto:info@rnrdigitalconsultancy.com'>info@rnrdigitalconsultancy.com</a></p>
                                    </div>
                                    <small><i>*Thank you for your trust. Your information will be kept confidential and secured. </i></small>
                                </div>
                            </div>
                        </div>
                    </div>";

            $mail = $function->mail($email.', rufo.gabrillo@gmail.com, info@rnrdigitalconsultancy.com',$subject,$message);
            echo 1;
        }
        else{
            $Data = $query->errorInfo();
            print_r($Data);
        }
    }

?>