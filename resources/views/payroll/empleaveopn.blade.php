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
                    <h2 class="mb-1">Leave Balance</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Leave Balance</li>
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

                <div class="col-xl-6 d-flex">
                    <div class="card flex-fill border-primary attendance-bg">
                        <div class="card-header justify-content-between">
                            <div class="card-title text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Leave Balance
                                </h4>
                            </div>
                        </div>

                        <div class="card-body d-flex">

                            <div class="row">
                                <input type="hidden" id="leave_id" name="leave_id">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Employee Name</label>
                                    <select name="emp_id" id="emp_id" class="select2 form-control">
                                        <option value="" Selected Disabled>Select Employee Name</option>
                                        @foreach ($emp_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Financial Year</label>
                                    <select name="fin_year" id="fin_year" class="select2 form-control">
                                        <option value="" Selected Disabled>Select Financial Year</option>
                                        @foreach ($finyear_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Month</label>
                                    <select name="mnt_id" id="mnt_id" class="select2 form-control">
                                        <option value="" Selected Disabled>Select Month</option>
                                        @foreach ($mn_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Year</label>
                                    <div class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                                        <select name="year_id" id="year_id" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Year</option>
                                            @foreach ($year_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Id }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary w-100" id="srcBtn"
                                            onclick="get_lev_opn();">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0" id="wcl_tal">
                                            <thead>
                                                <tr>
                                                    <th>Leave Type</th>
                                                    <th>Opening Leaved</th>
                                                </tr>
                                            </thead>
                                            <tbody id="wcl_tbl_data">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-center align-items-center gap-3 mb-3">
                                    <button id="save_btn" type="button" class="btn btn-success px-4"
                                        onclick="post_leave_opn();">
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
    <!-- /Page Wrapper -->
@endsection
@push('script')
    <script src="{{ asset('assets/js/payroll/emp_lev_opn.js') }}"></script>
@endpush
