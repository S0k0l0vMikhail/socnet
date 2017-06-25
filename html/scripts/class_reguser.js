  function class_reguser()
  {
    creguser = new main_class();
    creguser.back_ = function(res_login)
    {
      var res_login = res_login.split("'");
      var username_len = s("username").value.length;
      var password_len = s("password").value.length;
      var email_len = s("email").value.length;
      var result = "<p>";
      switch(res_login[2])
      {
        case '1':
          if (s("password").value != s("password_r").value)
           result += "<p>Пароли не совпадают";

          if (password_len<6)
           result += "<p>Длина пароля должна быть не менее 6 символов";

          if (password_len>30)
           result += "<p>Длина пароля должна быть не более 30 символов";

          s("password").className = 'myerror';
          s("password_r").className = 'myerror';
        break;
        case '2':
          if (username_len<6)
            result += "<p>Длина имени пользователя должна быть не менее 6 символов";
          if (username_len>30)
            result += "<p>Длина имени пользователя должна быть не более 30 символов";

          s("username").className = 'myerror';
        break;
        case '3':
          if (email_len<6)
            result += "<p>Вы не ввели email (он должен быть не менее 6 знаков)";
          if (email_len>30)
            result += "<p>Длина e-mail превышает допустимую длину, он должен быть не более 30 знаков";

          s("email").className = 'myerror';
        break;
        case '4':
          result += "<p>Пользователь с таким логином или e-mail уже зарегистрирован";
          s("username").className = 'myerror';
          s("email").className = 'myerror';
        break;
        default:
          s("content").innerHTML = "<div id = \"error_reg\">Регистрация успешно выполнена, на ваш e-mail выслано уведомление с кодом активации";
        break;
      }
      s("error_reg").innerHTML = result;
    }

    creguser.load_ = function()
    {
      alert("Запросить восстановление пароля");
    }

    creguser.save_ = function()
    {
      var username = s("username").value;
      var password = s("password").value;
      var password_r = s("password_r").value;
      var email = s("email").value;

      login = getCookie("login");
      pass = getCookie("pass");

      creguser.ajax_post("type=0&action=1&username="+ username +"&password="+ password +"&password_r="+ password_r +"&myemail="+ email);
    }
  }
