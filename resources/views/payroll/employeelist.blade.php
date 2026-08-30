@extends('layouts.layouts')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    {{-- <style>
div.dataTables_wrapper div.dataTables_filter input {
    margin-left: .5em;
    display: inline-block;
    width: 500px !important;
}
.form-control-sm {
    font-size: 0.8rem;
    padding: 0.25rem 0.8rem;
    height: 35px !important;
}
    </style> --}}
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
                    <h2 class="mb-1">Employee</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Employee
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Employee List</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                    <div class="me-2 mb-2">
                        {{-- <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
								<a href="https://smarthr.co.in/demo/html/template/employees.html" class="btn btn-icon btn-sm active bg-primary text-white me-1"><i class="ti ti-list-tree"></i></a>
								<a href="https://smarthr.co.in/demo/html/template/employees-grid.html" class="btn btn-icon btn-sm"><i class="ti ti-layout-grid"></i></a>
							</div> --}}
                    </div>
                    <div class="me-2 mb-2">
                        {{-- <div class="dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
									<i class="ti ti-file-export me-1"></i>Export
								</a>
								<ul class="dropdown-menu  dropdown-menu-end p-3">
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
									</li>
								</ul>
							</div> --}}
                    </div>
                    {{-- <div class="mb-2">
							<a href="#" data-bs-toggle="modal" data-bs-target="#add_employee" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Employee</a>
						</div> --}}
                    <div class="head-icons ms-2">
                        <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Collapse" id="collapse-header">
                            <i class="ti ti-chevrons-up"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <div class="row">

                <!-- Total Plans -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-dark rounded-circle"><i class="ti ti-users"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Total Employee</p>
                                    <h4>24</h4>
                                </div>
                            </div>
                            {{-- <div>                                    
									<span class="badge badge-soft-purple badge-sm fw-normal">
										<i class="ti ti-arrow-wave-right-down"></i>
										+19.01%
									</span>
                                </div> --}}
                        </div>
                    </div>
                </div>
                <!-- /Total Plans -->

                <!-- Total Plans -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-success rounded-circle"><i
                                            class="ti ti-user-share"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
                                    <h4>24</h4>
                                </div>
                            </div>
                            {{-- <div>                                    
									<span class="badge badge-soft-primary badge-sm fw-normal">
										<i class="ti ti-arrow-wave-right-down"></i>
										+19.01%
									</span>
                                </div> --}}
                        </div>
                    </div>
                </div>
                <!-- /Total Plans -->

                <!-- Inactive Plans -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-danger rounded-circle"><i
                                            class="ti ti-user-pause"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">InActive</p>
                                    <h4>0</h4>
                                </div>
                            </div>
                            {{-- <div>                                    
									<span class="badge badge-soft-dark badge-sm fw-normal">
										<i class="ti ti-arrow-wave-right-down"></i>
										+19.01%
									</span>
                                </div> --}}
                        </div>
                    </div>
                </div>
                <!-- /Inactive Companies -->

                <!-- No of Plans  -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-info rounded-circle"><i
                                            class="ti ti-user-plus"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">New Joiners</p>
                                    <h4>0</h4>
                                </div>
                            </div>
                            {{-- <div>                                    
									<span class="badge badge-soft-secondary badge-sm fw-normal">
										<i class="ti ti-arrow-wave-right-down"></i>
										+19.01%
									</span>
                                </div> --}}
                        </div>
                    </div>
                </div>
                <!-- /No of Plans -->

            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>Staff Details</h5>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        {{-- <div class="me-3">
								<div class="input-icon-end position-relative">
									<input type="text" class="form-control date-range bookingrange" placeholder="dd/mm/yyyy - dd/mm/yyyy">
									<span class="input-icon-addon">
										<i class="ti ti-chevron-down"></i>
									</span>
								</div>
							</div> --}}
                        {{-- <div class="dropdown me-3">
								<a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
									Designation
								</a>
								<ul class="dropdown-menu  dropdown-menu-end p-3">
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1">Finance</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1">Developer</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1">Executive</a>
									</li>
								</ul>
							</div> --}}
                        <div class="dropdown me-3">
                            <button type="button" class="btn btn-primary d-inline-flex align-items-center"
                                onclick="open_page(0)">Add New</button>
                        </div>
                        {{-- <div class="dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
									Sort By : Last 7 Days
								</a>
								<ul class="dropdown-menu  dropdown-menu-end p-3">
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a>
									</li>
								</ul>
							</div> --}}
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="custom-datatable-filter table-responsive">
                        <table class="table datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="no-sort">
                                        SL
                                    </th>
                                    <th>Emp Code</th>
                                    <th>Staff Name</th>
                                    <th>Email</th>
                                    <th>Contact No.</th>
                                    <th>Gender</th>
                                    <th>Educational Qualification</th>
                                    <th>Residence</th>
                                    <th>Present Working</th>
                                    <th>Domain</th>
                                    <th>Department</th>
                                    <th>Date Of Joining</th>
                                    <th>Emp. Type</th>
                                    <th>EPF No.</th>
                                    <th>ESIC No.</th>
                                    <th>UAN No.</th>
                                    <th>Bank Name</th>
                                    <th>Acct. No.</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($emp_list as $emp)
                                    <tr>
                                        <td>
                                            {{ $i++ }}
                                        </td>
                                        <td>{{ $emp->ECode }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('assets/img/profiles/no-img.jpg') }}"
                                                    class="img-fluid rounded-circle avatar avatar-md" alt="img">
                                                <div class="ms-2">
                                                    <p class="text-dark mb-0">
                                                        {{ $emp->FstNm . ' ' . $emp->MdlNm . ' ' . $emp->LstNm }}
                                                    </p>
                                                    <span class="fs-12">{{ $emp->DesigNm }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $emp->Email }} </td>
                                        <td>{{ $emp->MobNo }}</td>
                                        <td>{{ $emp->Gndr }}</td>
                                        <td>{{ $emp->EQual }}</td>
                                        <td>{{ $emp->ERes }}</td>
                                        <td>{{ $emp->EBrNms }}</td>
                                        <td>{{ $emp->DomainNm }}</td>
                                        <td>{{ $emp->DeptNm }}</td>
                                        <td>{{ \Carbon\Carbon::parse($emp->EJDt)->format('d-M-Y') }}</td>
                                        <td> {{ $emp->EType }} </td>
                                        <td> {{ $emp->Epf }} </td>
                                        <td> {{ $emp->Esic }} </td>
                                        <td> {{ $emp->Uan }} </td>
                                        <td> {{ $emp->EBank }} </td>
                                        <td> {{ $emp->EAcNo }} </td>
                                        <td>
                                            <div class="action-icon d-inline-flex">
                                                <a href="javascript:void(0);" class="me-2" title="Edit Employee"
                                                    onclick="open_page({{ $emp->EId }});"><i
                                                        class="ti ti-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
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
    <script>
        function setCookie(name, value, minutes) {
            const expires = new Date(Date.now() + minutes * 60 * 1000).toUTCString();
            document.cookie =
                name + "=" + encodeURIComponent(value) +
                "; expires=" + expires +
                "; path=/" +
                "; SameSite=Strict" +
                "; Secure"; // works only on HTTPS
        }

        function open_page(p) {
            if (p == 0) {
                window.location.replace(baseUrl + '/Payroll/EmployeeProfile/Appointment');
            } else {
                setCookie('edt_emp_id',p,1);
                window.location.replace(baseUrl + '/Payroll/EmployeeProfile/Appointment');
            }
        }
    </script>
@endpush
