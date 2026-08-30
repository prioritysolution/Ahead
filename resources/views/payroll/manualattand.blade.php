@extends('layouts.layouts')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}">
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
                    <h2 class="mb-1">Post Attandance</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Post Attandance</li>
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
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Attendance</h4>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="mb-3">
                                        <label for="selectemployee" class="form-label">Select Employee</label>
                                        <select name="selectemployee" id="selectemployee" class="select2 form-control"
                                            onchange="check_attend(this.value);">
                                            <option value="" Selected Disabled>Select Employee</option>
                                            @foreach ($emp_List as $list)
                                                <option value="{{ $list->Id }}">{{ $list->StaffNm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectstatus" class="form-label">Select Status</label>
                                        <select name="selectstatus" id="selectstatus" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Status</option>
                                            @foreach ($ststus as $stslist)
                                                <option value="{{ $stslist->Id }}">{{ $stslist->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="AttendDate" class="form-label">Select Date</label>
                                        <input type="text" id="AttendDate" placeholder="DD/MM/YYYY" autocomplete="off"
                                            class="form-control bs-datepicker-format" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="PuunchInTime" class="form-label">Punch In Time</label>
                                        <input type="text" id="PuunchInTime" class="form-control timepicker2" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="PunchOutTime" class="form-label">Punch Out Time</label>
                                        <input type="text" id="PunchOutTime" class="form-control timepicker2" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="Remarks" class="form-label">Remarks</label>
                                        <textarea name="Remarks" id="Remarks" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <a onclick="punch_in();" class="btn btn-primary w-100" id="punchBtn">Punch In</a>
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
    <script src="{{ asset('assets/js/payroll/proc_attend.js') }}"></script>
@endpush
