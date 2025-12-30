@extends('layouts.app')

@section('main')
    <div class= "container mt-4">

        <h3>Categories</h3>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Category
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('category.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="category-name" class="col-form-label">Category Name:</label>
                                <input type="text" class="form-control" name="category_name" required>

                                @error('category_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id ="editForm" method= "POST" action="{{ route('category.update', ':category') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="category-name" class="col-form-label">Category Name:</label>

                                <input type="text" class="form-control" name="category_name" id="category-name"
                                    class="@error('category_name') is-invalid @enderror" required>
                                @error('category_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (count($categories) > 0)
            <table class="table">
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->category_name }} </td>

                            <td> <button type="button" class="btn btn-primary edit" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-id="{{ $category->id }}">Edit </button> </td>

                            <td>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        @else
            <h1 class="text-center"> No Category Found </h1>
        @endif
    </div>

    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}')
        </script>
    @endif


    @session('edit_id')
        <script>
            $(document).ready(function() {

                $('#editModal').modal('show');

                prefillCategoryDetail({{ session('edit_id') }});

            })
        </script>
    @endsession

    <script>
        $(document).ready(function() {

            $('.edit').on('click', function() {

                var id = $(this).data('id');

                prefillCategoryDetail(id);
            })

        })

        function prefillCategoryDetail(id) {

            var url = "{{ route('category.edit', ':category') }}".replace(':category', id);
            var updateUrl = "{{ route('category.update', ':category') }}".replace(':category', id);

            $('#editForm').attr('action', updateUrl);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(res) {
                    $('#category-name').val(res.category_name);
                },
                error: function(error) {
                    alert('error fetching category data', error);
                }
            });
        }
    </script>
@endsection
