@extends('layouts.app')

@section('main')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <form method="POST" action="{{ route('updateprofile', $user) }}" enctype="multipart/form-data"
                        class="card-body text-center">
                        @csrf
                        @method('PUT')

                        <!-- Profile Image -->
                        <div class="text-start mb-4">Profile Image:
                            <img src="{{ asset('storage/' . $user->profile_image) }}" height="60"
                                class="rounded-circle mb-3" alt="User Image">
                            <input type="file" name="image" class="form-control" value="{{ $user->profile_image }}">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User Details -->
                        <div class="text-start">
                            <strong>Name:</strong>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <strong>Email:</strong>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" disabled>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <strong>Bio:</strong>
                            <textarea id="summernote" name="bio" value="{{ $user->bio }}">{{ $user->bio }}</textarea>
                            @error('bio')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Save</button>

                    </form>
                </div>
            </div>
        </div>

        @if (session('success'))
            <script>
                toastr.success('{{ session('success') }}')
            </script>
        @endif
    </div>
@endsection
