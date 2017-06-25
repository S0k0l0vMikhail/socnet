  url_s = location.host;
  if (url_s == 'localhost')
  url_s = "http://localhost/www/social_net/";
  else
  url_s = "http://panzins.ru/";
  url_api = url_s+"api";

  function s(id)
  {
    var s = document.getElementById(id);
    return s;
  }
  function clear_class(t_class)
  {
    s(t_class).className = "";
  }
  function t(tag_name)
  {
    return document.getElementsByTagName(tag_name);
  }
  function getCookie(name) 
  {
    var cookie = " " + document.cookie;
    var search = " " + name + "=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) 
    {
      offset = cookie.indexOf(search);
      if (offset != -1) 
      {
        offset += search.length;
        end = cookie.indexOf(";", offset)
        if (end == -1) 
        {
          end = cookie.length;
        }
        setStr = cookie.substring(offset, end);
      }
    }
    return(setStr);
  }

  var request_login = false;
  try
  {
    request_login = new XMLHttpRequest();
  }
  catch(mscheck)
  {
    try
    {
      request_login = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(msother)
    {
      try
      {
        request_login = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(failed)
      {
        request_login = false;
      }
    }
  }
  if (!request_login)
   alert("Вы используете устаревший браузер, пожалуйсте обновите его или установите современный браузер: Firefox или Opera");

  function form_loader(form_name, output)
  {
    var url = url_s+"html/"+form_name;
    request_login.open("GET", url, true);
    request_login.onreadystatechange = function()
    {
      if (request_login.readyState == 4)
      {
        if (request_login.status == 200)
        {
          var res_login = request_login.responseText;
          s(output).innerHTML = res_login;
        }
      }
    };
    request_login.send(null);
  }

  var data_list = new Array(); rst = 0;

  function main_class()
  {
// Загрузка формы методом GET (form_loader) (upd_form_loader)
    this.upd_form_loader = function(res_login)
    {
      alert("Обратный вызов: "+ res_login);
    }
    this.form_loader = function(form_name)
    {
      var self = this;
      var url = url_s+"html/"+form_name;
      request_login.open("GET", url, true);
      request_login.onreadystatechange = function()
      {
        if (request_login.readyState == 4)
          if (request_login.status == 200)
            self.upd_form_loader(request_login.responseText);
      };
      request_login.send(null);
    }

    this.xml_ = function()
    {
      try
      {
        var result = new Array();
        var i = 0, j = 0;
        for(;j<arguments.length;j++)
        {
          if (j == 0)
            s("xml_temp").innerHTML = arguments[j];
          else
          {
            result[i] = new Array(); result[i] = t(arguments[j]); i++;
          }
        }
        return result;
      }
      catch(ex)
      {
        alert("Ошибка обработки xml");
      }
    }
// Передача данных методом POST (ajax_post) (back_)
    this.back_ = function(res_login)
    {
      var res_login = res_login.split("'"); 
      alert("Обратный вызов функции ajax_post: "+ res_login[1]);
    }
    this.ajax_post = function(data)
    {
      try
      {
        if (rst>0)
          data_list.push(data);
        else
          this.ajax_post_(data);
      }
      catch(ex)
      {
        alert(ex);
      }
    }

    this.ajax_post_ = function(data)
    {
      try
      {
        rst = 1;
        var self = this;
        request_login.open("POST", url_api, true);
        request_login.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request_login.onreadystatechange = function()
        {
          if (request_login.readyState == 4)
          {
            if (request_login.status == 200)
            {
              self.back_(request_login.responseText);
              rst = 0;
              var data = data_list.shift();
              if (data != undefined)
              self.ajax_post_(data);
            }
          }
        };
        request_login.send("login="+ login +"&pass="+ pass +"&"+ data);
      }
      catch(ex)
      {
        alert("Ошибка: "+ ex);
      }
    }
  }

