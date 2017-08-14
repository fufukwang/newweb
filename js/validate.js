function SelectedValidate(idx,msg)
	{
	if(document.getElementById(idx)==null)
		return idx+" is Null";
		if(document.getElementById(idx).selectedIndex==-1)
			{
			return msg;
			}
	return "";
	}
function TextValidate(idx,msg)
	{
	if(document.getElementById(idx)==null)
		return idx+" is Null";

		if(document.getElementById(idx).value=="")
			{
			return msg;
			}
	return "";
	}
	
function dhPIDCheck(inputId,msg1,msg2) {
  var d = document.all[inputId], v = d.value, f = d.select() + "break"
  var c = ("0123456789abcdefghjklmnpqrstuvxywzio").indexOf(v.charAt(0).toLowerCase()).toString()
  if (v == "") {
    return msg1;
  } else if (!v.match(/^[a-zA-Z]\d{9}$/g) || v.match(/^.[^12]|^..[7-9]/g) ||
             (c.charAt(0)*1 + c.charAt(1)*9 + v.charAt(1)*8 + v.charAt(2)*7 + v.charAt(3)*6 + v.charAt(4)*5 +
             v.charAt(5)*4 + v.charAt(6)*3 + v.charAt(7)*2 + v.charAt(8)*1 + v.charAt(9)*1) % 10 > 0) {
    return msg2;
  }else{
	  	return "";
	  }
}

function TextNullCompareValidate(idx,idx2,msg)
	{
	if(document.getElementById(idx)==null)
		return idx+" is Null";

	if(document.getElementById(idx2)==null)
		return idx2+" is Null";

	if(document.getElementById(idx).value!="" ||document.getElementById(idx2).value!="")
		{
		if(document.getElementById(idx).value==""||document.getElementById(idx2).value=="")
			{
			return msg;
			}
		}
	return "";
	}
function CompareValidate(idx,idx2,msg)
	{
	if(document.getElementById(idx)==null)
		return idx+" is Null";

	if(document.getElementById(idx2)==null)
		return idx2+" is Null";

	if(document.getElementById(idx).value!=document.getElementById(idx2).value)
		return msg;
	return "";
	}

function MailValidate(idx,msg)
	{
	return "";
	}
function NumberValidate(idx,msg)
	{
	if(document.getElementById(idx)==null)
		return idx+" is Null";
		if(isNaN(document.getElementById(idx).value))
			{
			return msg;
			}
	return "";
	}
function NumberAreaValidate(idx,m,b,msg)
	{
	if(document.getElementById(idx)==null)
		return idx+" is Null";

		if(isNaN(document.getElementById(idx).value))
			{
			return msg;
			}else{
			var v = document.getElementById(idx).value;
			if(v < m || v >b)
				return msg;

			}
	return "";

	}

function Validate()
	{
	var msg="";
	for(i=0;i<Validate.arguments.length;i++)
		{
		if(Validate.arguments[i]!="")
			msg+=Validate.arguments[i]+"\n";
		}
	if(msg!="")
		{
		alert(msg);
		return false;
		}else{
		return true;
		}
	}
function v_clear(idx)
	{
	if(document.getElementById(idx)==null)
		alert(idx+" is Null");
	document.getElementById(idx).value="";
	}
function MailValidate(idx,msg)
	{
	if(document.getElementById(idx)==null)
		return idx+" is Null";

		if(document.getElementById(idx).value=="")
			{
			return msg;
			}
		if(!document.getElementById(idx).value.match(/@(.*)\./g) || document.getElementById(idx).value.match(/@\.|^@|\.$|@(.*)@|\.\.|[^\w\-\._@]/g))
			{
			return msg;
			}
	return "";

}
function IDNoValidate(inputId,msg) {
  var d = document.all[inputId], v = d.value, f = d.select() + "break"
  var c = ("0123456789abcdefghjklmnpqrstuvxywzio").indexOf(v.charAt(0).toLowerCase()).toString()
  if (v == "") {
   
  } else if (!v.match(/^[a-zA-Z]\d{9}$/g) || v.match(/^.[^12]|^..[7-9]/g) ||
             (c.charAt(0)*1 + c.charAt(1)*9 + v.charAt(1)*8 + v.charAt(2)*7 + v.charAt(3)*6 + v.charAt(4)*5 +
             v.charAt(5)*4 + v.charAt(6)*3 + v.charAt(7)*2 + v.charAt(8)*1 + v.charAt(9)*1) % 10 > 0) {
    return msg; 
  }
  return "";
}
