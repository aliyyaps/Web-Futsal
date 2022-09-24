@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="card">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Arena') }}
                </h6>
                <div class="ml-auto">
                    <a href="/admin/arena/create" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text"> New Arena </span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th> No </th>
                                <th> Jenis Lapangan </th>
                                <th> Gambar </th>
                                <th> Harga </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $arena)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $arena->jenis->nama }}</td>
                                    <td><img width="100px" height="100px" src="{{ asset('storage/' . $arena->image) }}">
                                    </td>
                                    <td>Rp{{ number_format($arena->price, 2, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('arena.edit', $arena->id) }}" class="btn btn-info">
                                                <i class="fa fa-pencil-alt"> Edit </i>
                                            </a>
                                            <form action="/admin/arena/{{ $arena->id }}" class="d-inline" method="POST">
                                                @csrf
                                                @method('delete')
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-danger show_confirm"
                                                    data-toggle="tooltip" title='Delete'><i></i>Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('Data Empty') }}</td>
                                    </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="paginate">
                <div class="container">
                    <div class="row">
                        {{-- <div class="detail-data col-md-12">
                            <p>Page : {!! $arena->currentPage() !!} <br />
                                Jumlah Arena : {!! $arena->total() !!} <br />
                                Arena Per Halaman : {!! $arena->perPage() !!} <br />
                            </p>
                        </div> --}}
                        <div class="mx-auto">
                            <div class="paginate-button col-md-12">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record? `,
                    text: "If you delete this, it will be gone forever.",
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
    </script>
@endsection
