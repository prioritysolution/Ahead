@extends('layouts.layouts')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}">
    <style>
        @page {
            size: A4;
            margin: 5mm;
        }

        @media print {

            body {
                margin: 0 !important;
                padding: 0 !important;
            }

            body * {
                visibility: hidden;
            }

            #slip_row,
            #slip_row * {
                visibility: visible;
            }

            #slip_row {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                page-break-inside: avoid;
            }

            .row {
                margin: 0 !important;
            }

            .col-md-8 {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
            }

            .mb-3 {
                margin-bottom: 0 !important;
            }

            .payslip {
                font-size: 12px !important;
            }

            .payslip td,
            .payslip th {
                padding: 3px !important;
            }

            table {
                page-break-inside: avoid;
            }
        }

        .attendance-table-wrap {
            height: auto;
            max-height: calc(100vh - 300px);
            overflow: auto;
        }

        @media (max-height: 800px) {
            .attendance-table-wrap {
                max-height: calc(100vh - 360px);
            }
        }

        .payslip {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .payslip td,
        .payslip th {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        .no-border {
            border: none !important;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .bottom-only {
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: 1px solid #000 !important;
        }

            </style>
@endpush
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
                    <h2 class="mb-1">Update Payslip</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Update Payslip</li>
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

                <div class="col-xl-12 d-flex">
                    <div class="card flex-fill border-primary attendance-bg">
                        <div class="card-header justify-content-between">
                            <div class="card-title text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Update
                                    Payslip
                                </h4>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select Month</label>
                                    <select name="mn_id" id="mn_id" class="select2 form-control">
                                        <option value="" Selected Disabled>Select Month</option>
                                        @foreach ($mon_list as $list)
                                            <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select Year</label>
                                    <select name="yer_id" id="yer_id" class="select2 form-control">
                                        <option value="" Selected Disabled>Select Year</option>
                                        @foreach ($year_list as $list)
                                            <option value="{{ $list->Id }}">{{ $list->Id }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select Employee</label>

                                    <div class="d-flex align-items-center w-100 gap-2">

                                        <div class="flex-grow-1">
                                            <select name="emp_id" id="emp_id" class="select2 form-control w-100">
                                                <option value="" selected disabled>Select Employee</option>
                                                @foreach ($emp_list as $list)
                                                    <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="button" id="srcBtn" class="btn btn-primary" onclick="gen_slip();"
                                            title="Search">
                                            <i class="fa fa-search"></i>
                                        </button>

                                        <button type="button" id="update_btn" class="btn btn-success" onclick="updatePayslip();"
                                            title="Update Payslip">
                                            <i class="fa fa-save"></i>
                                        </button>

                                        {{-- <button type="button" style="display: none;" id="print_btn" class="btn btn-success" onclick="printSlip();"
                                            title="Print Payslip">
                                            <i class="fa fa-print"></i>
                                        </button> --}}

                                    </div>

                                </div>
                                <div class="row justify-content-center" id="slip_row">

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
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/payroll/pay_slip_upd.js') }}"></script>
@endpush
