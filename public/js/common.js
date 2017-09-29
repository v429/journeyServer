function ajax(url, data, success)
{
    $.ajax({
        type:'POST',
        url:url,
        data:data,
        dataType:'json',
        success:success
    });

}