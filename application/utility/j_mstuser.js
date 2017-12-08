
//
$(document).on("click", "#check-all", function () {
  if ($(this).is(':checked')) {
    $('.chkbox:enabled').prop('checked', true);
  } else {
    $('.chkbox').prop('checked', false);
  }
  get_check_value();
});

//
$(document).on("click", ".chkbox", function () {
  get_check_value();
});

//
function get_check_value() {
  var values = [];
  $('.chkbox:checked').each(function () {
    values.push($(this).val());
  });
  $('#hmenu').val(values.join(','));
}

//
$(document).on("click", "#btnadd", function () {
  $("#modalmasteruser").modal('show');
  $("#txtiduser").val(0);
  $("#txtusername").val("");
  $("#inputcrud").val("N");
  set_focus("#txtusername");
});

//
$(document).on("click", ".btnedit", function () {
  var id_user = $(this).attr("id_user");
  var username = $(this).attr("username");
  var h_menu = $(this).attr("h_menu");
  $("#inputcrud").val("E");
  $("#txtiduser").val(id_user);
  $("#txtusername").val(username);
  $("#txtpass").val("***********");
  $("#hmenu").val(h_menu);
  $('.chkbox').prop('checked', false);
  var res = h_menu.split(",");
  for (i = 0; i < res.length; i++) {
    $("#check-" + res[i]).prop('checked', true);
  }
  $("#modalmasteruser").modal('show');
  set_focus("#txtusername");
});

//
$(document).on("click", "#btnsaveuser", function () {
  var id_user = $("#txtiduser").val();
  var username = $("#txtusername").val();
  var pass_user = $("#txtpass").val();
  var hmenu = $("#hmenu").val();
  var crud = $("#inputcrud").val()

  if (username == '' || username == null) {
    $.notify({
      message: "Please fill out username!"
    }, {
      type: 'warning',
      delay: 10000,
    });
    $("#txtusername").focus();
    return;
  }

  if (username.toUpperCase() == 'ADMIN') {
    $.notify({
      message: "Please Do Not use 'ADMIN' as username"
    }, {
      type: 'warning',
      delay: 10000,
    });
    $("#txtusername").focus();
    return;
  }

  if (pass_user == '' || pass_user == null) {
    $.notify({
      message: "Please fill out password"
    }, {
      type: 'warning',
      delay: 10000,
    });
    $("#txtpass").focus();
    return;
  }

  //
  var value = {
    id_user: id_user,
    username: username,
    pass_user: pass_user,
    h_menu: hmenu,
    crud: crud,
    method: "save_user"
  };
  $("#btnsaveuser").prop('disabled', true);
  proccess_waiting("#infoproses");
  $.ajax({
    url: "c_mstuser.php",
    type: "POST",
    data: value,
    success: function (data, textStatus, jqXHR) {
      $("#btnsaveuser").prop('disabled', false);
      $("#infoproses").html("");
      var data = jQuery.parseJSON(data);
      if (data.crud == 'N') {
        if (data.result == true) {
          $.notify("Save new user successfully");
          var table = $('#table_user').DataTable();
          table.ajax.reload(null, false);
          $("#txtiduser").val("");
          $("#txtusername").val("");
          $("#pass_user").val("");
          set_focus("#txtusername");

        } else {
          $.notify({
            message: "Error save new user , Error : " + data.error
          }, {
            type: 'danger',
            delay: 10000,
          });
          set_focus("#txtusername");
        }
      } else if (data.crud == 'E') {
        if (data.result == true) {
          $.notify("Update user successfully");
          var table = $('#table_user').DataTable();
          table.ajax.reload(null, false);
          $("#modalmasteruser").modal("hide");

        } else {
          $.notify({
            message: "Error save new user , Error : " + data.error
          }, {
            type: 'danger',
            delay: 10000,
          });
          set_focus("#txtiduser");
        }
      } else {
        $.notify({
          message: "Invalid Order!"
        }, {
          type: 'danger',
          delay: 10000,
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $("#btnsaveuser").prop('disabled', false);
    }
  });
});

//
$(document).on("click", ".btnpass", function () {
  var id_user = $(this).attr("id_user");
  $("#txthiduser").val(id_user);
  $("#passwordmodal").modal("show");
  set_focus("#txtresetpass");
})

//
$(document).on("click", "#btnresetpassword", function () {
  var id_user = $("#txthiduser").val();
  var new_pass = $("#txtresetpass").val();
  swal({
      title: "Reset Password",
      text: "Reset Password?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Reset",
      closeOnConfirm: true
    },
    function () {
      var value = {
        id_user: id_user,
        new_pass: new_pass,
        crud: 'D',
        method: "reset_password"
      };

      $.ajax({
        url: "c_mstuser.php",
        type: "POST",
        data: value,
        success: function (data, textStatus, jqXHR) {
          var data = jQuery.parseJSON(data);
          if (data.result == true) {
            $.notify("Reset password successfully");
            $("#passwordmodal").modal("hide");
          } else {
            $.notify({
              message: "Error reset password , Error : " + data.error
            }, {
              type: 'danger',
              delay: 10000,
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $.notify({
            message: "Error : " + textStatus
          }, {
            type: 'danger',
            delay: 10000,
          });
        }
      });
    });
})

//
$(document).on("click", ".btndelete", function () {
  var id_user = $(this).attr("id_user");
  swal({
      title: "Delete ",
      text: "Delete user with id : " + id_user + " ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Delete",
      closeOnConfirm: true
    },
    function () {
      var value = {
        id_user: id_user,
        crud: 'D',
        method: "delete_user"
      };

      $.ajax({
        url: "c_mstuser.php",
        type: "POST",
        data: value,
        success: function (data, textStatus, jqXHR) {
          var data = jQuery.parseJSON(data);
          if (data.result == true) {
            $.notify("Delete user successfully");
            var table = $('#table_user').DataTable();
            table.ajax.reload(null, false);
          } else {
            $.notify({
              message: "Error delete user , Error : " + data.error
            }, {
              type: 'danger',
              delay: 10000,
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $.notify({
            message: "Error : " + textStatus
          }, {
            type: 'danger',
            delay: 10000,
          });
        }
      });
    });
});

// Inicialização
$(document).ready(function () {
  var value = {
    method: "getdata"
  };
  $('#table_user').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "responsive": true,
    "autoWidth": false,
    "pageLength": 50,
    "dom": '<"top"f>rtip',
    "ajax": {
      "url": "c_mstuser.php",
      "type": "POST",
      "data": value,
    },
    "columns": [{
      "data": "id_user"
    }, {
      "data": "username"
    }, {
      "data": "h_menu"
    }, {
      "data": "button"
    }, ]
  });
});
