window.onload = function () {
  var selects = document.getElementsByTagName("select");
  for (var i = 0; i < selects.length; i++) {
    selects[i].addEventListener("change", function () {
      this.form.submit();
    });
  }
};
