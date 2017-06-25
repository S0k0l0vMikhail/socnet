  function all_class()
  {
    class_reguser(); class_users(); class_friends(); class_messages(); class_fotos(); class_fotoalbums(); 
  }

  function setCookie(data)
  {
    document.cookie = data +"; max-age="+ (120*120*40) +"; path=/";
  }

  function clearCookie(data)
  {
    var mydate = new Date();
    mydate.setTime(mydate.getTime()-100);
    document.cookie = data +"; expires="+ mydate.toGMTString() +"; path=/";
  }

  function log_in()
  {
    login = getCookie("login");
    pass = getCookie("pass");
    if (login == null || pass == null)
    {
      return 1;
    }
    else
    {
      cusers.load_();
    }
  }

  function this_page(type, id)
  {
    all_class();
    if (type>0)
    {
      switch(type)
      {
        case 1:
          switch(id)
          {
            case '1': // Индексная страница
              if (log_in())
               form_loader("main_page.html", "content");
            break;
            case '2': // Форма регистрации
              if (log_in())
                form_loader("form_reg.html", "content");
            break;
            case '3':
              cfriends.list_();
            break;
            case '4':
              cmessages.list_in();
            break;
            case '5':
              cusers.settings_();
            break;
          }
        break;
        case 2:
          s("content").innerHTML = "Идет загрузка..";
          cusers.load_page(id);
        break;
        default:
          s("content").innerHTML = "Другой тип страницы";
        break;
      }
    }
  }
