@extends('layouts.layouts')
@section('contain')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Employee Dashboard</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Employee Dashboard</li>
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
            <!-- Welcome Wrap -->
            <div class="card border-0">
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
                    <div class="d-flex align-items-center mb-3">
                        <span class="avatar avatar-xl flex-shrink-0">
                            <img src="{{ asset('assets/img/profiles/no-img.jpg') }}" class="rounded-circle" alt="img">
                        </span>
                        <div class="ms-3">
                            <h3 class="mb-2">Welcome Back, {{ session('User_Name') }} <a href="javascript:void(0);"
                                    class="edit-icon"><i class="ti ti-edit fs-14"></i></a></h3>
                            {{-- <p>You have <span class="text-primary text-decoration-underline">21</span> Pending Approvals & <span class="text-primary text-decoration-underline">14</span> Leave Requests</p> --}}
                        </div>
                    </div>
                    {{-- <div class="d-flex align-items-center flex-wrap mb-1">
							<a href="#" class="btn btn-secondary btn-md me-2 mb-2" data-bs-toggle="modal" data-bs-target="#add_project"><i class="ti ti-square-rounded-plus me-1"></i>Add Project</a>
						</div> --}}
                </div>
            </div>
            <!-- /Welcome Wrap -->

            {{-- <div class="alert bg-secondary-transparent alert-dismissible fade show mb-4">
					Your Leave Request on “10th September 2025” has been Approved!!!
					<button type="button" class="btn-close fs-14" data-bs-dismiss="alert" aria-label="Close"><i class="ti ti-x"></i></button>
				</div> --}}

            <div class="row">
                <div class="col-xl-4 d-flex">
                    <div class="card flex-fill border-primary attendance-bg">
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Attendance</h4>
                                <h6 style="margin-top:15px;" id="punch_date"></h6>
                                <h6 id="punch_time"></h6>

                            </div>

                            <div class="attendance-circle-progress attendance-progress mx-auto mb-3" data-value='65'
                                style="display: none;" id="DivAttend">
                                <span class="progress-left">
                                    <span class="progress-bar border-success"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar border-success"></span>
                                </span>
                                <div class="total-work-hours text-center w-100">
                                    <span class="fs-13 d-block mb-1">Total Hours</span>
                                    <h6 id="CalTime"></h6>
                                </div>
                            </div>
                            <div class="text-center" style="display: none;" id="DivPunchOut">
                                <!-- <div class="badge badge-dark badge-md mb-3">Production :  3.45 hrs</div>-->
                                <br>
                                <h6 class="fw-medium d-flex align-items-center justify-content-center mb-4">
                                    <i class="ti ti-fingerprint text-primary me-1"></i>
                                    <span id="PrintPunchIn"></span>
                                </h6>
                                <textarea class="form-control" name="Remarks" id="Remarks" placeholder="Remarks" cols="30" rows="5"></textarea>
                                <a onclick="punch_out();" class="btn btn-primary w-100" style="margin-top: 10px;">Punch
                                    Out</a>
                            </div>

                            <div class="text-center" style="display: none;" id="DivPnchIn">
                                <!-- <div class="badge badge-dark badge-md mb-3">Production :  3.45 hrs</div>-->
                                <br>
                                <h6 class="fw-medium d-flex align-items-center justify-content-center mb-4">
                                    <i class="ti ti-fingerprint text-primary me-1"></i>
                                </h6>
                                <textarea class="form-control" name="Remarks" id="Remarks" placeholder="Remarks" cols="30" rows="5"></textarea>
                                <a onclick="punch_in();" class="btn btn-primary w-100" style="margin-top: 10px;">Punch
                                    In</a>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-8 d-flex">
                    <div class="card flex-fill border-primary attendance-bg">
                        <div class="card-body">

                            <!-- Header -->
                            <div class="mb-3 text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight:900;">Current Month Attendance Summary</h4>
                                <h6 class="mt-2" id="punch_date"></h6>
                                <h6 id="punch_time"></h6>
                            </div>
                            

                            <!-- Table -->
                            <div class="table-responsive border rounded" style="max-height:380px; overflow:auto;">
                                <table class="table table-bordered table-hover mb-0 text-center align-middle">

                                    <thead class="table-primary sticky-top">
                                        <tr>
                                            <th style="min-width:120px;">Sl</th>
                                            <th style="min-width:120px;">Date</th>
                                            <th style="min-width:120px;">In Time</th>
                                            <th style="min-width:140px;">Out Time</th>
                                            <th style="min-width:140px;">Remarks</th>
                                            <th style="min-width:120px;">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @if ($report->isNotEmpty())
                                            @foreach ($report as $data)
                                                <tr>
                                                    <td>{{ $data->Sl }}</td>
                                                    <td>{{ $data->MDate }}</td>
                                                    <td>{{ $data->InTime }}</td>
                                                    <td>{{ $data->OutTime }}</td>
                                                    <td>{{ $data->Remrks }}</td>
                                                    @if ($data->Status == 'Absent')
                                                        <td>
                                                            <span class="badge bg-danger">{{$data->Status}}</span>
                                                        </td>
                                                    @elseif ($data->Status == 'Holiday')
                                                        <td>
                                                            <span class="badge bg-warning">{{$data->Status}}</span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span class="badge bg-success">{{$data->Status}}</span>
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                        @else
                                            <p class="text-center text-muted">No report found</p>
                                        @endif



                                    </tbody>

                                </table>
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
    <script>
        $('.select2').select2();
        var pIsAttend = "{{ session('IsAttend') ?? 0 }}"
        var pAttendDate = "{{ session('AttendDate') ?? 0 }}"
        var pAttendTime = "{{ session('AttendTime') ?? 0 }}"
        var parts = pAttendDate.split('-');
        var isoDate = parts[2] + "-" + parts[1] + "-" + parts[0];
        pAttendDate = isoDate;
    </script>
    <script src="{{ asset('assets/js/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/common/attand.js') }}"></script>
@endpush
