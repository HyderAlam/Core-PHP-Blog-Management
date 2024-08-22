function verify_email() {
            var email = document.getElementById('email').value;
            var ajax_request = null;
            if(window.XMLHttpRequest)
            {
                ajax_request = new XMLHttpRequest();
            }
            else
            {
                ajax_request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            ajax_request.onreadystatechange = function() {
                if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                    var response = ajax_request.responseText;
                    var emailError = document.getElementById('emailError');
                    var submit = document.getElementById('register');
                    if (response === 'exists') {
                        emailError.innerHTML = 'Email already exists in database';
                        emailError.style.color = 'red';
                        submit.disabled = true;
                    } else {
                        emailError.innerHTML = '';
                        submit.disabled = false;
                    }
                }
            }
            ajax_request.open('POST', 'require/ajax_process.php', true);
            ajax_request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            ajax_request.send('email=' + email);
        }

function form_validation() {
var flag =true;	
//______________________pattern__________________

var firstpattern    =/^[A-Z][a-z]{2,}$/;
var lastpattern    	=/^[a-zA-Z]{2,}$/;
var emailpattern    =/^[a-z]+\d*[@]{1}[a-z]+[.]{1}(com|net){1}$/
var addresspattern 	=/\w/;
var passwordpattern = /^.{8,}$/;


//__________________Target Fields___________________
var first        =document.getElementById('first_name').value;
var firstmsg     =document.querySelector('#first_name_msg');
var last 	     =document.getElementById('last_name').value;
var lastmsg      =document.querySelector('#last_name_msg');
var email 		 =document.getElementById('email').value;
var emailmsg     =document.querySelector('#email_msg');
var address 	 =document.getElementById('address').value;
var addressmsg   =document.getElementById('address_msg');
var gender		 =document.querySelector("input[type='radio']:checked");
var gendermsg	 =document.querySelector("#gender_msg");
var image		 =document.getElementById('profile_pic').files;
var	imagemsg	 =document.getElementById('profile_msg');
var	birth	     =document.getElementById('date_of_birth').value;
var birthmsg 	 =document.getElementById('birth_msg');	
var password     =document.getElementById('password').value;
var passwordmsg  =document.getElementById('password_msg');
var size         = 1 * 1024 * 1024;


if (password ==="") {
	flag = false;
	passwordmsg.innerHTML = "Required field";
}else{
	if (passwordpattern.test(password)==false) {
		flag = false;
		passwordmsg.innerHTML= "Password must be at least 8 characters long";
	}else{
		passwordmsg.innerHTML= "";	
	}

}
	

if (first === "") {
	 flag = false;
	 firstmsg.innerHTML = "Required field";

}else{
	
	if (firstpattern.test(first)==false) {
		flag = false;
		firstmsg.innerHTML= "Name start with capital letter";
	}else{
		firstmsg.innerHTML= "";	
	}
}

if (last === "") {
	 flag = false;
	 lastmsg.innerHTML = "Required field";

}else{
	
	if (lastpattern.test(last)==false) {
		flag = false;
		lastmsg.innerHTML= "Enter your last name";
	}else{
		lastmsg.innerHTML= "";	
	}
}


if (email === "") {
	 flag = false;
	 emailmsg.innerHTML = "Required field";

}else{
	
	if (emailpattern.test(email)==false) {
		flag = false;
		emailmsg.innerHTML= "Please enter a valid email address like (example@example.com) Or (example@example.com)";
	}else{
		emailmsg.innerHTML= "";	
	}
}


if (address === "") {

	 flag = false;
	 addressmsg.innerHTML = "Required field";

}else{
	
	if (addresspattern.test(address)==false) {
		flag = false;
		addressmsg.innerHTML= "Please Enter your proper address";
	}else{
		addressmsg.innerHTML= "";	
	}
}


if (!gender) {
	flag=false;
	gendermsg.innerHTML ="Required field";
}else {
	gendermsg.innerHTML="";
}


if (image.length === 0) {
	flag=false
	imagemsg.innerHTML="Kindly Upload Your Pic";
	if (image.size > size) {		
		imagemsg.innerHTML="Your image size must be less then 1 Mb";
	}

} else {
	imagemsg.innerHTML="";
}


if (birth === "") {
	flag = false;
	birthmsg.innerHTML = "Required field";
}else{		
	birthmsg.innerHTML= "";		
}



if (flag == true) {
	return flag;
}else{
	return flag;
}


}