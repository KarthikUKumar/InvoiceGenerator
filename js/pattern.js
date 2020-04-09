function test_str(id) { 
           var x;
            var str = 
                document.getElementById(id).value; 
            if (str.match(/[a-z]/g) && str.match( 
                    /[A-Z]/g) && str.match( 
                    /[0-9]/g) && str.match( 
                    /[^a-zA-Z\d]/g) && str.length >= 8) 
                x=10;
            else 
                alert("password must contain atleast 8 characters with atleast one digit,one uppercase letter,one lowercase letter and a special character");
  
        } 