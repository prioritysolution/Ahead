@extends('layouts.layouts')
@section('contain')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Admin Dashboard</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>
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
                            <img src="assets/img/profiles/avatar-31.jpg" class="rounded-circle" alt="img">
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

            <div class="row justify-content-center align-items-center">

                <!-- Widget Info -->
                {{-- <div class="col-xxl-8 d-flex">
						<div class="row flex-fill">
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-primary mb-2">
											<i class="ti ti-calendar-share fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Attendance Overview</h6>
										<h3 class="mb-3">120/154 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
										<a href="attendance-employee.html" class="link-default">View Details</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-secondary mb-2">
											<i class="ti ti-browser fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total No of Project's</h6>
										<h3 class="mb-3">90/125 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-2.1%</span></h3>
										<a href="projects.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-info mb-2">
											<i class="ti ti-users-group fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total No of Clients</h6>
										<h3 class="mb-3">69/86 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
										<a href="clients.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-pink mb-2">
											<i class="ti ti-checklist fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total No of Tasks</h6>
										<h3 class="mb-3">225/28 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-down me-1"></i>+11.2%</span></h3>
										<a href="tasks.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-purple mb-2">
											<i class="ti ti-moneybag fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Earnings</h6>
										<h3 class="mb-3">$21445 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+10.2%</span></h3>
										<a href="expenses.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-danger mb-2">
											<i class="ti ti-browser fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Profit This Week</h6>
										<h3 class="mb-3">$5,544 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
										<a href="purchase-transaction.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-success mb-2">
											<i class="ti ti-users-group fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Job Applicants</h6>
										<h3 class="mb-3">98 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
										<a href="job-list.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-dark mb-2">
											<i class="ti ti-user-star fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">New Hire</h6>
										<h3 class="mb-3">45/48 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
										<a href="candidates.html" class="link-default">View All</a>
									</div>
								</div>
							</div>
						</div>
					</div> --}}
                <!-- /Widget Info -->
                {{-- <div class="col-xl-4 d-flex">
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
                </div> --}}

            </div>

            {{-- <div class="row">


					<!-- Attendance Overview -->
					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Attendance Overview</h5>
								<div class="dropdown mb-2">
									<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
										<i class="ti ti-calendar me-1"></i>Today
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-body">
								<div class="chartjs-wrapper-demo position-relative mb-4">
									<canvas id="attendance" height="200"></canvas>
									<div class="position-absolute text-center attendance-canvas">
										<p class="fs-13 mb-1">Total Attendance</p>
										<h3>120</h3>
									</div>
								</div>
								<h6 class="mb-3">Status</h6>
								<div class="d-flex align-items-center justify-content-between">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-success me-1"></i>Present</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">59%</p>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-secondary me-1"></i>Late</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">21%</p>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-warning me-1"></i>Permission</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">2%</p>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-2">
									<p class="f-13 mb-2"><i class="ti ti-circle-filled text-danger me-1"></i>Absent</p>
									<p class="f-13 fw-medium text-gray-9 mb-2">15%</p>
								</div>
								<div class="bg-light br-5 box-shadow-xs p-2 pb-0 d-flex align-items-center justify-content-between flex-wrap">
									<div class="d-flex align-items-center">
										<p class="mb-2 me-2">Total Absenties</p>
										<div class="avatar-list-stacked avatar-group-sm mb-2">
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/profiles/avatar-27.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img class="border border-white" src="assets/img/profiles/avatar-30.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img src="assets/img/profiles/avatar-14.jpg" alt="img">
											</span>
											<span class="avatar avatar-rounded">
												<img src="assets/img/profiles/avatar-29.jpg" alt="img">
											</span>
											<a class="avatar bg-primary avatar-rounded text-fixed-white fs-10" href="javascript:void(0);">
												+1
											</a>
										</div>
									</div>
									<a href="leaves.html" class="fs-13 link-primary text-decoration-underline mb-2">View Details</a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Attendance Overview -->

					<div class="col-xxl-4 col-xl-6 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
									<h5>Meetings Schedule</h5>
									<div class="dropdown">
										<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
											<i class="ti ti-calendar me-1"></i>Today
										</a>
										<ul class="dropdown-menu  dropdown-menu-end p-3">
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="dropdown-item rounded-1">This Year</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body schedule-timeline">
								<div class="d-flex align-items-start">
									<div class="d-flex align-items-center active-time">
										<span>11:25 AM</span>
										<span><i class="ti ti-point-filled text-primary fs-20"></i></span>
									</div>
									<div class="flex-fill ps-3 pb-4 timeline-flow">
										<div class="bg-light p-2 rounded">
											<p class="fw-medium text-gray-9 mb-1">Monitoring Meeting</p>
											<span>Project Manager, M&E Officer, Field Staff</span>
										</div>
									</div>
								</div>
								<div class="d-flex align-items-start">
									<div class="d-flex align-items-center active-time">
										<span>02:20 PM</span>
										<span><i class="ti ti-point-filled text-secondary fs-20"></i></span>
									</div>
									<div class="flex-fill ps-3 pb-4 timeline-flow">
										<div class="bg-light p-2 rounded">
											<p class="fw-medium text-gray-9 mb-1">Training Session</p>
											<span>Orientation on data collection & reporting</span>
										</div>
									</div>
								</div>
								<div class="d-flex align-items-start">
									<div class="d-flex align-items-center active-time">
										<span>05:00 PM</span>
										<span><i class="ti ti-point-filled text-warning fs-20"></i></span>
									</div>
									<div class="flex-fill ps-3 pb-4 timeline-flow">
										<div class="bg-light p-2 rounded">
											<p class="fw-medium text-gray-9 mb-1">Partner Review Meeting</p>
											<span>Review progress, clarify deliverables, budget update</span>
										</div>
									</div>
								</div>
								<div class="d-flex align-items-start">
									<div class="d-flex align-items-center active-time">
										<span>06:00 PM</span>
										<span><i class="ti ti-point-filled text-success fs-20"></i></span>
									</div>
									<div class="flex-fill ps-3 timeline-flow">
										<div class="bg-light p-2 rounded">
											<p class="fw-medium text-gray-9 mb-1">Update of Project Flow</p>
											<span>Consolidate findings, finalize action plan</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div> --}}

        </div>



    </div>
    <!-- /Page Wrapper -->

    <!-- Add Project -->
    <div class="modal fade" id="add_project" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header header-border align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h5 class="modal-title me-2">Add Project </h5>
                        <p class="text-dark">Project ID : PRO-0004</p>
                    </div>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="add-info-fieldset">
                    <div class="add-details-wizard p-3 pb-0">
                        <ul class="progress-bar-wizard d-flex align-items-center border-bottom">
                            <li class="active p-2 pt-0">
                                <h6 class="fw-medium">Basic Information</h6>
                            </li>
                            <li class="p-2 pt-0">
                                <h6 class="fw-medium">Members</h6>
                            </li>
                        </ul>
                    </div>
                    <fieldset id="first-field-file">
                        <form action="https://smarthr.co.in/demo/html/template/projects.html">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div
                                            class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                            <div
                                                class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                                <i class="ti ti-photo text-gray-2 fs-16"></i>
                                            </div>
                                            <div class="profile-upload">
                                                <div class="mb-2">
                                                    <h6 class="mb-1">Upload Project Logo</h6>
                                                    <p class="fs-12">Image should be below 4 mb</p>
                                                </div>
                                                <div class="profile-uploader d-flex align-items-center">
                                                    <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                                        Upload
                                                        <input type="file" class="form-control image-sign"
                                                            multiple="">
                                                    </div>
                                                    <a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Project Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Client</label>
                                            <select class="select2">
                                                <option>Select</option>
                                                <option>Anthony Lewis</option>
                                                <option>Brian Villalobos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <div class="input-icon-end position-relative">
                                                        <input type="text" class="form-control datetimepicker"
                                                            placeholder="dd/mm/yyyy" value="02-05-2024">
                                                        <span class="input-icon-addon">
                                                            <i class="ti ti-calendar text-gray-7"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">End Date</label>
                                                    <div class="input-icon-end position-relative">
                                                        <input type="text" class="form-control datetimepicker"
                                                            placeholder="dd/mm/yyyy" value="02-05-2024">
                                                        <span class="input-icon-addon">
                                                            <i class="ti ti-calendar text-gray-7"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Priority</label>
                                                    <select class="select2">
                                                        <option>Select</option>
                                                        <option>High</option>
                                                        <option>Medium</option>
                                                        <option>Low</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Project Value</label>
                                                    <input type="text" class="form-control" value="$">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Total Working Hours</label>
                                                    <div class="input-icon-end position-relative">
                                                        <input type="text" class="form-control timepicker"
                                                            placeholder="-- : -- : --" value="02-05-2024">
                                                        <span class="input-icon-addon">
                                                            <i class="ti ti-clock-hour-3 text-gray-7"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Extra Time</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-0">
                                            <label class="form-label">Description</label>
                                            <div class="summernote"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="button" class="btn btn-outline-light border me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary wizard-next-btn" type="button">Add Team
                                        Member</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                    <fieldset>
                        <form action="https://smarthr.co.in/demo/html/template/projects.html">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label me-2">Team Members</label>
                                            <input class="input-tags form-control" placeholder="Add new" type="text"
                                                data-role="tagsinput" name="Label" value="Jerald,Andrew,Philip,Davis">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label me-2">Team Leader</label>
                                            <input class="input-tags form-control" placeholder="Add new" type="text"
                                                data-role="tagsinput" name="Label" value="Hendry,James">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label me-2">Project Manager</label>
                                            <input class="input-tags form-control" placeholder="Add new" type="text"
                                                data-role="tagsinput" name="Label" value="Dwight">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label class="form-label">Tags</label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>High</option>
                                                <option>Low</option>
                                                <option>Medium</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="button" class="btn btn-outline-light border me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#success_modal">Save</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Project -->
@endsection

@push('script')
    <script>
        $('.select2').select2({
            width: '100%', // respect your min-width:100% css
            dropdownParent: $('#add_project') // important inside modal
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
