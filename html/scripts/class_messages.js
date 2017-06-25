  function class_messages()
  {
    cmessages = new main_class();

    cmessages.list_in = function()
    {
// Входящие
      login = getCookie("login");
      pass = getCookie("pass");
      cmessages.back_ = function(res_login)
      {
        var res_login = res_login.split("'");
        if (res_login[0]>0)
        {
          alert("Неправильный логин или пароль");
          this_page(1, "1");
        }
        else
        {
          s("content").innerHTML = "<p><a href=\"#\" onclick=\"cmessages.list_out();\">Исходящие</a><p>"+ res_login[1];
        }
      }
      cmessages.ajax_post("type=4&action=2&message_type=1");
    }

    cmessages.list_out = function()
    {
// Исходящие
      login = getCookie("login");
      pass = getCookie("pass");
      cmessages.back_ = function(res_login)
      {
        var res_login = res_login.split("'");
        if (res_login[0]>0)
        {
          alert("Неправильный логин или пароль");
          this_page(1, "1");
        }
        else
        {
          s("content").innerHTML = "<p><a href=\"#\" onclick=\"cmessages.list_in();\">Входящие</a><p>"+ res_login[1];
        }
      }
      cmessages.ajax_post("type=4&action=2&message_type=0");
    }

    cmessages.form_ = function(alias)
    {
      cmessages.upd_form_loader = function(res_login)
      {
        s("content").innerHTML = res_login;
        s("alias_user").value = alias;
      }
      cmessages.form_loader("send_messages.html");
    }

    cmessages.send = function()
    {
      login = getCookie("login");
      pass = getCookie("pass");
      var alias = s("alias_user").value;
      var text_message = s("text_message").value;
      cmessages.back_ = function(res_login)
      {
        var res_login = res_login.split("'");
        if (res_login[0]>0)
        {
          alert("Неправильный логин или пароль");
          this_page(1, "1");
        }
        else
        {
          s("content").innerHTML = res_login[1];
        }
      }
      cmessages.ajax_post("type=4&action=1&alias="+ alias +"&message_text="+ text_message);
    }
  }
