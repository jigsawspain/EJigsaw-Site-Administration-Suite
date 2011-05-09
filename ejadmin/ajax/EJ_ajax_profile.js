/*
*** EJigsaw Site Administration Suite
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Ajax Functions - File Build 0.1
*/

/* Setup AJAX Functionality */
function ajaxRequest(){
	var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"]
	if (window.ActiveXObject){
		for (var i=0; i<activexmodes.length; i++){
			try{
				return new ActiveXObject(activexmodes[i])
			}
			catch(e){
			}
		}
	}
	else if (window.XMLHttpRequest)
		return new XMLHttpRequest()
	else
		return false
}

/**********************
** Useable Functions **
**********************/

function saveProfile(key)
{
	document.getElementById('profile_errors').innerHTML = '';
	var form = document.getElementById('profile_form');
	var message = '';
	if ((!empty(form.newpass.value) || !empty(form.confpass.value)) && form.newpass.value != form.confpass.value)
	{
		message = message + '<p class="EJ_user_error">"New Password" does not match "Confirm New Password"</p>';
	}
	if (!empty(form.newpass.value) && !empty(form.confpass.value) && form.newpass.value.length <8)
	{
		message = message + '<p class="EJ_user_error">"New Password" is too short!</p>';
	}
	if (!validemail(form.email.value))
	{
		message = message + '<p class="EJ_user_error">Must specify a valid Email Address!</p>';
	}
	if (message == '')
	{
		var ajax = ajaxRequest();
		ajax.onreadystatechange = function()
		{
			if (ajax.readyState==4 && ajax.status==200)
			{
				if (ajax.responseText != '<p class="EJ_user_success">Profile Updated</p>')
				{
					document.getElementById("profile_errors").innerHTML=ajax.responseText + '<p class="EJ_user_message"><a href="./uadmin.php">Click to Refresh Page</a></p>';
				} else
				{
					document.getElementById("profile_errors").innerHTML=ajax.responseText;
				}
			}
		}
		email = form.email.value;
		pass = form.newpass.value;
		ajax.open("POST","ajax/saveprofile.php",true);
		ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajax.send("pass="+pass+"&email="+email+"&key="+key);
	} else
	{
		document.getElementById('profile_errors').innerHTML = message;
	}
}

function empty(mixed_var)
// Check if 'mixed_var' is empty ("" / NULL / 0 / "undefined")
{
    var key;
    if (mixed_var === "" || mixed_var === 0 || mixed_var === "0" || mixed_var === null || mixed_var === false || typeof mixed_var === 'undefined') {
        return true;
    }
    if (typeof mixed_var == 'object') {
        for (key in mixed_var) {
            return false;
        }
        return true;
    }
    return false;
}

function getUserType(type)
{
	switch (type) {
		case "0":
			return 'Site User';
		break;
		case "1":
			return 'Moderator';
		break;
		case "5":
			return 'Admin';
		break;
		case "9":
			return 'Super-Admin';
		break;
	}
}

function validemail(str)
// Check if 'str' is a valid email address
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
		return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		 return false
	}
	if (str.indexOf(at,(lat+1))!=-1){
		return false
	}
	if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		return false
	}
	if (str.indexOf(dot,(lat+2))==-1){
		return false
	}
	if (str.indexOf(" ")!=-1){
		return false
	}
	return true					
}
