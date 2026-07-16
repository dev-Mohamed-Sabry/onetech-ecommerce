// { { --DataTables Show Products data-- } }

let table = new DataTable('#orderTable', {
    processing: true,
    serverSide: true,
    ajax: "/orders",
    // order: [[2, 'asc']],    //ترتيب العمود التاني  تصاعدي 
    columns: [
        { data: 'name', name: 'name', orderable: true },
        { data: 'total', name: 'total', orderable: true },
        { data: 'status', name: 'status', orderable: false, searchable: true },
        { data: 'created_at', name: 'created_at', orderable: false, searchable: true },
        { data: 'action', name: 'action', orderable: false, searchable: true },
    ]
});



$(document).on('change', '.change-status', function () {

    let orderId = $(this).data('id');
    let status = $(this).val();

    if (!status) return;

    Swal.fire({
        title: 'Are you sure?',
        text: 'Change order status to ' + status + ' ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }


        $.ajax({
            url: '/orders/' + orderId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                order_id: orderId,
                status: status,
                _method: "PUT"
            },

            success: function () {

                $('#orderTable').DataTable().ajax.reload(null, false);

                Swal.fire({
                    icon: 'success',
                    title: 'Status updated',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });

    });

});