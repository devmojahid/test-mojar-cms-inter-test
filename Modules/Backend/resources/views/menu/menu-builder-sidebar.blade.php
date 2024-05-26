<div class="card tp-appe-menu">
    <div class="card-header">
        <h3 class="card-title">{{ __('dashboard.all_menu') }}</h3>
    </div>
    <div class="card-body p-2">
        <div id="accordion">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne"
                            aria-expanded="false">
                            Pages
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="collapse" data-parent="#accordion">
                    <div class="card-body" style="height:300px; overflow-y: scroll background-color: #e9e0e0d7;">
                        <div class="pages-list">
                            <div class="form-group">
                                @if (isset($pages))
                                    @foreach ($pages as $page)
                                        <div class="custom-control custom-checkbox my-1">
                                            <input class="custom-control-input page_checkbox_value" type="checkbox"
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <line x1="12" y1="8" x2="12" y2="16">
                                    </line>
                                    <line x1="8" y1="12" x2="16" y2="12">
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
                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo"
                            aria-expanded="false">
                            Courses
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body" style="height:300px; overflow-y: scroll background-color: #e9e0e0d7;">
                        <div class="pages-list">
                            <div class="form-group">
                                @if (isset($courses))
                                    @foreach ($courses as $course)
                                        <div class="custom-control custom-checkbox my-1">
                                            <input class="custom-control-input course_checkbox_value" type="checkbox"
                                                id="customCheckbox-{{ $course->id }}" value="{{ $course->id }}">
                                            <label for="customCheckbox-{{ $course->id }}"
                                                class="custom-control-label">{{ $course->title }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="custom-control custom-checkbox my-1">
                                        <label for="customCheckbox1" class="custom-control-label">No
                                            Course Found</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn tp-add-lesson-btn btn-primary" id="add_courses_in_field">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-plus-square">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <line x1="12" y1="8" x2="12" y2="16">
                                    </line>
                                    <line x1="8" y1="12" x2="16" y2="12">
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
                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseThree"
                            aria-expanded="false">
                            Custom Link
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body" style="height:300px; overflow-y: scroll background-color: #e9e0e0d7;">
                        <div class="pages-list">
                            <div class="form-group row">
                                <label for="custom_url" class="col-sm-2 col-form-label">Url:</label>
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
                        <button class="btn tp-add-lesson-btn btn-primary" id="add_custom_link_in_field">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-plus-square">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <line x1="12" y1="8" x2="12" y2="16">
                                    </line>
                                    <line x1="8" y1="12" x2="16" y2="12">
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
