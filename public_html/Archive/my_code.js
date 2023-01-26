$(document).ready(function() {
    var cv = '<? echo $username; ?>';
    setInterval(function() {
//       alert (cv);
       $.post( "menu.php", {userName: cv})
         .done(function(data) {
         $(".sub1").html(data);
  });
  }, 5000);
});
