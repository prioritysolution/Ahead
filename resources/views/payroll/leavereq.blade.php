@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endpush
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
                    <h2 class="mb-1">Leave Requisition</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Leave Requisition</li>
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
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Leave
                                    Requisition
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="emp_name" class="form-label">Employee Name</label>
                                    <div class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                                        <select name="emp_name" id="emp_name" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Employee Name</option>
                                            @foreach ($emp_list as $list)
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
                                    <input type="hidden" id="req_id" name="req_id">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Appl No.</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="appl_no" name="appl_no"
                                                placeholder="Appl No.">
                                            <span class="input-group-text" id="btnSearch" style="cursor:pointer;" onclick="src_leave();">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Leave Type</label>
                                        <select name="lev_type" id="lev_type" class="select2 form-control" onchange="get_leave_balance(this.value);">
                                            <option value="" Selected Disabled>Select Leave Type</option>
                                            @foreach ($leave_type as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Leave From</label>
                                        <input type="text" class="form-control bs-datepicker-format" id="lev_frm"
                                            name="lev_frm" placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Leave To</label>
                                        <input type="text" class="form-control bs-datepicker-format" id="lev_to"
                                            name="lev_to" placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Half-day Flag (Yes/No)</label>
                                        <div class="col-lg-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hlf_day_flg" id="hlf_day_yes"
                                                    value="1">
                                                <label class="form-check-label" for="hlf_day_yes">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hlf_day_flg" id="hlf_day_no"
                                                    value="0" checked>
                                                <label class="form-check-label" for="hlf_day_no">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Half-day Type (First Half / Second Half)</label>
                                        <select name="hlf_day_type" id="hlf_day_type" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Half-day Type</option>
                                            @foreach ($half_type as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Leave Reason</label>
                                        <input type="text" id="lev_reason" name="lev_reason" class="form-control"
                                            placeholder="Leave Reason">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Attachment (If Document Required)</label>
                                        <input type="file" id="doc_file" name="doc_file" class="form-control" accept="image/*,.pdf">
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-center align-items-center gap-3 mb-3">
                                        <button id="save_btn" type="button" class="btn btn-success px-4"
                                            onclick="post_lev_req();">
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
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/dayjs.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script src="{{ asset('assets/js/payroll/lev_req.js') }}"></script>
@endpush
