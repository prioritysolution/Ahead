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
                    <h2 class="mb-1">Employee Appointment</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Employee Appointment</li>
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
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Employee
                                    Appointment
                                </h4>
                            </div>
                        </div>

                        <div class="card-body d-flex">
                            <div class="border border-primary rounded p-3">
                                <div class="row">
                                    <input type="hidden" id="emp_id" name="emp_id">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Employee Code</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="emp_code" name="emp_code"
                                                placeholder="Employee Code">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">First Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="emp_fname" name="emp_fname"
                                                placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="emp_mname" name="emp_mname"
                                                placeholder="Middle Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="emp_lname" name="emp_lname"
                                                placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Date Of Birth</label>
                                        <input type="text" class="form-control bs-datepicker-format" id="emp_dob"
                                            onchange="cal_age(this.value);" onkeyup="cal_age(this.value);" name="emp_dob"
                                            placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Age</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" readonly id="emp_age"
                                                name="emp_age" placeholder="Age">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Select Gender</label>
                                        <select name="emp_gend" id="emp_gend" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Gender</option>
                                            @foreach ($gend_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Residence</label>
                                        <input type="text" id="emp_res" name="emp_res" class="form-control"
                                            placeholder="Residence">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Qualification</label>
                                        <input type="text" id="emp_qlf" name="emp_qlf" class="form-control"
                                            placeholder="Qualification">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Date Of Joining</label>
                                        <input type="text" class="form-control bs-datepicker-format" id="emp_doj"
                                            name="emp_doj" placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Date Of Retirement</label>
                                        <input type="text" class="form-control bs-datepicker-format" id="emp_dor"
                                            name="emp_dor" placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Working Branch</label>
                                        <input type="text" id="emp_wbr" name="emp_wbr" class="form-control"
                                            placeholder="Working Branch">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Select Domain</label>
                                        <select name="emp_domn" id="emp_domn" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Domain</option>
                                            @foreach ($domain_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Select Depertment</label>
                                        <select name="emp_dept" id="emp_dept" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Depertment</option>
                                            @foreach ($dep_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Select Designation</label>
                                        <select name="emp_degd" id="emp_degd" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Designation</option>
                                            @foreach ($deg_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Mobile No</label>
                                        <input type="text" id="emp_mob" name="emp_mob" class="form-control"
                                            placeholder="Mobile No">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Whatsapp No</label>
                                        <input type="text" id="emp_whtno" name="emp_whtno" class="form-control"
                                            placeholder="Whatsapp No">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" id="emp_mail" name="emp_mail" class="form-control"
                                            placeholder="E-mail">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Select Status</label>
                                        <select name="emp_sts" id="emp_sts" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Status</option>
                                            @foreach ($sts_list as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Select Type</label>
                                        <select name="emp_type" id="emp_type" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Type</option>
                                            @foreach ($emp_type as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Branch</label>
                                        <input type="text" id="emp_br" name="emp_br" class="form-control"
                                            placeholder="Branch">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">EPF No.</label>
                                        <input type="text" id="emp_epf" name="emp_epf" class="form-control"
                                            placeholder="EPF No.">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">ESIC No.</label>
                                        <input type="text" id="emp_esic" name="emp_esic" class="form-control"
                                            placeholder="ESIC No.">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">UAN No.</label>
                                        <input type="text" id="emp_uan" name="emp_uan" class="form-control"
                                            placeholder="UAN No.">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" id="emp_bank" name="emp_bank" class="form-control"
                                            placeholder="Bank Name">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Account No</label>
                                        <input type="text" id="emp_bacct" name="emp_bacct" class="form-control"
                                            placeholder="Account No">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Employee Status</label>
                                        <select name="act_sts" id="act_sts" class="select2 form-control">
                                            <option value="" Selected Disabled>Select Employee Status</option>
                                            @foreach ($emp_sts as $list)
                                                <option value="{{ $list->Id }}">{{ $list->Value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center align-items-center gap-3 mb-3">
                                        <button id="save_btn" type="button" class="btn btn-success px-4"
                                            onclick="post_emp();">
                                            <i class="fa fa-save"></i> Save
                                        </button>

                                        <button type="button" class="btn btn-danger px-4"
                                            onclick="window.location.replace('/employeelist');">
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
    <script src="{{ asset('assets/js/payroll/emp_prof.js') }}"></script>
@endpush
