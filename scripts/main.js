function this_page (type, id){
  if (type> 0){
    if (type == 1){ // 1 - регистрация
      alert (id);
      form_loader("form_reg.html", "content");
      s("content").innerHTML = "загрузить форму";
    }
    else {
      s("content").innerHTML = "Страница пользователья или";
    }
  }
}
