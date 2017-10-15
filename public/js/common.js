function ajax(businessInterface, data, successFunction, property, object) {
	request = {
		url : base_url + businessInterface,
		data : data,
		dataType : "json",
		type : "POST",
		success : function(data) {
			successFunction(data, object)
		}
	};

	$.extend(request, property);
	$.ajax(request);
};

function checkError(errorMsg) {
    var alertMsg = '';
    if (typeof errorMsg == 'string')
    {
        alert(errorMsg)
        return ;
    }

    $.each(errorMsg, function(i, msg){
        alertMsg += msg + '\n';
    });

    alert(alertMsg);
}

function escapeHtml(text) {
	  return text
	      .replace(/&/g, "&amp;")
	      .replace(/</g, "&lt;")
	      .replace(/>/g, "&gt;")
	      .replace(/"/g, "&quot;")
	      .replace(/'/g, "&#039;");
}

function fmoney(s, n)   
{   
   n = n >= 0 && n <= 20 ? n : 2;   
   s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";   
   var l = s.split(".")[0].split("").reverse(),   
   r = s.split(".")[1];   
   t = "";   
   for(i = 0; i < l.length; i ++ )   
   {   
      t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");   
   }   
   if (n == 0) {
	   return t.split("").reverse().join("");
   }
   return t.split("").reverse().join("") + "." + r;   
} 

function getAvatar(avatar) {
	return base_url + (avatar ? avatar : 'data/avatar/default.png');
}



function formatTimestamp(timestamp) {
    var second = 1000;
    var minutes = second * 60;
    var hours = minutes * 60;
    var days = hours * 24;
    var months = days * 30;
    
    var now = new Date();
	var date = new Date(timestamp * 1000);
	
    var longtime = now.getTime() - date.getTime();
    
	if ( longtime > months * 2 )
    {
        var year = date.getFullYear();
		var month = date.getMonth() + 1;
		var day = date.getDate();
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var seconds = date.getSeconds();

		if (hours < 10) 
		 hours = '0' + hours;

		if (minutes < 10) 
		 minutes = '0' + minutes;

		if (seconds < 10) 
		 seconds = '0' + seconds;

		return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
    }
    else if (longtime > months)
    {    
        return "1个月前";
    }
    else if (longtime > days*7)
    {    
        return ("1周前");
    }
    else if (longtime > days)
    {    
        return(Math.floor(longtime / days) + "天前");
    }
    else if ( longtime > hours)
    {    
        return(Math.floor(longtime / hours) + "小时前");
    }
    else if (longtime > minutes)
    {    
        return(Math.floor(longtime / minutes) + "分钟前");
    }
    else if (longtime > second)
    {    
        return(Math.floor(longtime/second) + "秒前");
    } else {
    	return '1秒以前';
    }
}


function formatDate(timestamp) {
    var second = 1000;
    var minutes = second * 60;
    var hours = minutes * 60;
    var days = hours * 24;
    var months = days * 30;
    
    var now = new Date();
	var date = new Date(timestamp * 1000);
	
    var longtime = now.getTime() - date.getTime();
    

    var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();

	if (hours < 10) 
	 hours = '0' + hours;

	if (minutes < 10) 
	 minutes = '0' + minutes;

	if (seconds < 10) 
	 seconds = '0' + seconds;

	return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
}

function getImage(image) {
  var lastPathPosition = image.lastIndexOf('/');
  var path = image.substring(0, lastPathPosition + 1);
  var fileFullName = image.substring(lastPathPosition + 1);
  
  var extPosition = fileFullName.lastIndexOf('.');
  var fileMainName = fileFullName.substring(0, extPosition);
  var extName = fileFullName.substring(extPosition);
  
  var fileName = fileMainName.substring(0, fileMainName.lastIndexOf('_'));
  
  return path + fileName + extName;
}

function htmlspecialchars(str)  
{  
	   str = str.replace(/&/g, '&amp;');
	    str = str.replace(/</g, '&lt;');
	    str = str.replace(/>/g, '&gt;');
	    str = str.replace(/"/g, '&quot;');
	   str = str.replace(/'/g, '&#039;');
	   return str;
}

