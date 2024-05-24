@extends('backend::layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/laraberg/css/laraberg.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-body">
                    <h4 class="card-title">Add Page</h4>
                    <form action="{{ route('admin.store-page') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <textarea id="content" name="content" hidden></textarea>
                        {{-- <div id="laraberg"></div> --}}
                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <script src="{{ asset('js/custom-blocks.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Laraberg.init('content', {
                height: '600px'
            });
        });
    </script>
@endpush
