@extends('layouts.backend.app')

@section('title', 'Post')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                My Favorite Posts
                                <span class="badge bg-blue">{{ $posts->count() }}</span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th><i class="material-icons">favorite</i></th>
                                            <th><i class="material-icons">visibility</i></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th><i class="material-icons">favorite</i></th>
                                            <th><i class="material-icons">visibility</i></th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($posts as $key=>$post)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ str_limit($post->title, 10) }}</td>
                                                <td>{{ $post->user->name }}</td>
                                                <td>{{ $post->favorite_to_users->count() }}</td>
                                                <td>{{ $post->view_count }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.post.show', $post->id) }}" class="btn btn-primary waves-effect">
                                                        <i class="material-icons">visibility</i>
                                                    </a>
                                                    <button class="btn btn-danger waves-effect" type="button" onclick="removeFavPost({{ $post->id }})">
                                                        <i class="material-icons">clear</i>
                                                    </button>
                                                    <form id="remove-form-{{ $post->id }}" action="{{ route('post.favorite', $post->id) }}" method="post" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>

    {{-- Sweet Alert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script type="text/javascript">
        function removeFavPost(id) {
            const swalWithBootstrapButtons = swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
          })

            swalWithBootstrapButtons({
              title: 'Are you sure?',
              text: "You want to remove this post from favorite lists!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, remove it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
          }).then((result) => {
              if (result.value) {
                event.preventDefault();
                document.getElementById('remove-form-'+id).submit();
            } else if (
    // Read more about handling dismissals
    result.dismiss === swal.DismissReason.cancel
    ) {
                swalWithBootstrapButtons(
                  'Cancelled',
                  'Your data is safe :)',
                  'error'
                  )
            }
        })
      }
  </script>
@endpush