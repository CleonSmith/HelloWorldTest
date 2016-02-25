<?PHP

class DatabaseUtility
{
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    
    var $error_message;
    
    //-----Initialization -------
    function DatabaseUtility()
    {
        $this->sitename = 'flyover-games.com';
		$this->db_host  = 'mysql.flyover-games.com';
        $this->username = 'helloworld_admin';
        $this->pwd  = 'helloworld';
        $this->database  = 'helloworld_registrationtest';
        $this->tablename = 'registeredusers';
    }
    
    //-------Main Operations ----------------------
    function RegisterUser()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
        $formvars = array();
       
        $this->CollectRegistrationSubmission($formvars);
        
        if(!$this->SaveToDatabase($formvars))
        {
            return false;
        }
        
        return true;
    }
    
    //-------Public Helper functions -------------
    function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    
    function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }    
    //-------Private Helper functions-----------
    
    function HandleError($err)
    {
        $this->error_message .= $err."\r\n";
    }
    
    function HandleDBError($err)
    {
        $this->HandleError($err."\r\n mysqlerror:".mysql_error());
    }
    
    function CollectRegistrationSubmission(&$formvars)
    {
        $formvars['firstname'] = $this->Sanitize($_POST['firstname']);
		$formvars['lastname'] = $this->Sanitize($_POST['lastname']);
        $formvars['address1'] = $this->Sanitize($_POST['address1']);
		$formvars['address2'] = $this->Sanitize($_POST['address2']);
		$formvars['city'] = $this->Sanitize($_POST['city']);
		$formvars['state'] = $this->Sanitize($_POST['state']);
		$formvars['zip'] = $this->Sanitize($_POST['zip']);
		$formvars['country'] = $this->Sanitize($_POST['country']);
    }
    
    function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
    }
    
    function SaveToDatabase(&$formvars)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }
       
        if(!$this->InsertIntoDB($formvars))
        {
            $this->HandleError("Inserting to Database failed!");
            return false;
        }
        return true;
    }
	
	function DBLogin()
    {
        $this->connection = mysql_connect($this->db_host,$this->username,$this->pwd);

        if(!$this->connection)
        {   
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }
        if(!mysql_select_db($this->database, $this->connection))
        {
            $this->HandleDBError('Failed to select database: '.$this->database.' Please make sure that the database name provided is correct');
            return false;
        }
        if(!mysql_query("SET NAMES 'UTF8'",$this->connection))
        {
            $this->HandleDBError('Error setting utf8 encoding');
            return false;
        }
        return true;
    } 
    
    function InsertIntoDB(&$formvars)
    {
		$timestamp = date('Y-m-d');
        
        $insert_query = 'insert into '.$this->tablename.'(
                firstname,
                lastname,
                address1,
                address2,
                city,
				state,
				zip,
				country,
				timestamp
                )
                values
                (
                "' . $this->SanitizeForSQL($formvars['firstname']) . '",
                "' . $this->SanitizeForSQL($formvars['lastname']) . '",
                "' . $this->SanitizeForSQL($formvars['address1']) . '",
				"' . $this->SanitizeForSQL($formvars['address2']) . '",
				"' . $this->SanitizeForSQL($formvars['city']) . '",
				"' . $this->SanitizeForSQL($formvars['state']) . '",
				"' . $this->SanitizeForSQL($formvars['zip']) . '",
				"' . $this->SanitizeForSQL($formvars['country']) . '",
				"' . $timestamp . '"
                )';      
        if(!mysql_query( $insert_query ,$this->connection))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            return false;
        }        
        return true;
    }
    
    function SanitizeForSQL($str)
    {
        if( function_exists( "mysql_real_escape_string" ) )
        {
              $ret_str = mysql_real_escape_string( $str );
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
    
    //Sanitize for your safety!
    function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }    
    function StripSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }    
}
?>