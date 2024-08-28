$('.confirm-delete').click(function (event) {
    let form = $(this).closest("form");
    event.preventDefault();
    swal({
        title: `Yakin Hapus Data?`,
        text: "Data Akan Selamanya Terhapus",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
});




