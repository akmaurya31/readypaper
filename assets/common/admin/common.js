$(document).ready(function () {
    //datatables
    table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "ordering": false,

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": controllerListUrl,
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": -1, //last column
                "orderable": false, //set not orderable
            },
            {
                "targets": -2, //2 last column (photo)
                "orderable": false, //set not orderable
            },
            {
                "targets": -3, //2 last column (photo)
                "orderable": false, //set not orderable
            }
        ],

    });

    //datepicker
   /* $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });*/

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function () {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function () {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function () {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});



 //common ajax update status data to database
 function statusUpdate(id, status) {
    $.ajax({
         url: statusUrl,
         type: "POST",
         dataType : "json",
         data: {id:id,status:status},
         success: function (data)
         {
             reload_table();
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
             alert('Error updating status data');
         }
     });
 }




  //common delete   
    function deleteData(id)
    {
        if (confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url: deleteUrl,
                type: "POST",
                dataType: "JSON",
                data:{id:id},
                success: function (data){
                   reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Error deleting data');
                }
            });
        }
    }
//reload table function
function reload_table()
{
    table.ajax.reload(null, false); //reload datatable ajax 
}
