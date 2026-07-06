// Search Function

$('#searchForm').on('submit', function (e) {

    e.preventDefault();
    let input = $('.header_search_input').val();

    if (input == '') {
        Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,

        }).fire({
            icon: "info",
            title: "Search Can Not Be Empty",
        });

    } else {
        $.ajax({
            url: '/search-check',
            method: "POST",
            data: {
                search: input.trim()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                console.log(response);

                if (!response.success) {
                    Swal.mixin({
                        toast: true,
                        position: "top",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,

                    }).fire({
                        icon: "error",
                        title: response.message ?? "Product Not Found ",
                    });
                }
                else {
                    console.log(input);
                    // window.location.href = '/search/' + input + '';
                    window.location.href = '/search?result=' + encodeURIComponent(input);
                    // console.log(response);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
                location.reload();
            }
        })
    }
})