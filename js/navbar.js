$(document).ready(function() {
  $('#hrefLogOut').click(function() {
      deleteCookie('token');
      window.location="/";
  });
})
