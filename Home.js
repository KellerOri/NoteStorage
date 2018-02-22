$(document).ready(function() {

  $("#register-btn").click(function(){
    $("#register-form-container").show();
    $("#btn-group").hide();
  });

  $("#login-btn").click(function() {
    $("#login-form-container").show();
    $("#btn-group").hide();
  })

  // $("#submit-login").click(function() {
  //   $.post("Login.php", {
  //     // name: $("#login-name").val(),
  //     // password: $("#login-password").val()
  //   }, function (data, status) {
  //     alert("Data: " + data + "\nStatus: " + status);
  //   });
  // });
});
