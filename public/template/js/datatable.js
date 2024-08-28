$(document).ready(function () {
    var table = $('#example').DataTable({

        columnDefs: [{
            'className': 'text-center',
            'targets': '_all'
        }],

        buttons: [



            'excel',
            'spacer',
            'spacer',
            'spacer',
            'colvis']
    });

    table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
});
