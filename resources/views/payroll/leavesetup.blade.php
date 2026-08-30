@extends('layouts.layouts')

@section('contain')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">
            @if ($error)
                <div class="alert alert-danger">
                    <strong>Error:</strong> {{ $error }}
                </div>
            @endif
            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Leave Type Master</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Leave Setup</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                    {{-- <div class="me-2 mb-2">
                        <div class="dropdown">
                           <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-file-export me-1"></i>Export
                            </a>
                             <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                            class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                            class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                    {{-- <div class="mb-2">
                        <div class="input-icon w-120 position-relative">
                            <span class="input-icon-addon">
                                <i class="ti ti-calendar text-gray-9"></i>
                            </span>
                            <input type="text" class="form-control yearpicker" value="2025">
                        </div>
                    </div> --}}
                    <div class="ms-2 head-icons">
                        <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Collapse" id="collapse-header">
                            <i class="ti ti-chevrons-up"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <!-- /Welcome Wrap -->

            <div class="row justify-content-center align-items-center">

                <div class="col-xl-8 d-flex">
                    <div class="card flex-fill border-primary attendance-bg">
                        <div class="card-header justify-content-between">
                            <div class="card-title text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Leave Type
                                    Master
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label for="selectType" class="form-label">Search</label>
                                    <div class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                                        <select name="selectType" id="selectType" class="select2 form-control"
                                            onchange="selectType(this.id);">
                                            <option value="" Selected Disabled>Select Leave Type</option>
                                            @foreach ($leave_type as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body d-flex">
                            <div class="border border-primary rounded p-3">
                                <div class="row">
                                    <input type="hidden" id="leave_id" name="leave_id">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Leave Name</label>
                                        <input type="text" class="form-control" id="leave_name" name="leave_name"
                                            placeholder="Leave Name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Short Name</label>
                                        <input type="text" class="form-control" maxlength="10" id="short_name"
                                            name="short_name" placeholder="Short Name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Document Required (Yes/No)</label>
                                        <div class="col-lg-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="doc_rec" id="doc_yes"
                                                    value="1" >
                                                <label class="form-check-label" for="doc_yes">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="doc_rec" id="doc_no"
                                                    value="0" checked>
                                                <label class="form-check-label" for="doc_no">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Leave No. Per Year</label>
                                        <input type="text" maxlength="2" class="form-control only-numbers"
                                            id="leave_no_year" name="leave_no_year" placeholder="Leave No. Per Year">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Validity</label>
                                        <select name="validaty" id="validaty" class="select2 form-control" onchange="check_type(this.value);">
                                            <option value="" Selected Disabled>Select Validity</option>
                                            @foreach ($val_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Days Number</label>
                                        <input type="text" maxlength="2" id="day_no" name="day_no" readonly
                                            class="form-control only-numbers" placeholder="Days Number">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="active"
                                                name="active" checked>
                                            <label class="form-check-label form-label" for="gridCheck">
                                                Is Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center align-items-center gap-3 mb-3">
                                        <button id="save_btn" type="button" class="btn btn-success px-4" onclick="post_leave();">
                                            <i class="fa fa-save"></i> Save
                                        </button>

                                        <button type="button" class="btn btn-danger px-4" onclick="location.reload();">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /Page Wrapper -->
@endsection
@push('script')
    <script src="{{ asset('assets/js/payroll/lev_stp.js') }}"></script>
@endpush
