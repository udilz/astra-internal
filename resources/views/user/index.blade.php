@extends('layout.app')
@section('title', 'imt-astraudso | User Management')
@section('content')
    <!-- Page Heading -->
    @include('sweetalert::alert')
    <h1 class="h3 mb-2 text-gray-800 mb-4">User Management</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">

            @if (auth()->user()->level == 'Admin' )
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i>
                    Tambah Data</a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>User ID</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($usermanagement as $key => $items)
                            <tr class="text-center">

                                <td>{{ $no++ }}</td>
                                <td>{{ $items->nama }}</td>
                                <td>{{ $items->userid }}</td>

                                <td>
                                    <span class="badge badge-success">
                                        {{ $items->level }}
                                    </span>
                                </td>


                                <td class="text-center">
                                    <div class="">

                                        <form action="{{ route('user.destroy', $items->userid) }}" method="POST"
                                            class="ml-2">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button class="btn btn-sm btn-danger confirm-delete"><i class="fa fa-trash"></i>
                                                Delete</button>

                                        </form>

                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection

@push('datatable')
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "className": "text-center",
                    "targets": "_all"
                }]

            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
