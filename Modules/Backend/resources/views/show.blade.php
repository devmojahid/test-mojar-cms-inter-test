@extends('backend::layouts.master')
@section('content')
    @php
        $pages = \Modules\Backend\Models\Page::all();
    @endphp
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                @forelse ($pages as $page)
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-danger card-img-holder text-white">
                            <div class="card-body">
                                <h4 class="card-title">
                                    {{ $page->title }}
                                    <a href="" class="btn btn-primary float-end">Edit</a>
                                </h4>
                                <p>{!! $page->content !!}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            No pages found.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
