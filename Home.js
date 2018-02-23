$(document).ready(function() {

  var global_userID = 0;

  function setGlobalUserID(id) {
    global_userID = id;
  }

  function getGlobalUserID() {
    return global_userID;
  }

  $("#register-btn").click(function(){
    $("#register-form-container").show();
    $("#btn-group").hide();
  });

  $("#login-btn").click(function() {
    $("#login-form-container").show();
    $("#btn-group").hide();
  });

  $("#submit-login").click(function() {
    var lName = $("#login-name").val();
    var lPass = $("#login-pass").val();
    var err = "";

    $.post("Login.php", {
      name: lName,
      password: lPass
    },
    function(data, status){
      if (data.success){
        var login_data = data.user[0];
        setGlobalUserID(login_data.userID);
        $("#home-body").hide();
        $("#note-body").show();
        $("#login-profile").text("Now logged in as: " + login_data.name);
        $("#logout-btn").show;
        findAndLoadNotes(login_data.userID);
      } else {
        err = data.errorMsg;
      }
    });

    $("#errorMsg").text(err);

  });

  $("#submit-note").click(function () {
    var nTitle = $("#note-title").val();
    var nContent = $("#note-content").val();
    var nUserID = getGlobalUserID();

    console.log(nUserID);

    var err = "";

    $.post("Create_Note.php", {
      title: nTitle,
      content: nContent,
      user_id: nUserID
    }, function (data, status) {
      console.log(data);
      if(data.success){
        loadNote(nTitle, nContent);
      } else {
        err = data.errorMsg;
      }
    });

    $("#errorMsg").text(err);
  });

  $("#logout-btn").click(function() {
    var logout = confirm("Logging out?")

    if (logout){
      global_userID = 0;
      $("#note-body").hide();
      $("#home-body").show();
    }
  })

  function findAndLoadNotes(userID){
    var err = "";

    $.post("Notes.php", {
      user_id: userID
    },
    function (data, status) {
      if (data.success) {
        var notes = data.note;
        for (n in notes){
          loadNote(notes[n].title, notes[n].content);
        }
      } else {
        err = data.errorMsg;
      }
    });

    $("#errorMsg").text(err);
  }

  function loadNote(title, content) {
    console.log(title);
    var txt = $("<li class='note'><div class='note-header'>" + title + "</div><p class='note-content'>" + content + "</p></li>")
    $("#notes-displayed").prepend(txt);
  }
});
