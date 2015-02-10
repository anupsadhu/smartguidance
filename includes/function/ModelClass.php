<?php
    class Model
    {
        var $ObCon;					
        var $RsArray;

        /**
        * Constructor function that connects to MySQL when true OR no argument is passed.
        *
        * The default one that takes no argument would connect to MySQL.And the other that
        * takes one argument(to make its signature distinct from the default) would not connect
        * to MySQL.And the 3rd one that takes 2 arguments could be used to connect MySQL but not
        * fix up the DB.But I find PHP(not even 5) does not support multiple constructors.So this
        * clever code to do both constructor's work in one.Pass false as 1st argument when instantiating
        * the class and MySQL won't be connected.You can still call the other functions of the class using
        * the object. Pass (true, false) and MySQL is connected but no DB is selected. U have to write
        * <DB>.<table> every time. 
        *  
        * @author Anup Sadhu<anupsadhu@gmail.com>
        * 
        * @parameter $connect <Connection string>
        * @parameter $connectdb <connection DB Name>
        * 
        * @return bool
        * 
        * @copyright 
        * 
        */

        function Model( $connect=true, $connectdb=true )
        {
            if( $connect == true )
            {

                //$this->ObCon = mysql_connect( "localhost", "root", "" ) or die( "Cannot connect MySQL. Programmer suggests that u try to refresh the page once<br>".mysql_error() );
                $this->ObCon = mysql_connect( "localhost", "aquafish_mudncra", "mudncr@ft910" ) or die( "Cannot connect MySQL. Programmer suggests that u try to refresh the page once<br>".mysql_error() );

                if( $connectdb == true )
                {

                    //mysql_select_db( "educationportal", $this->ObCon) or die( "Cannot find the database mentioned. Programmer suggests that u try to refresh the page once<br>".mysql_error() );
                    mysql_select_db( "aquafish_mudncraft", $this->ObCon) or die( "Cannot find the database mentioned. Programmer suggests that u try to refresh the page once<br>".mysql_error() );

                }

            }

            else
                return;
        }

        #################################  CLOSE MySQL CONNECTION  ###################################
        //Function that closes the mysql connection.Use with mysql_connect() not with mysql_pconnect().Call it at the end of the page just before you do unset($ObModel)
        function CloseConn()
        {
            mysql_close($this->ObCon);
        }

        /**
        * Returns a 2D array from a recordset created by a select query.
        *
        * Remember that in case of arguments with a default value,the rule in C++ & PHP is 
        * that they should all be the last arguments. If you pass 3 parameters then it is
        * received in the 1st 3 arguments. And the 4th takes its default value.
        * If you pass 2 parameters then it is received in the 1st 2 arguments. And the last
        * 2 take their default value.s. YOU CAN'T IN ANY WAY pass the 1st,2nd & 4th parameters
        * and expect the 3rd argument to take its default value.Better to re-pass the default
        * value of the 3rd argument in that case I will not write comment on what each argument will hold. 
        * I prde myself that my variable naming is always carefully chosen, self-explanatory and un-ambiguous.                                                                                                                                                        
        *  
        * @author Anup Sadhu<anupsadhu@gmail.com>
        * 
        * @parameter $fields <holds table field name>
        * @parameter $TblName <holds table name on which query will make>
        * @parameter $condition <holds the query condition>
        * @parameter $OrderBy <order by field name passed>
        * @parameter $lmt <how many record need to be returned>
        * 
        * @return array
        * 
        * @copyright 
        * 
        */

        function FetchFields( $fields, $TblName, $condition, $OrderBy="", $lmt="" )
        {
            $this->RsArray = array();
            if( $OrderBy == "" )											
                $SelectState = "select ".$fields." from ".$TblName." where ".$condition;
            else if( $OrderBy != "" )
                    $SelectState = "select ".$fields." from ".$TblName." where ".$condition." order by ".$OrderBy;

                if( $lmt != "" )														
                $SelectState .= " limit ".$lmt;
            //die($SelectState);
            $rs = mysql_query( $SelectState ) or die( "FETCH FIELDS QUERY FAILED. Programmer suggests that u try to refresh the page once<br>".mysql_error() );				//Querying the DB
            if( substr($fields,0,1) == "*" )								
            {
                $FldNames = array();
                for( $k=0; $k<=(mysql_num_fields($rs)-1); $k++ )
                    $FldNames[] = mysql_field_name($rs, $k);
            }
            else
                $FldNames = split( ",", $fields );
            $i = 0;
            while( $rec = mysql_fetch_array($rs) )					//Populating the 2D array $RsArray with the retrieved recordset. 1st index will hold the record number(starting from 0). 2nd index will be string type(=field name,not numerical)
            {
                $j = 0;
                foreach( $FldNames as $nm )
                {
                    $this->RsArray[$i][$nm] = $rec[$j];
                    ++$j;
                }
                ++$i;
            }
            mysql_free_result($rs);
            return $this->RsArray;
        }

        #########################################  INSERT  #######################################
        //Inserts a record. If you pass only 2 arguments then it will try to insert the values into all the fields of the table. If you pass the 3rd argument also then it will try to insert a new record with value for only those fields
        //this function is later changed by anup.The second field is an array whrere we are getting values for insertion as an array.
        //function InsertRec( $TblName, $vals, $FldNames="" )
        function InsertRec( $TblName, $arrVals, $FldNames="" )
        {   
            //$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
            //$arrVals = explode(",", $vals);//this is for handling character that may create problem  at my sql query
            $vals='';
            foreach($arrVals as $value)
            {
                //$value=preg_replace("/^\'(.*)\'$/", "$1", $value);
                $vals.="'".mysql_escape_string($value)."'".',';
            }
            /*foreach($arrVals as $key=>$value)
            {
            $key.="'".mysql_escape_string($key)."'".',';	
            $vals.="'".mysql_escape_string($value)."'".',';
            }*/

            //this is for cutting down the last addtional ','
            $vals=preg_replace("/^(.*)\,$/", "$1", $vals);
            /*$key=preg_replace("/^(.*)\,$/", "$1", $key);*/


            if( $FldNames == "" )
                $InsertState = "insert into ".$TblName." values(".$vals.")";
            else if( $FldNames != "" )
                    $InsertState = "insert into ".$TblName."(".$FldNames.") values(".$vals.")";

                /*else if( $FldNames != "" )
                $InsertState = "insert into ".$TblName."(".$FldNames.") values(".$key.",".$vals.")";*/
                //die($InsertState);
                if( mysql_query($InsertState) == true )
                return 1;
            else
                return mysql_errno();
        }
        ########################################  UPDATE  ########################################
        //Updates records. If you want to update all records of a table then pass "1" as the 3rd parameter
        function UpdateRec( $TblName, $vals, $condition )
        {
            $UpdateState = "update ".$TblName." set ".$vals." where ".$condition;

            //die($UpdateState);
            if( mysql_query($UpdateState) == true )
                return 1;
            else
                return mysql_errno();
        }
        /*
        This function is added by anup for handling those values which may have junk values+',' in it. 
        */
        function updaterec_v2( $TblName, $arrFlds, $arrVals, $condition )
        {
            //this part is added by anup for tackling characters which can create problem at mysql
            for($ct=0;$ct<count($arrVals);$ct++)
            {
                $val_str.=$arrFlds[$ct]."='".mysql_escape_string($arrVals[$ct])."',";
            }	

            $val_str=preg_replace("/^(.*)\,$/", "$1", $val_str);
            $UpdateState = "update ".$TblName." set ".$val_str." where ".$condition;
            //echo ($UpdateState);
            if( mysql_query($UpdateState) == true )
                return 1;
            else
                return mysql_errno();
        }
        ########################################  DELETE  ########################################
        //Deletes records. If you want to delete all records from a table then pass "1" as the 2nd parameter
        function DeleteRec( $TblName, $condition )
        {
            $DeleteState = "delete from ".$TblName." where ".$condition;
            //die($DeleteState);
            if( mysql_query($DeleteState) == true )
                return 1;
            else
                return mysql_errno();
        }
        ###################################### FETCH COUNT #######################################
        function FetchCount( $TblName, $condition="1" )
        {
            $SelectState = "select count(*) as somany from ".$TblName." where ".$condition;
            $rs = mysql_query( $SelectState ) or die( "FETCH COUNT QUERY FAILED<br>".mysql_error() );				//Querying the DB
            $rec = mysql_fetch_array($rs);
            $total = $rec['somany'];
            mysql_free_result($rs);
            return $total;
        }
        #################################  AUTONUMBER GENERATOR  ####################################
        //Computes and returns the next autonumber for insertion in the field(often primary key) of tables
        function autonum( $FldName, $TblName, $condition="1" )
        {
            $SelectState = "select max(".$FldName.") from ".$TblName." where ".$condition;
            $RsMax = mysql_query( $SelectState ) or die( "AUTONUM QUERY FAILED<br>".mysql_error() );
            $MaxRec = mysql_fetch_array($RsMax);
            return ( $MaxRec[0]+1 );
            mysql_free_result($RsMax);
        }
        #######################################  GET VALUE  #######################################
        //Finds and returns the value of a field from a given table for the record with a particular value in another field(often to be unique or primary key field)
        function GetValue( $RetField, $TblName, $CmpField, $CmpVal )											//$CmpField should be varchar type.But it works for int type $CmpField too
        /*
        This function has been modified by anup .She has added if else functionality to return all the fields of a table in an array which is done in the else part.
        */
        {
            if($RetField!="*")
            {
                $SelectState = "select ".$RetField." from ".$TblName." where ".$CmpField."='".$CmpVal."'";
                $rs = mysql_query( $SelectState ) or die( "GET VALUE QUERY FAILED<br>".mysql_error() );
                $rec = mysql_fetch_array($rs);
                $ret_val = $rec[0];
                mysql_free_result($rs);
                return $ret_val;
            }
            else
            {
                $SelectState = "select ".$RetField." from ".$TblName." where ".$CmpField."='".$CmpVal."'";
                $rs = mysql_query( $SelectState ) or die( "GET VALUE QUERY FAILED<br>".mysql_error() );
                $rec = mysql_fetch_array($rs);
                return $rec;
            }
        }
        #######################################  GET VALUE2  ######################################
        //Finds and return last inserted id 
        function AllValue( $TBL, $CON )
        {
            $SelectState = "select * from ".$TBL." order by ".$CON. " desc";
            $rs = mysql_query( $SelectState ) or die( "ALL VALUE QUERY FAILED<br>".mysql_error() );
            $rec = mysql_fetch_array($rs);
            while($rec = mysql_fetch_array($rs))
            {
                $watch_id = $rec['watch_id'];
                return $watch_id;
            }
        }
        #######################################  Last Value ############################################### 
        //Extract the field value from a given table for 2 field values passed as condition
        function GetValue2( $RetField, $TblName, $CmpField1, $CmpVal1, $CmpField2, $CmpVal2 )	//2 compare fields,both of type varchar to be precise.But works for int too
        {
            $SelectState = "select ".$RetField." from ".$TblName." where ".$CmpField1."='".$CmpVal1."' and ".$CmpField2."='".$CmpVal2."'";
            //echo $SelectState;
            $rs = mysql_query( $SelectState ) or die( "GET VALUE2 QUERY FAILED<br>".mysql_error() );
            $rec = mysql_fetch_array($rs);
            $ret_val = $rec[0];
            mysql_free_result($rs);
            return $ret_val;
        }

        ######################################  MD5 ENCRYPT  ######################################
        //Encryption technique of the password. Pass 2 arguments to it.The text to encode and a fixed catalyst string say "mermaid".It will return the encoded text
        function md5encrypt( $readable_text, $catalyst, $iv_len=16 )
        {
            $readable_text .= "\x13";
            $len = strlen($readable_text);
            if($len % 16)
                $readable_text .= str_repeat( "\0", 16-($len%16) );							//Repeats the 1st argument (the 2nd argument) no of times
            $i = 0;
            $encoded_text = $this->get_rnd_iv($iv_len);
            $iv = substr( $catalyst ^ $encoded_text, 0, 32 );								//Bitwise operator ^ allows you to turn specific bits within an integer on or off.Applied to strings,it operates on the ASCII value of the characters
            while($i < $len)
            {
                $block = substr( $readable_text, $i, 16 ) ^ pack('H*', md5($iv) );		//md5() is an inbuilt PHP function.It returns a hexadecimal number after seeing the string passed as argument
                $encoded_text .= $block;
                $iv = substr( $block . $iv, 0, 32 ) ^ $catalyst;
                $i += 16;
            }
            return base64_encode($encoded_text);
        }
        ######################################################################################
        //Needed by md5encrypt()
        function get_rnd_iv($iv_len)
        {
            $iv = '';
            while ($iv_len-- > 0)
                $iv .= chr( mt_rand() & 0xff );			//mt_rand() is inbuilt PHP function that generates random numbers
            return $iv;
        }
        ######################################  MD5 DECRYPT  ######################################
        //Decryption technique of the password. Pass 2 arguments to it.The nonsense text to decode and the same fixed catalyst string "mermaid" as used for encoding earlier.It will return the original text
        function md5decrypt( $encoded_text, $catalyst, $iv_len=16 )
        {
            $encoded_text = base64_decode($encoded_text);
            $len = strlen($encoded_text);
            $i = $iv_len;
            $readable_text = '';
            $iv = substr( $catalyst ^ substr($encoded_text, 0, $iv_len), 0, 32 );
            while ($i < $len)
            {
                $block = substr( $encoded_text, $i, 16 );
                $readable_text .= $block ^ pack( 'H*', md5($iv) );
                $iv = substr( $block.$iv, 0, 32 ) ^ $catalyst;
                $i += 16;
            }
            return preg_replace( '/\\x13\\x00*$/', '', $readable_text );
        }
        ###################################  UPLOAD IMAGE  ########################################
        function UploadFiles( $TempName, $DestinPath )
        {
            if(  move_uploaded_file( $TempName, $DestinPath ) == true  )
                return true;
            else
                return false;
        }
        #################################  DELETE PREVIOUS IMAGE  ####################################
        function DeleteFile($DelPath)																//unlink also returns boolean.But I am not using for now
        {
            if( file_exists($DelPath) && !is_dir($DelPath) )
                unlink($DelPath);
        }
        ######################################################################################
    }
?>
