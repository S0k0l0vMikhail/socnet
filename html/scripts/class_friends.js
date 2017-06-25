  function class_friends()
  {
    cfriends = new main_class();

    cfriends.add_ = function(alias)
    {
      login = getCookie("login");
      pass = getCookie("pass");
      cfriends.back_ = function(res_login)
      {
        var res_login = res_login.split("'");
        s("myuser").innerHTML = res_login[1];
      }
      cfriends.ajax_post("type=3&action=1&alias="+ alias);
    }

    cfriends.list_ = function()
    {
      login = getCookie("login");
      pass = getCookie("pass");
      cfriends.back_ = function(res_login)
      {
        var res_login = res_login.split("'");
        if (res_login[0]>0)
        {
          alert("Неправильный логин или пароль");
          this_page(1, "1");
        }
        else
          s("content").innerHTML = res_login[1];
      }
      cfriends.ajax_post("type=3&action=2");
    }

    cfriends.accept_ = function(id)
    {
      login = getCookie("login");
      pass = getCookie("pass");
      cfriends.back_ = function(res_login)
      {
        var res_login = res_login.split("'");
        if (res_login[0]>0)
        {
          alert("Неправильный логин или пароль");
          this_page(1, "1");
        }
        else
          s("content").innerHTML = res_login[1];
      }
      cfriends.ajax_post("type=3&action=4&id="+ id);
    }

    cfriends.delete_ = function(id)
    {
      login = getCookie("login");
      pass = getCookie("pass");
      cfriends.back_ = function(res_login)
      {
        var res_login = res_login.split("'");
        if (res_login[0]>0)
        {
          alert("Неправильный логин или пароль");
          this_page(1, "1");
        }
        else
          s("content").innerHTML = res_login[1];
      }
      cfriends.ajax_post("type=3&action=5&id="+ id);
    }
  }
