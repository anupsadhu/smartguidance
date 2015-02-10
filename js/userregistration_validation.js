function doSubmit()
{ 
    if(trim(document.getElementById('firstname').value)=="")
        {
        alert("Please insert first name");
        document.getElementById('firstname').focus();
        return false;
    }
    if(trim(document.getElementById('email').value)=="")
        {
        alert("Please insert the email address");
        document.getElementById('email').focus();
        return false;
    }
    else {
        str = trim(document.getElementById('email').value);
        var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/;
        if(re.test(str)==false) {
            alert("Please insert the proper email format");
            document.getElementById('email').focus();
            return false;
        }
    }        
    if(trim(document.getElementById('login').value)=="")
        {
        alert("Please insert login");
        document.getElementById('login').focus();
        return false;
    }
    
    if(trim(document.getElementById('usrpassword').value)=="")
    {
        alert("Please insert password");
        document.getElementById('usrpassword').focus();
        return false;
    }
    
    /*if(trim(document.getElementById('newpw').value)!= trim(document.getElementById('password2').value))
        {
        alert("Password does not match.");
        document.getElementById('newpw').focus();
        return false;
    }*/
    if(!(document.getElementById('accptterms').checked)) {
        alert("Please accept terms and condition.");
        return false;
    }

}

function trim(s){
    return s.replace(/^\s*(.*?)\s*$/,"$1")
}