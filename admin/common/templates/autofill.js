/* 09.08.11 shevayura */
    function isExists(name, value){
        xx = document.getElementById(name);

        for (var cxx in xx.childNodes) {
            if (xx.childNodes[cxx].nodeType == 1){
                if (xx.childNodes[cxx].value == value)
                    return 1;
            }
        }
        return 0;
    }
    function add(name, value, text){
        if (value.length < 1)
            return 0;
        if ( isExists(name, value) )
            return 0;
        xx = document.getElementById(name);
        xx.innerHTML += '<option value="' + value + '" selected>'+text+'</option>'
    }
    function del(name, value){
        xx = document.getElementById(name);

        for (var cxx in xx.childNodes) {
            if (xx.childNodes[cxx].nodeType == 1){
                if (xx.childNodes[cxx].value == value)
                    xx.childNodes[cxx].outerHTML="";
            }
        }
    }

    /* ---------------------------------- */

    function showResult(name, table, field, value, image, str, xformat){
        if (window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else{
            // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                resp = xmlhttp.responseText;
                document.getElementById(name+"__livesearch").innerHTML= resp;
                document.getElementById(name+"__livesearch").style.border="1px solid #A5ACB2";
            }
        }

        req = "current_id={{id}}&name="+name+"&table="+table+"&field="+field+"&value="+value+"&image="+image+"&q="+str+"&format="+xformat;
        xmlhttp.open("GET","{{admin_path}}/common/autofill.php?"+req,true);
        xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
        xmlhttp.send();
    }

    function gotFocus(name, table, field, value, image, str, xformat){
        if ( str == "" && document.getElementById(name+"__livesearch").innerHTML.length < 5 ){
            showResult(name, table, field, value, image, str, xformat);
            return;
        }
    }

    function refreshResult(name, table, field, value, image, str, xformat){
        document.getElementById(name+"__livesearch").innerHTML= '';
        str = document.getElementById(name+"__search").value;
        showResult(name, table, field, value, image, str, xformat);
    }

    /* ---------------------------------- */
    /*                xself               */
    /* ---------------------------------- */

    function currentUrl(){
        u = location.href;
        u = u.split('?')[0];
        return u;
    }
    function refreshResult_xself(name, field, search, str){
        document.getElementById(name+"__livesearch").innerHTML= '';
        value = document.getElementById(name+"__search").value;
        showResult_xself(name, field, search, value);
    }
    function showResult_xself(name, field, search, str){
        if (window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else{
            // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                resp = xmlhttp.responseText;
                document.getElementById(name+"__livesearch").innerHTML= resp;
                document.getElementById(name+"__livesearch").style.border="1px solid #A5ACB2";
            }
        }

        req = "current_id={{id}}&type=xself&name="+name+"&field="+field+"&search="+search+"&q="+str;
        xmlhttp.open("GET",currentUrl()+"?"+req, true);
        xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
        xmlhttp.send();
    }

    function gotFocus_xself(name, field, search, str){
        if ( str == "" && document.getElementById(name+"__livesearch").innerHTML.length < 5 ){
            showResult_xself(name, field, search, str);
            return;
        }
    }