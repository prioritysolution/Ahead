@extends('layouts.layouts')
@section('contain')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Director Dashboard</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Director Dashboard</li>
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
            <div class="row justify-content-center align-items-center">
                {{-- <div class="col-xl-4 d-flex">
						<div class="card position-relative flex-fill">
							<div class="card-header bg-dark">
								<div class="d-flex align-items-center">
									<span class="avatar avatar-lg avatar-rounded border border-white border-2 flex-shrink-0 me-2">
										<img src="{{asset('assets/img/users/user-01.jpg')}}" alt="Img">
									</span>
									<div>
										<h5 class="text-white mb-1">Rajkumar Maity</h5>
										<div class="d-flex align-items-center">
										<p class="text-white fs-12 mb-0">Director, Accounts & Admin</p>
										<span class="mx-1"><i class="ti ti-point-filled text-primary"></i></span>
										<!-- <p class="fs-12">UI/UX Design</p> -->
									</div>
									</div>
								</div>
								<a href="#" class="btn btn-icon btn-sm text-white rounded-circle edit-top"><i class="ti ti-edit"></i></a>
							</div>
							<div class="card-body">
								<div class="mb-3">
									<span class="d-block mb-1 fs-13">Phone Number</span>
									<p class="text-gray-9">+91 98747 95679</p>
								</div>
								<div class="mb-3">
									<span class="d-block mb-1 fs-13">Email Address</span>
									<p class="text-gray-9"><a href="#" >rajkumarmaity@aheadinitiatives.in</a></p>
								</div>
								<div class="mb-3">
									<span class="d-block mb-1 fs-13">Report Office</span>
									<p class="text-gray-9">Dibyendu Sarkar</p>
								</div>
								<div>
									<span class="d-block mb-1 fs-13">Joined on</span>
									<p class="text-gray-9">15  Jan 2011</p>
								</div>
							</div>
						</div>
					</div> --}}

                {{-- <div class="col-xl-4 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
									<h5>Leave Details</h5>
									<div class="dropdown">
										<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
											<i class="ti ti-calendar me-1"></i>2025
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">2025</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">2024</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">2023</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-sm-6">
										<div class="mb-4">
											<span class="d-block mb-1">Total Leaves</span>
											<h4>24</h4>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-4">
											<span class="d-block mb-1">Taken</span>
											<h4>5</h4>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-4">
											<span class="d-block mb-1">Absent</span>
											<h4>2</h4>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-4">
											<span class="d-block mb-1">Request</span>
											<h4>1</h4>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-4">
											<span class="d-block mb-1">CL Balance</span>
											<h4>6</h4>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="mb-4">
											<span class="d-block mb-1">EL Balance</span>
											<h4>18</h4>
										</div>
									</div>
									<div class="col-sm-12">
										<div>
											<a href="javascript:void(0);" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#add_leaves">Apply New Leave</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> --}}
                <div class="row">
                    <div class="col-xl-4 d-flex">
                        <div class="card flex-fill border-primary attendance-bg">
                            <div class="card-body">
                                <div class="mb-4 text-center">
                                    <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Attendance
                                    </h4>
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
                                    <h4 class="fw-medium text-gray-5 mb-1" style="font-weight:900;">Current Month Attendance
                                        Summary</h4>
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
                                                                <span class="badge bg-danger">{{ $data->Status }}</span>
                                                            </td>
                                                        @elseif ($data->Status == 'Holiday')
                                                            <td>
                                                                <span class="badge bg-warning">{{ $data->Status }}</span>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span class="badge bg-success">{{ $data->Status }}</span>
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

            {{-- <div class="row">
					<div class="col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
									<h5>Projects</h5>
									<div class="dropdown">
										<a href="javascript:void(0);" class="btn btn-white border-0 dropdown-toggle border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
											Ongoing Projects
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">All Projects</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Ongoing Projects</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="card mb-4 shadow-none mb-md-0">
											<div class="card-body">
												<div class="d-flex align-items-center justify-content-between mb-3">
													<h6>Food & Nutritional Security</h6>
													<div class="dropdown">
														<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
															<i class="ti ti-dots-vertical"></i>
														</a>
														<ul class="dropdown-menu dropdown-menu-end p-3">
															<li>
																<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_task"><i class="ti ti-edit me-2"></i>Edit</a>
															</li>
															<li>
																<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
															</li>
														</ul>
													</div>
												</div>
												<div>
													<div class="d-flex align-items-center mb-3">
														<a href="javascript:void(0);" class="avatar">
															<img src="{{asset('assets/img/users/user-02.jpg')}}" class="img-fluid rounded-circle" alt="img">
														</a>
														<div class="ms-2">
															<h6 class="fw-normal"><a href="javascript:void(0);">Swapan Das</a></h6>
															<span class="fs-13 d-block">Project Leader</span>
														</div>
													</div>
													<div class="d-flex align-items-center mb-3">
														<a href="javascript:void(0);" class="avatar bg-soft-primary rounded-circle">
															<i class="ti ti-calendar text-primary fs-16"></i>
														</a>
														<div class="ms-2">
															<h6 class="fw-normal">14 Jan 2026</h6>
															<span class="fs-13 d-block">Deadline</span>
														</div>
													</div>
													<div class="d-flex align-items-center justify-content-between bg-transparent-light border border-dashed rounded p-2 mb-3">
														<div class="d-flex align-items-center">
															<span class="avatar avatar-sm bg-success-transparent rounded-circle me-1"><i class="ti ti-checklist fs-16"></i></span>
															<p>Tasks : <span class="text-gray-9">6 </span> /10</p>
														</div>
														<div class="avatar-list-stacked avatar-group-sm">
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-06.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-07.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-08.jpg')}}" alt="img">
															</span>
															<a class="avatar bg-primary avatar-rounded text-fixed-white fs-12 fw-medium" href="javascript:void(0);">
																+2
															</a>
														</div>
													</div>
													<div class="bg-soft-secondary p-2 rounded d-flex align-items-center justify-content-between">
														<p class="text-secondary mb-0 text-truncate">Time Spent</p>
														<h5 class="text-secondary text-truncate">15/60 <span class="fs-14 fw-normal">Days</span></h5>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="card shadow-none mb-0">
											<div class="card-body">
												<div class="d-flex align-items-center justify-content-between mb-3">
													<h6>Education (After School) , Livelihood</h6>
													
													<div class="dropdown">
														<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
															<i class="ti ti-dots-vertical"></i>
														</a>
														<ul class="dropdown-menu dropdown-menu-end p-3">
															<li>
																<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_task"><i class="ti ti-edit me-2"></i>Edit</a>
															</li>
															<li>
																<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
															</li>
														</ul>
													</div>
												</div>
												<div>
													<div class="d-flex align-items-center mb-3">
														<a href="javascript:void(0);" class="avatar">
															<img src="assets/img/users/user-03.jpg" class="img-fluid rounded-circle" alt="img">
														</a>														 
														<div class="ms-2">
															<h6 class="fw-normal"><a href="javascript:void(0);">Sumit Kumar Sanyal</a></h6>
															<span class="fs-13 d-block">Project Leader</span>
														</div>
													</div>
													<div class="d-flex align-items-center mb-3">
														<a href="javascript:void(0);" class="avatar bg-soft-primary rounded-circle">
															<i class="ti ti-calendar text-primary fs-16"></i>
														</a>
														<div class="ms-2">
															<h6 class="fw-normal">31 Mar 2026</h6>
															<span class="fs-13 d-block">Deadline</span>
														</div>
													</div>
													<div class="d-flex align-items-center justify-content-between bg-transparent-light border border-dashed rounded p-2 mb-3">
														<div class="d-flex align-items-center">
															<span class="avatar avatar-sm bg-success-transparent rounded-circle me-1"><i class="ti ti-checklist fs-16"></i></span>
															<p>Tasks : <span class="text-gray-9">15 </span> /25</p>
														</div>
														<div class="avatar-list-stacked avatar-group-sm">
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-06.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-07.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-08.jpg')}}" alt="img">
															</span>
															<a class="avatar bg-primary avatar-rounded text-fixed-white fs-12 fw-medium" href="javascript:void(0);">
																+2
															</a>
														</div>
													</div>
													<div class="bg-soft-secondary p-2 rounded d-flex align-items-center justify-content-between">
														<p class="text-secondary mb-0 text-truncate">Time Spent</p>
														<h5 class="text-secondary text-truncate">25/90 <span class="fs-14 fw-normal">Days</span></h5>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
									<h5>Tasks</h5>
									<div class="dropdown">
										<a href="javascript:void(0);" class="btn btn-white border-0 dropdown-toggle border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
											All Projects
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">All Projects</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Ongoing Projects</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="list-group list-group-flush">
									<div class="list-group-item border rounded mb-3 p-2">
										<div class="row align-items-center row-gap-3">
											<div class="col-md-8">
												<div class="todo-inbox-check d-flex align-items-center">
													<span><i class="ti ti-grid-dots me-2"></i></span>
													<div class="form-check">
														<input class="form-check-input" type="checkbox">
													</div>
													<span class="me-2 d-flex align-items-center rating-select"><i class="ti ti-star-filled filled"></i></span>
													<div class="strike-info">
														<h4 class="fs-14 text-truncate">Baseline & Planning</h4>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
													<span class="badge bg-soft-pink d-inline-flex align-items-center me-2"><i class="fas fa-circle fs-6 me-1"></i>Onhold</span>
													<div class="d-flex align-items-center">
														<div class="avatar-list-stacked avatar-group-sm">
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-32.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-33.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-34.jpg')}}" alt="img">
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="list-group-item border rounded mb-3 p-2">
										<div class="row align-items-center row-gap-3">
											<div class="col-md-8">
												<div class="todo-inbox-check d-flex align-items-center">
													<span><i class="ti ti-grid-dots me-2"></i></span>
													<div class="form-check">
														<input class="form-check-input" type="checkbox">
													</div>
													<span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
													<div class="strike-info">
														<h4 class="fs-14 text-truncate">Awareness & Capacity Building</h4>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
													<span class="badge bg-transparent-purple d-flex align-items-center me-2"><i class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
													<div class="d-flex align-items-center">
														<div class="avatar-list-stacked avatar-group-sm">
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-35.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-36.jpg')}}" alt="img">
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="list-group-item border rounded mb-3 p-2">
										<div class="row align-items-center row-gap-3">
											<div class="col-md-8">
												<div class="todo-inbox-check d-flex align-items-center">
													<span><i class="ti ti-grid-dots me-2"></i></span>
													<div class="form-check">
														<input class="form-check-input" type="checkbox">
													</div>
													<span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
													<div class="strike-info">
														<h4 class="fs-14 text-truncate">Food Production & Livelihood</h4>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
													<span class="badge badge-soft-success align-items-center me-2"><i class="fas fa-circle fs-6 me-1"></i>Completed</span>
													<div class="d-flex align-items-center">
														<div class="avatar-list-stacked avatar-group-sm">
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-37.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-38.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-32.jpg')}}" alt="img">
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="list-group-item border rounded mb-3 p-2">
										<div class="row align-items-center row-gap-3">
											<div class="col-md-8">
												<div class="todo-inbox-check d-flex align-items-center todo-strike-content">
													<span><i class="ti ti-grid-dots me-2"></i></span>
													<div class="form-check">
														<input class="form-check-input" type="checkbox" checked="">
													</div>
													<span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
													<div class="strike-info">
														<h4 class="fs-14 text-truncate">Nutrition Interventions</h4>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
													<span class="badge badge-secondary-transparent d-flex align-items-center me-2"><i class="fas fa-circle fs-6 me-1"></i>Pending</span>
													<div class="d-flex align-items-center">
														<div class="avatar-list-stacked avatar-group-sm">
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-35.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-34.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-33.jpg')}}" alt="img">
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="list-group-item border rounded p-2">
										<div class="row align-items-center row-gap-3">
											<div class="col-md-8">
												<div class="todo-inbox-check d-flex align-items-center">
													<span><i class="ti ti-grid-dots me-2"></i></span>
													<div class="form-check">
														<input class="form-check-input" type="checkbox">
													</div>
													<span class="me-2 rating-select d-flex align-items-center"><i class="ti ti-star"></i></span>
													<div class="strike-info">
														<h4 class="fs-14 text-truncate">Monitoring & Evaluation</h4>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
													<span class="badge bg-transparent-purple d-flex align-items-center me-2"><i class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
													<div class="d-flex align-items-center">
														<div class="avatar-list-stacked avatar-group-sm">
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-37.jpg')}}" alt="img">
															</span>
															<span class="avatar avatar-rounded">
																<img class="border border-white" src="{{asset('assets/img/profiles/avatar-38.jpg')}}" alt="img">
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> --}}

            {{-- <div class="row">
					<div class="col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="d-flex align-items-center justify-content-between flex-wrap">
									<h5>Team Members</h5>
									<div>
										<a href="#" class="btn btn-light btn-sm">View All</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between mb-4">
									<div class="d-flex align-items-center">
										<a href="javascript:void(0);" class="avatar flex-shrink-0">
											<img src="{{asset('assets/img/users/user-00.jpg')}}" class="rounded-circle border border-2" alt="img">
										</a>
										<div class="ms-2">
											<h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Arunesh Majumder</a></h6>
											<p class="fs-13">Dy Project Director</p>
										</div>
									</div>
									<div class="d-flex align-items-center">
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-phone fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-mail-bolt fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm"><i class="ti ti-brand-hipchat fs-16"></i></a>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-4">
									<div class="d-flex align-items-center">
										<a href="javascript:void(0);" class="avatar flex-shrink-0">
											<img src="{{asset('assets/img/users/user-00.jpg')}}" class="rounded-circle border border-2" alt="img">
										</a>
										<div class="ms-2">
											<h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Biswajit Nath</a></h6>
											<p class="fs-13">Field Director</p>
										</div>
									</div>
									<div class="d-flex align-items-center">
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-phone fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-mail-bolt fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm"><i class="ti ti-brand-hipchat fs-16"></i></a>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-4">
									<div class="d-flex align-items-center">
										<a href="javascript:void(0);" class="avatar flex-shrink-0">
											<img src="{{asset('assets/img/users/user-000.jpg')}}" class="rounded-circle border border-2" alt="img">
										</a>
										<div class="ms-2">
											<h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Debahutii Mukherjee</a></h6>
											<p class="fs-13">Administration Assistant</p>
										</div>
									</div>
									<div class="d-flex align-items-center">
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-phone fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-mail-bolt fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm"><i class="ti ti-brand-hipchat fs-16"></i></a>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-4">
									<div class="d-flex align-items-center">
										<a href="javascript:void(0);" class="avatar flex-shrink-0">
											<img src="{{asset('assets/img/users/user-000.jpg')}}" class="rounded-circle border border-2" alt="img">
										</a>
										<div class="ms-2">
											<h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Kalpana Sardar</a></h6>
											<p class="fs-13">Field Manager</p>
										</div>
									</div>
									<div class="d-flex align-items-center">
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-phone fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-mail-bolt fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm"><i class="ti ti-brand-hipchat fs-16"></i></a>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-4">
									<div class="d-flex align-items-center">
										<a href="javascript:void(0);" class="avatar flex-shrink-0">
											<img src="{{asset('assets/img/users/user-00.jpg')}}" class="rounded-circle border border-2" alt="img">
										</a>
										<div class="ms-2">
											<h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Rajkumar Maity</a></h6>
											<p class="fs-13">Director, Accounts & Admin</p>
										</div>
									</div>
									<div class="d-flex align-items-center">
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-phone fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-mail-bolt fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm"><i class="ti ti-brand-hipchat fs-16"></i></a>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<div class="d-flex align-items-center">
										<a href="javascript:void(0);" class="avatar flex-shrink-0">
											<img src="{{asset('assets/img/users/user-00.jpg')}}" class="rounded-circle border border-2" alt="img">
										</a>
										<div class="ms-2">
											<h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Manik Singha</a></h6>
											<p class="fs-13">Senior Field Manager</p>
										</div>
									</div>
									<div class="d-flex align-items-center">
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-phone fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm me-2"><i class="ti ti-mail-bolt fs-16"></i></a>
										<a href="#" class="btn btn-light btn-icon btn-sm"><i class="ti ti-brand-hipchat fs-16"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="d-flex align-items-center justify-content-between flex-wrap">
									<h5>Notifications</h5>
									<div>
										<a href="#" class="btn btn-light btn-sm">View All</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="d-flex align-items-start mb-4">
									<a href="javascript:void(0);" class="avatar flex-shrink-0">
										<img src="{{asset('assets/img/users/notif.jpg')}}" class="rounded-circle border border-2" alt="img">
									</a>
									<div class="ms-2">
										<h6 class="fs-14 fw-medium text-truncate mb-1">Baseline survey completed in 5 villages covering 420 households.</h6>
										<p class="fs-13 mb-2">Status Date : Today at 9:42 AM</p>
										<div class="d-flex align-items-center">
											<a href="#" class="avatar avatar-sm border flex-shrink-0 me-2"><img src="{{asset('assets/img/icons/pdf.svg')}}" class="w-auto h-auto" alt="Img"></a>
											<h6 class="fw-normal"><a href="#">Survey_Data.pdf</a></h6>
										</div>
									</div>
								</div>
								<div class="d-flex align-items-start mb-4">
									<a href="javascript:void(0);" class="avatar flex-shrink-0">
										<img src="{{asset('assets/img/users/notif.jpg')}}" class="rounded-circle border border-2" alt="img">
									</a>
									<div class="ms-2">
										<h6 class="fs-14 fw-medium text-truncate mb-1">Established 35 nutrition gardens at household level.</h6>
										<p class="fs-13 mb-0">Status Date : 12-08-2025</p>
									</div>
								</div>
								<div class="d-flex align-items-start mb-4">
									<a href="javascript:void(0);" class="avatar flex-shrink-0">
										<img src="{{asset('assets/img/users/notif.jpg')}}" class="rounded-circle border border-2" alt="img">
									</a>
									<div class="ms-2">
										<h6 class="fs-14 fw-medium text-truncate mb-1">Conducted 3 nutrition awareness sessions with participation of 210 women & children.</h6>
										<p class="fs-13 mb-2">Status Date : 17-08-2025</p>
										<!-- <div class="d-flex align-items-center">
											<a href="#" class="btn btn-primary btn-sm me-2">Approve</a>
											<a href="#" class="btn btn-outline-primary btn-sm">Decline</a>
										</div> -->
									</div>
								</div>
								<div class="d-flex align-items-start mb-4">
									<a href="javascript:void(0);" class="avatar flex-shrink-0">
										<img src="{{asset('assets/img/users/notif.jpg')}}" class="rounded-circle border border-2" alt="img">
									</a>
									<div class="ms-2">
										<h6 class="fs-14 fw-medium text-truncate mb-1">Linkage made with ICDS centers & local PHC for supplementary nutrition support.</h6>
										<p class="fs-13 mb-0">Status Date : 25-08-2025</p>
									</div>
								</div>
								<div class="d-flex align-items-start">
									<a href="javascript:void(0);" class="avatar flex-shrink-0">
										<img src="{{asset('assets/img/users/notif.jpg')}}" class="rounded-circle border border-2" alt="img">
									</a>
									<div class="ms-2">
										<h6 class="fs-14 fw-medium text-truncate mb-1">Setting up a community seed bank for nutrition-rich crops.</h6>
										<p class="fs-13 mb-0">Status Date : 28-08-2025</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div> --}}
        </div>



    </div>
    <!-- /Page Wrapper -->

    <!-- Add Leaves -->
    <div class="modal fade" id="add_leaves">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Leave</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="employee-dashboard.html">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Employee Name</label>
                                    <select class="select2">
                                        <option>Select</option>
                                        <option>Rajkumar Maity</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Leave Type</label>
                                    <select class="select2">
                                        <option>Select</option>
                                        <option>Medical Leave</option>
                                        <option>Casual Leave</option>
                                        <option>Earn Leave</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">From </label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">To </label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No of Days</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Remaining Days</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Reason</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Leaves</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Leaves -->
@endsection
@push('script')
    <script>
        $('.select2').select2({
            width: '100%', // respect your min-width:100% css
            dropdownParent: $('#add_leaves') // important inside modal
        });
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
