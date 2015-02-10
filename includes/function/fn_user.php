<?php
    /**
    * put your comment there...
    * 
    * @param mixed $name
    * @param mixed $condition_arr
    * @param mixed $tbl
    * @param mixed $post_value_arr
    * @param mixed $message
    * @return int
    */
    function user_add($name,$condition_arr,$tbl,$post_value_arr,$message)
    {
        include_once("ModelClass.php");
        $ObModel = new Model();
        $sql = "SELECT ".$name." FROM ".$tbl." WHERE ";

        foreach($condition_arr as $key=>$value)
        {
            $sql .= $key ."='". $value ."' or ";
        }
        
        $sql = substr($sql,0,-4);
        
        $res = mysql_query($sql) or die(mysql_error());
        $num = mysql_num_rows($res);

        if($num > 0)
        {
            $msg = false;
        }
        else
        {
            $sql0 = "INSERT INTO ".$tbl." (";

            foreach($post_value_arr as $key=>$value)
            {
                $sql0 .= $key.",";
            }
            $sql0 = substr($sql0,0,-1);
            $sql0 .= ") VALUES (";

            foreach($post_value_arr as $key=>$value)
            {
                $sql0 .= "'".$value."',";
            }
            $sql0 = substr($sql0,0,-1);
            $sql0 .= ")";

            $res0 = mysql_query($sql0) or die(mysql_error());
            if(mysql_insert_id()!="")
            {
                $msg =  mysql_insert_id();            
            }
        }

        return $msg;
    }

    /**
    * put your comment there...
    * 
    * @param mixed $to
    * @param mixed $Subject
    * @param mixed $body
    * @return mixed
    */
    function user_mail($to,$Subject,$body) 
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=\"iso-8859-1\""."\r\n" ;  
        $headers .= "From: noreply@smartguidance.org \r\n";
        $headers .="Reply-To:noreply@smartguidance.org \r\n";
        $headers .="Return-Path: helpsmartguidance@gmail.com\r\n";    
        $headers .="Bcc: helpsmartguidance@gmail.com \r\n";

        if(!mail($to, $Subject, $body, $headers)) 
        {
            return 0;
        }
        else 
        {
            return 1;
        }
    }

    /**
    * put your comment there...
    * 
    */
    function user_list()
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "SELECT * FROM `template_user` ORDER BY `register_date` DESC";
        $res_s = mysql_query($sql_s);
        $records = @mysql_num_rows($res_s);
        if($records > 0)
        {
            while($row = mysql_fetch_array($res_s)) 
            {
                $result[] = $row;
            }	
        }
        return $result;	
    }

    /**
    * put your comment there...
    * 
    */
    function user_search()
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "SELECT * FROM `users` WHERE ";
        if($_POST['industry']!="" && $_POST['age']!="")
        {
            $sql_s .="`industry`='".$_POST['industry']."' AND `age`='".$_POST['age']."'";
        }
        else if($_POST['industry']!="") 
            {
                $sql_s .="`industry`='".$_POST['industry']."'";
            }
            else if($_POST['age']!="") 
                {
                    $sql_s .="`age`='".$_POST['age']."'";
                }
                $sql_s .=" ORDER BY `id` ASC";
        $res_s = mysql_query($sql_s);
        $records = @mysql_num_rows($res_s);
        if($records > 0) 
        {
            while($row = mysql_fetch_array($res_s)) 
            {
                $result[] = $row;
            }	
        }

        return $result;	
    }

    /**
    * put your comment there...
    * 
    * @param mixed $userId
    */
    function delete_user($userId)
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "DELETE FROM `template_user` WHERE  id=".$userId;
        $res_s = mysql_query($sql_s);
        if($res_s)
        {
            $result =1;
        } 
        else
        {
            $result =0; 
        }   

        return $result;    
    }

    /**
    * put your comment there...
    * 
    * @param mixed $userId
    * @return array
    */
    function user_getval($userId)
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "SELECT id, usernm_email, first_name,last_name, register_date, company_name, address1, address2, city, state, zipcode, country, phone, securityq_answer FROM `template_user` WHERE id=".$userId ;
        $res_s = mysql_query($sql_s);
        $records = @mysql_num_rows($res_s);
        if($records > 0) {
            while($row = mysql_fetch_array($res_s)) 
            {
                $result[] = $row;
            }    
        }
        return $result;    

    }

    /**
    * put your comment there...
    * 
    * @param mixed $userid
    * @param mixed $firstname
    * @param mixed $lastname
    * @param mixed $companyname
    * @param mixed $address1
    * @param mixed $address2
    * @param mixed $city
    * @param mixed $state
    * @param mixed $zip
    * @param mixed $country
    * @param mixed $phone
    */
    function edit_user($userid,$firstname,$lastname,$companyname,$address1,$address2,$city,$state,$zip,$country,$phone)
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "UPDATE `template_user` SET `first_name`='".$firstname."',`last_name`='".$lastname."',`company_name`='".$companyname."',`address1`='".$address1."',`address2`='".$address2."',`city`='".$city."',`state`='".$state."',`zipcode`='".$zip."',`country`='".$country."',`phone`='".$phone."' WHERE  `id`=".$userid;

        $res_s = mysql_query($sql_s);
        if($res_s)
        {
            $result =1;
        } 
        else
        {
            $result =0; 
        }   

        return $result;

    }

    /**
    * put your comment there...
    * 
    */

    function user_csv()
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $filename = "result.csv";
        $fp = fopen($filename, "w");

        $sql_s = "SELECT first_name,last_name,register_date,usernm_email,company_name,address1,address2,city,state,zipcode,country,phone FROM `template_user` WHERE `is_admin`=0 ";
        $sql_s .=" ORDER BY `register_date` DESC";
        $res_s = mysql_query($sql_s);
        $row = mysql_fetch_assoc($res_s);
        $line = "";
        $comma = "";
        foreach($row as $name => $value) {
            $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
            $comma = ",";
        }
        $line .= "\n";
        fputs($fp, $line);

        // remove the result pointer back to the start
        mysql_data_seek($res_s, 0);

        $records = @mysql_num_rows($res_s);
        if($records > 0) {

            while($row = mysql_fetch_assoc($res_s)) {
                $line = "";
                $comma = "";
                foreach($row as $value) {
                    $line .= $comma . '"' . str_replace('"', '""', $value) . '"';
                    $comma = ",";
                }

                $line .= "\n";
                fputs($fp, $line);

            }
        }
        fclose($fp);	


        header('Content-type: application/csv');
        header("Content-Disposition: inline; filename=".$filename);
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");	
        readfile($filename);
    }

    /**
    * put your comment there...
    * 
    * @param mixed $tbl
    * @param mixed $field_condition
    * @param mixed $id
    * @param mixed $select_value
    * @return array
    */
    function user_edit1($tbl,$field_condition,$id,$select_value)
    {
        include_once("ModelClass.php");
        $ObModel = new Model();
        $select=$ObModel->GetValue($select_value,$tbl,$field_condition,$id);
        if($select!="")
        {
            return $select;
        }	

    }

    /**
    * put your comment there...
    * 
    */
    function mail_list()
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "SELECT monthname(`followupdate`) as month, YEAR(`followupdate`) as year, id,email_ids, subject,message,status,followupdate FROM `mail_report` ORDER BY `id` DESC";
        $res_s = mysql_query($sql_s);
        $records = @mysql_num_rows($res_s);
        if($records > 0) {
            while($row = mysql_fetch_array($res_s)) 
            {
                $result[] = $row;
            }	
        }
        return $result;	
    }

    /**
    * put your comment there...
    * 
    * @param mixed $emailid
    * @return array
    */
    function user_info($emailid)
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "SELECT * FROM `template_user` WHERE usernm_email='".$emailid."'";
        $res_s = mysql_query($sql_s);
        $records = @mysql_num_rows($res_s);
        if($records > 0) 
        {
            while($row = mysql_fetch_array($res_s)) 
            {
                $result[] = $row;
            }    
        }
        return $result;    
    }

    /**
    * put your comment there...
    * 
    * @param mixed $emailid
    */
    function forgot_password($emailid)
    {
        include_once("ModelClass.php");
        $ObModel = new Model();

        $sql_s = "SELECT * FROM `template_user` WHERE usernm_email='".$emailid."'";
        $res_s = mysql_query($sql_s);
        $records = @mysql_num_rows($res_s);
        if($records > 0)
        {
            $row = mysql_fetch_array($res_s);
            $to = $row['usernm_email'];
            $Subject = 'Password recovery email from Technopro.biz';
            $body = 'Your login credentials for technopro.biz<br><br><strong>User Name :'.$to.'</strong><br> and <strong>Password </strong>'.$row['password'];

            if(user_mail($to,$Subject,$body))
            {
                $message = 'Your password has successfully send to your email id.Please check your email for details.'; 
            }

        }
        else
        {
            $message = 'We are sorry!!There are no records found for this email id.';
        }

        return $message;    
    }


?>