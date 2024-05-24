@extends('backend::layouts.master')
@push('styles')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <section class="content-header info-box p-3 rounded">
                <div class="container-fluid">
                    <div class="row mb-2 mt-2">
                        <div class="col-sm-6">
                            <h3 class="card-title">{{ __('dashboard.menu_builder') }}</h3>
                        </div>

                    </div>
                </div>
            </section>
            <form id="eventForm" action="" method="POST">
                @csrf
                <div class="row mb-4 align-items-center">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menuTitle">{{ __('dashboard.edit_menu') }}</label>
                                    <input type="text" name="title" class="form-control" id="menuTitle" value=""
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="menuTitle">{{ __('dashboard.edit_menu_location') }}</label>
                                        <select class="form-control" name="location" id="menuLocation">
                                            <option value="" disabled>{{ __('dashboard.select_location') }}</option>
                                            <option value="header">
                                                {{ __('dashboard.header') }}</option>
                                            <option value="footer_1">
                                                {{ __('dashboard.footer_1') }}</option>
                                            <option value="footer_2">
                                                {{ __('dashboard.footer_2') }}</option>
                                        </select>
                                        <small id="menuLocation"
                                            class="form-text text-muted">{{ __('dashboard.menu_note_location') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-2">
                        <div class="form-group">
                            <button class="btn btn-primary" id="update_menu">Update Menu</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card tp-appe-menu">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('dashboard.all_menu') }}</h3>
                            </div>
                            <div class="card-body p-2">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100 collapsed" data-toggle="collapse"
                                                    href="#collapseOne" aria-expanded="false">
                                                    Pages
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                                            <div class="card-body"
                                                style="height:300px; overflow-y: scroll background-color: #e9e0e0d7;">
                                                <div class="pages-list">
                                                    <div class="form-group">
                                                        @if (isset($pages))
                                                            @foreach ($pages as $page)
                                                                <div class="custom-control custom-checkbox my-1">
                                                                    <input class="custom-control-input page_checkbox_value"
                                                                        type="checkbox"
                                                                        id="customCheckbox-pages-{{ $page->id }}"
                                                                        value="{{ $page->id }}">
                                                                    <label for="customCheckbox-pages-{{ $page->id }}"
                                                                        class="custom-control-label">{{ $page->title }}</label>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button class="btn tp-add-lesson-btn btn-primary" id="add_pages_in_field">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-plus-square">
                                                            <rect x="3" y="3" width="18" height="18" rx="2"
                                                                ry="2"></rect>
                                                            <line x1="12" y1="8" x2="12"
                                                                y2="16">
                                                            </line>
                                                            <line x1="8" y1="12" x2="16"
                                                                y2="12">
                                                            </line>
                                                        </svg>
                                                    </span>
                                                    add to menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100 collapsed" data-toggle="collapse"
                                                    href="#collapseTwo" aria-expanded="false">
                                                    Courses
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                            <div class="card-body"
                                                style="height:300px; overflow-y: scroll background-color: #e9e0e0d7;">
                                                <div class="pages-list">
                                                    <div class="form-group">
                                                        @if (isset($courses))
                                                            @foreach ($courses as $course)
                                                                <div class="custom-control custom-checkbox my-1">
                                                                    <input
                                                                        class="custom-control-input course_checkbox_value"
                                                                        type="checkbox"
                                                                        id="customCheckbox-{{ $course->id }}"
                                                                        value="{{ $course->id }}">
                                                                    <label for="customCheckbox-{{ $course->id }}"
                                                                        class="custom-control-label">{{ $course->title }}</label>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="custom-control custom-checkbox my-1">
                                                                <label for="customCheckbox1"
                                                                    class="custom-control-label">No
                                                                    Course Found</label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button class="btn tp-add-lesson-btn btn-primary"
                                                    id="add_courses_in_field">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-plus-square">
                                                            <rect x="3" y="3" width="18" height="18"
                                                                rx="2" ry="2"></rect>
                                                            <line x1="12" y1="8" x2="12"
                                                                y2="16">
                                                            </line>
                                                            <line x1="8" y1="12" x2="16"
                                                                y2="12">
                                                            </line>
                                                        </svg>
                                                    </span>
                                                    add to menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- castom link  --}}
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100 collapsed" data-toggle="collapse"
                                                    href="#collapseThree" aria-expanded="false">
                                                    Custom Link
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                                            <div class="card-body"
                                                style="height:300px; overflow-y: scroll background-color: #e9e0e0d7;">
                                                <div class="pages-list">
                                                    <div class="form-group row">
                                                        <label for="custom_url"
                                                            class="col-sm-2 col-form-label">Url:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="custom_url"
                                                                placeholder="https://">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="link_text" class="col-sm-2 col-form-label">Link
                                                            Text</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="link_text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button class="btn tp-add-lesson-btn btn-primary"
                                                    id="add_custom_link_in_field">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-plus-square">
                                                            <rect x="3" y="3" width="18" height="18"
                                                                rx="2" ry="2"></rect>
                                                            <line x1="12" y1="8" x2="12"
                                                                y2="16">
                                                            </line>
                                                            <line x1="8" y1="12" x2="16"
                                                                y2="12">
                                                            </line>
                                                        </svg>
                                                    </span>
                                                    add to menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card tp-appe-menu-list">
                            <div class="card-body">

                                <div class="cf nestable-lists">
                                    <div class="dd" id="nestable2">
                                        @if (isset($menu_items))
                                            <ol class="dd-list">
                                                @foreach ($menu_items as $menuitem)
                                                    <li class="dd-item tp-course-box d-flex justify-content-between align-items-center"
                                                        data-type="{{ $menuitem['type'] }}"
                                                        data-id="{{ $menuitem['id'] }}"
                                                        data-name="{{ $menuitem['name'] }}"
                                                        data-target="{{ $menuitem['target'] }}">
                                                        <div id="accordion" class="dd-handle" data-menu-id="1">
                                                            <div class="card card-primary">
                                                                <div class="card-header">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <div class="menuTitlw">
                                                                            <h4 class="card-title w-100"><a
                                                                                    class="d-block w-100 collapsed"
                                                                                    data-toggle="collapse"
                                                                                    href="#collapseOne-1"
                                                                                    aria-expanded="false">{{ $menuitem['name'] }}</a>
                                                                            </h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="menuAction">
                                                            <button class="tp-delet-btn delete-menu-btn" data-menu-id="1"
                                                                data-toggle="modal" data-target="#deleteMenuModal"
                                                                data-id="{{ $menuitem['id'] }}"
                                                                data-name="{{ $menuitem['name'] }}"
                                                                data-type="{{ $menuitem['type'] }}"
                                                                data-target="{{ $menuitem['target'] }}">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-trash-2">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                        </path>
                                                                        <line x1="10" y1="11"
                                                                            x2="10" y2="17"></line>
                                                                        <line x1="14" y1="11"
                                                                            x2="14" y2="17"></line>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </li>

                                                    @if (isset($menuitem['children']))
                                                        @foreach ($menuitem['children'] as $menuitem2)
                                                            <ol class="dd-list">
                                                                <li class="dd-item tp-course-box d-flex justify-content-between align-items-center"
                                                                    data-type="{{ $menuitem2['type'] }}"
                                                                    data-id="{{ $menuitem2['id'] }}"
                                                                    data-name="{{ $menuitem2['name'] }}"
                                                                    data-target="{{ $menuitem2['target'] }}">
                                                                    <div id="accordion" class="dd-handle"
                                                                        data-menu-id="2">
                                                                        <div class="card card-primary">
                                                                            <div class="card-header">
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-between">
                                                                                    <div class="menuTitlw">
                                                                                        <h4 class="card-title w-100"><a
                                                                                                class="d-block w-100 collapsed"
                                                                                                data-toggle="collapse"
                                                                                                href="#collapseOne-1"
                                                                                                aria-expanded="false">{{ $menuitem['name'] }}</a>
                                                                                        </h4>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="menuAction">
                                                                        <button class="tp-delet-btn delete-menu-btn"
                                                                            data-menu-id="1" data-toggle="modal"
                                                                            data-target="#deleteMenuModal"
                                                                            data-id="{{ $menuitem['id'] }}"
                                                                            data-name="{{ $menuitem['name'] }}"
                                                                            data-type="{{ $menuitem['type'] }}"
                                                                            data-target="{{ $menuitem['target'] }}">
                                                                            <span>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="feather feather-trash-2">
                                                                                    <polyline points="3 6 5 6 21 6">
                                                                                    </polyline>
                                                                                    <path
                                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                    </path>
                                                                                    <line x1="10" y1="11"
                                                                                        x2="10" y2="17">
                                                                                    </line>
                                                                                    <line x1="14" y1="11"
                                                                                        x2="14" y2="17">
                                                                                    </line>
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                </li>
                                                            </ol>
                                                        @endforeach
                                                    @else
                                                    @endif
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                </div>
                                <textarea class="d-none" id="nestable2-output"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {});
    </script>
@endpush
