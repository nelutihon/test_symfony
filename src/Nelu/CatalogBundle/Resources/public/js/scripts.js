$(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function() {
        $(this).removeData('bs.modal');
    });
    $(document).on("click", ".btn-delete", function(e) {
        if (confirm('You are about to delete this object. Do you want to continue ?')) {
            var form = $(this).parent('form');
            var t = this;
            $.post(form.attr('action'), form.serialize(), function(data) {
                console.log(data);
                var response = $.parseJSON(data);
                if (response.success == true) {
                    $(t).closest('tr').remove();
                }
            })
                    .error(function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    });
        }
        return false;
    })


})