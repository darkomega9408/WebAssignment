$(document).ready(function() {
  $('.language li:not(.active)').click(function() {
      setCookie('lang', $(this).attr('data-lang'), 30);
      console.warn('haha');
      document.location.reload();
  });
})
