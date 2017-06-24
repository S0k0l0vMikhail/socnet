function all_class()
{
  class_reguser(); class_users(); class_fotos(); class_fotoalbums();
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
          case 1: // Индексная страница
            form_loader("main_page.html", "content");
          break;
          case 2: // Форма регистрации
            form_loader("form_reg.html", "content");
          break;
          case 3:
            alert("Вывести список контактов");
          break;
        }
      break;
      default:
        s("content").innerHTML = "Страница пользователя или что-либо еще";
      break;
    }
  }
}
