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

function addUser()
// Check the add_user_form form and, if complete, add a new user to the database via AJAX
{
	document.getElementById('uadmin_errors').innerHTML = '';
	var form = document.getElementById('add_user_form');
	var message = '';
	if (empty(form.user_id.value))
	{
		message = message + '<p class="EJ_user_error">Must specify a User Name!</p>';
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
				if (ajax.responseText != '<p class="EJ_user_success">User Added Successfully</p>')
				{
					document.getElementById("uadmin_errors").innerHTML=ajax.responseText + '<p class="EJ_user_message"><a href="./uadmin.php">Click to Refresh Page</a></p>';
				} else
				{
					var user = form.user_id.value;
					var email = form.email.value;
					var type = getUserType(form.type.value);
					var target = document.getElementById("end_users");
					var key = form.key.value;
					var newRow = document.createElement('tr');
					newRow.id = form.user_id.value;
					newRow.style = "background: #090;";
					newRow.innerHTML = "<td>"+ user +"</td><td>"+ email +"</td><td>"+ type +"</td><td><a class=\"small_button delete\" href=\"javascript:deleteUser('"+ user +"','"+ key +"');\">Delete User</a><a class=\"small_button edit\" href=\"javascript:editUser('"+ user +"','"+ key +"')\">Edit User</a></td>";
					target.parentNode.insertBefore(newRow, target);
					form.user_id.value = "";
					form.email.value = "";
					form.type.selectedIndex = 0;
					document.getElementById("uadmin_errors").innerHTML=ajax.responseText;
				}
			}
		}
		username = form.user_id.value;
		email = form.email.value;
		type = form.type.value;
		key = form.key.value;
		ajax.open("POST","ajax/adduser.php",true);
		ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajax.send("uname="+username+"&email="+email+"&type="+type+"&key="+key);
	} else
	{
		document.getElementById('uadmin_errors').innerHTML = message;
	}
}

function deleteUser(userid,key)
{
	document.getElementById("uadmin_errors").innerHTML = "";
	if (confirm('Are you sure you want to delete the user "'+userid+'"?'))
	{
		document.getElementById('uadmin_errors').innerHTML = '';
		var message = '';
		var ajax = ajaxRequest();
		ajax.onreadystatechange = function()
		{
			if (ajax.readyState==4 && ajax.status==200)
			{
				if (ajax.responseText != '<p class="EJ_user_success">User Deleted</p>')
				{
					document.getElementById("uadmin_errors").innerHTML=ajax.responseText + '<p class="EJ_user_message"><a href="./uadmin.php">Click to Refresh Page</a></p>';
				} else
				{
					var target = document.getElementById(userid);
					target.parentNode.removeChild(target);
					document.getElementById("uadmin_errors").innerHTML=ajax.responseText;
				}
			}
		}
		ajax.open("POST","ajax/deluser.php",true);
		ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajax.send("uname="+userid+"&key="+key);
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
