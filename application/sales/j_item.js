//
$(document).on("click", "#btnadd", function() {
  $(".contentharga").remove();
  $("#modalmasteritem").modal('show');
  newitem();
});

//
function newitem() {
  $("#txtiditem").val("*New");
  $("#txtname").val("");
  $("#txtstock").val(0);
  $("#txtprice").val(0);
  $("#txtnote").val("");
  $("#inputcrud").val("N");
  $("#txtunit").change();
  set_focus("#txtname");
}

//
$(document).on("click", ".btnedit", function() {
  var id_item = $(this).attr("id_item");
  var value = {
    id_item: id_item,
    method: "get_detail_item"
  };
  $.ajax({
    url: "c_item.php",
    type: "POST",
    data: value,
    success: function(data, textStatus, jqXHR) {
      var hasil = jQuery.parseJSON(data);
      data = hasil.data;
      $("#inputcrud").val("E");
      $("#txtiditem").val(data.id_item);
      $("#txtname").val($.trim(data.item_name));
      $("#txtunit").val($.trim(data.unit));
      $("#txtstock").val(data.stock);
      $("#txtprice").val(addCommas(data.price));
      $("#txtnote").val($.trim(data.note));
      $("#modalmasteritem").modal('show');
      set_focus("#txtname");
    },
    error: function(jqXHR, textStatus, errorThrown) {}
  });
});

//
$(document).on("click", "#btnsaveitem", function() {
  var id_item = $("#txtiditem").val();
  var item_name = $("#txtname").val();
  var unit = $("#txtunit").val();
  var stock = cleanString($("#txtstock").val());
  var price = cleanString($("#txtprice").val());
  var note = $("#txtnote").val();
  var crud = $("#inputcrud").val();
  if (crud == 'E') {
    if (id_item == '' || id_item == null) {
      $.notify({
        message: "Item Id invalid"
      }, {
        type: 'warning',
        delay: 8000,
      });
      $("#txtiditem").focus();
      return;
    }
  }

  if (item_name == '' || item_name == null) {
    $.notify({
      message: "Please fill out item name"
    }, {
      type: 'warning',
      delay: 8000,
    });
    $("#txtname").focus();
    return;
  }

  var value = {
    id_item: id_item,
    item_name: item_name,
    unit: unit,
    stock: stock,
    price: price,
    note: note,
    crud: crud,
    method: "save_item"
  };
  $(this).prop('disabled', true);
  proccess_waiting("#infoproses");
  $.ajax({
    url: "c_item.php",
    type: "POST",
    data: value,
    success: function(data, textStatus, jqXHR) {
      $("#btnsaveitem").prop('disabled', false);
      $("#infoproses").html("");
      var data = jQuery.parseJSON(data);
      if (data.ceksat == 0) {
        $.notify(data.error);
      } else {
        if (data.crud == 'N') {
          if (data.result == 1) {
            $.notify('Save item successfuly');
            var table = $('#table_item').DataTable();
            table.ajax.reload(null, false);
            newitem();
          } else {
            $.notify({
              message: "Error save item, error :" + data.error
            }, {
              type: 'danger',
              delay: 8000,
            });
            set_focus("#txtiditem");
          }
        } else if (data.crud == 'E') {
          if (data.result == 1) {
            $.notify('Update item successfuly');
            var table = $('#table_item').DataTable();
            table.ajax.reload(null, false);
            $("#modalmasteritem").modal("hide");
          } else {
            $.notify({
              message: "Error update item, error :" + data.error
            }, {
              type: 'danger',
              delay: 8000,
            });
            set_focus("#txtiditem");
          }
        } else {
          $.notify({
            message: "Invalid request"
          }, {
            type: 'danger',
            delay: 8000,
          });
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $("#btnsaveitem").prop('disabled', false);
    }
  });
});

//
$(document).on("click", ".btndelete", function() {
  var id_item = $(this).attr("id_item");
  swal({
      title: "Delete",
      text: "Delete master item with id : " + id_item + " ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Delete",
      closeOnConfirm: true
    },
    function() {
      var value = {
        id_item: id_item,
        method: "delete_item"
      };
      $.ajax({
        url: "c_item.php",
        type: "POST",
        data: value,
        success: function(data, textStatus, jqXHR) {
          var data = jQuery.parseJSON(data);
          if (data.result == 1) {
            $.notify('Delete item successfuly');
            var table = $('#table_item').DataTable();
            table.ajax.reload(null, false);
          } else {
            $.notify({
              message: "Error delete item, error :" + data.error
            }, {
              type: 'eror',
              delay: 8000,
            });
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {}
      });
    });
});

// Inicialização
$(document).ready(function() {
  money();
  decimal();
  var value = {
    method: "getdata"
  };
  $('#table_item').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": false,
    "responsive": true,
    "autoWidth": false,
    "pageLength": 50,
    "dom": '<"top"f>rtip',
    "ajax": {
      "url": "c_item.php",
      "type": "POST",
      "data": value,
    },
    "columns": [
      { "data": "urutan" },
      { "data": "id_item" },
      { "data": "item_name" },
      { "data": "price" },
      { "data": "stock" },
      { "data": "note" },
      { "data": "button" },
    ]
  });
  $("#table_item_filter").addClass("pull-right");
});