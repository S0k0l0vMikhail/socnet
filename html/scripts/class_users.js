  function class_users()
  {
    cusers = new main_class();

    cusers.load_info = function()
    {
      s("mylfm").innerHTML = lfm;
      s("mycity").innerHTML = city;
    }

    cusers.back_ = function(res_login)
    {
      var res_login = res_login.split("'");
      switch(res_login[0])
      {
        case '0':
          lfm = res_login[1];
          city = res_login[2];
          s("content").innerHTML = "Идет загрузка...";
          setTimeout("form_loader('user.html', 'content')", 2000);
          setTimeout("cusers.load_info()", 3000);
        break;
        case '1':
        case '2':
        case '3':
          cusers.logout();
          alert("Неправильный логин или пароль");
        break;
      }
    }

    cusers.load_ = function()
    {
      login = getCookie("login");
      pass = getCookie("pass");
      if (login == null || pass == null)
      {
        login = s("login").value;
        pass = s("pass").value;
        setCookie("login="+ login);
        setCookie("pass="+ pass);
      }

      cusers.ajax_post("type=1&action=3");
    }

    cusers.save_ = function()
    {
      cusers.back_ = function(res_login)
      {
        alert("Сохранено");
      }
      var lfm = s("mylfm").value;
      login = getCookie("login");
      pass = getCookie("pass");
      cusers.ajax_post("type=1&action=4&lfm="+ lfm);
    }

    cusers.save_city = function()
    {
      cusers.back_ = function()
      {
        alert("Сохранено");
      }
      login = getCookie("login");
      pass = getCookie("pass");
      var city = s("mycity").value;
      cusers.ajax_post("type=2&action=3&city="+ city);
    }

    cusers.settings_ = function()
    {
      cusers.upd_form_loader = function(res_login)
      {
        s("content").innerHTML = res_login;
        cusers.back_ = function(res_login)
        {
          var res_login = res_login.split("'");
          if (res_login[0]>0)
          {
            cusers.logout();
            alert("Неправильный логин или пароль");
          }
          else
          {
            var lfm = res_login[1];
            var city = res_login[2];
            s("mylfm").value = lfm;
            s("mycity").value = city;
          }
        }
        login = getCookie("login");
        pass = getCookie("pass");

        cusers.ajax_post("type=1&action=3");
      }
      cusers.form_loader("page_edit.html");
    }

    cusers.load_page = function(alias)
    {
      cusers.upd_form_loader = function(res_login)
      {
        s("content").innerHTML = res_login;
        cusers.back_ = function(res_login)
        {
          var res_login = res_login.split("'");
          if (res_login[1] == 1)
          {
            s("mylfm").innerHTML = res_login[2] +" (это вы)";
          }
          else
          {
            s("mylfm").innerHTML = res_login[2];
            s("myuser").innerHTML = "<p><a href=\"#\" onclick=\"cfriends.add_('"+ alias +"');\">Добавить в друзья</a><p><a href=\"#\" onclick=\"cmessages.form_('"+ alias +"');\">Отправить сообщение</a>";
          }
        }
        login = getCookie("login");
        pass = getCookie("pass");
        cusers.ajax_post("type=1&action=2&alias="+ alias);
      }
      cusers.form_loader("user.html");
    }

    cusers.logout = function()
    {
      clearCookie("login="+ login);
      clearCookie("pass="+ pass);
      this_page(1, "1");
    }
  }
