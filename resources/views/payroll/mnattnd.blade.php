@extends('layouts.layouts')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}">
    <style>
        /* 1. SCROLLABLE CONTAINER AND STICKY HEADER FIXES */
        .attendance-table-wrap {
            height: auto;
            max-height: calc(100vh - 290px);
            overflow-y: auto;   /* Smooth vertical scrolling */
            overflow-x: hidden;  /* Completely disables outer horizontal scrolling */
            position: relative;
        }

        @media (max-height: 800px) {
            .attendance-table-wrap {
                max-height: calc(100vh - 350px);
            }
        }

        /* Locks headers tightly to the top when scrolling down */
        .attendance-sticky-table thead tr th {
            position: sticky !important;
            top: 0 !important;
            z-index: 100 !important;
            background-color: #eef2f7 !important;
            box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0.15);
        }

        /* 2. NO-SCROLL LAYOUT & PROPORTIONAL COLUMN SYSTEM */
        .main-table-container {
            flex: 1 1 calc(100% - 220px);
            min-width: 0;
            overflow: hidden; /* Stops horizontal scroll container blowout */
        }

        .side-table-container {
            flex: 0 0 200px;
            width: 200px;
        }

        /* Forces the table to stay strictly within its boundary width without stretching */
        .attendance-sticky-table {
            table-layout: fixed !important;
            width: 100% !important;
        }

        /* Exact column width distributions to maximize view space */
        .col-sl    { width: 5%; }
        .col-date  { width: 15%; }
        .col-status{ width: 32%; } /* Keeps generous room for both dropdown fields */
        .col-time  { width: 14%; } /* Optimized for time string sizes */
        .col-hours { width: 14%; } 
        .col-rem   { width: 10%; }

        /* 3. INPUT COMPACTNESS FOR FITTING THE CELLS */
        #days_tbl td {
            white-space: nowrap;
            vertical-align: middle;
            padding: 6px 4px !important; /* Tightens padding to maximize space */
        }

        /* Streamlined sizing for status dropdown selections */
        #days_tbl select,
        #days_tbl .form-control {
            width: 100% !important;
            max-width: 95px !important;
            display: inline-block;
            text-align: center;
            padding: 0.25rem 0.4rem !important;
            font-size: 13px !important;
        }

        /* Sleek input sizing for time boxes to fit without overflow triggers */
        #days_tbl input[type="text"] {
            width: 100% !important;
            max-width: 82px !important;
            text-align: center;
            padding: 0.25rem 0.25rem !important;
            font-size: 12.5px !important;
        }

        /* Tablet responsiveness fallback breakpoint */
        @media (max-width: 1199.98px) {
            .attendance-table-wrap {
                overflow-x: auto; /* Adds fallback horizontal scroll only on lower-resolution tablets */
            }
            .main-table-container {
                overflow-x: auto;
            }
        }

        @media (max-width: 991.98px) {
            .attendance-flex-container {
                flex-direction: column !important;
            }
            .main-table-container,
            .side-table-container {
                width: 100% !important;
                flex: 1 1 100% !important;
            }
            .side-table-container {
                margin-top: 20px;
            }
        }
    </style>
@endpush

@section('contain')
    <div class="page-wrapper">
        <div class="content">
            @if ($error)
                <div class="alert alert-danger">
                    <strong>Error:</strong> {{ $error }}
                </div>
            @endif
            
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Monthly Attendance</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Monthly Attendance</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                    <div class="ms-2 head-icons">
                        <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Collapse" id="collapse-header">
                            <i class="ti ti-chevrons-up"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-xl-12 d-flex">
                    <div class="card flex-fill border-primary attendance-bg">
                        <div class="card-header justify-content-between">
                            <div class="card-title text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Monthly Attendance</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-3 mb-3">
                                    <label class="form-label">Select Month</label>
                                    <select name="mn_id" id="mn_id" class="select2 form-control">
                                        <option value="" Selected Disabled>Select Month</option>
                                        @foreach ($mon_list as $list)
                                            <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-lg-3 mb-3">
                                    <label class="form-label">Select Year</label>
                                    <select name="yer_id" id="yer_id" class="select2 form-control">
                                        <option value="" Selected Disabled>Select Year</option>
                                        @foreach ($year_list as $list)
                                            <option value="{{ $list->Id }}">{{ $list->Id }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-lg-6 mb-3">
                                    <label class="form-label">Select Employee</label>
                                    <div class="d-flex align-items-stretch w-100">
                                        <div class="flex-grow-1">
                                            <select name="emp_id" id="emp_id" class="select2 form-control w-100">
                                                <option value="" selected disabled>Select Employee</option>
                                                @foreach ($emp_list as $list)
                                                    <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" id="srcBtn" class="btn btn-primary ms-1 flex-shrink-0"
                                            onclick="get_list();" title="Search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <div class="attendance-table-wrap">
                                        <div class="d-flex align-items-stretch gap-2 attendance-flex-container">
                                            
                                            <div class="main-table-container">
                                                <table class="table table-bordered table-hover mb-0 text-center align-middle attendance-sticky-table">
                                                    <thead>
                                                        <tr class="table-primary">
                                                            <th class="col-sl">Sl</th>
                                                            <th class="col-date">Date</th>
                                                            <th colspan="2" class="col-status">Status</th>
                                                            <th class="col-time">In Time</th>
                                                            <th class="col-time">Out Time</th>
                                                            <th class="col-hours">Total Hours</th>
                                                            <th class="col-rem">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="days_tbl"></tbody>
                                                </table>
                                            </div>

                                            <div class="side-table-container">
                                                <table class="table table-bordered table-hover mb-0 text-center align-middle attendance-sticky-table">
                                                    <thead>
                                                        <tr class="table-primary">
                                                            <th>Parameter</th>
                                                            <th>Days</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="prm_tbl"></tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-center align-items-center gap-3 mb-3">
                                    <button id="save_btn" type="button" class="btn btn-success px-4" onclick="post_mnt_attnd();">
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
    @endsection

@push('script')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/payroll/mnt_attend.js') }}"></script>
@endpush