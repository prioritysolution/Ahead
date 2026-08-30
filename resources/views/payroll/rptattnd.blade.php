@extends('layouts.layouts')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
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
                    <h2 class="mb-1">Attandance Report</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Reports
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Attandance List</li>
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



            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>Attandance Details</h5>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        <div class="me-3 flex-fill">
                            <label for="frm_date" class="form-label">From Date</label>
                            <input type="text" id="frm_date" placeholder="DD/MM/YYYY"
                                class="form-control bs-datepicker-format" />
                        </div>
                        <div class="me-3 flex-fill">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="text" id="to_date" placeholder="DD/MM/YYYY"
                                class="form-control bs-datepicker-format" />
                        </div>
                        <div class="dropdown me-3 ">
                            <label for="emp_id" class="form-label">Select Employee</label>
                            <select name="emp_id" id="emp_id" class="select2 form-control">
                                <option value="" Selected Disabled>Select Employee</option>
                                <option value="0">All Employee</option>
                                @foreach ($emp_list as $list)
                                    <option value="{{ $list->Id }}">{{ $list->StaffNm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dropdown me-3 ">
                            <a class="btn btn-primary" style="margin-top: 27px;" onclick="gen_details();">Genereate</a>
                            <a class="btn btn-success" style="margin-top: 27px;" onclick="export_excel();">
                                <i class="fa-solid fa-file-excel"></i> Export To Excel
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="custom-datatable-filter table-responsive">
                        <table class="table" id="rpt_attend">
                            <thead class="thead-light">
                                <tr>
                                    <th class="no-sort">
                                        SL
                                    </th>
                                    <th>Staff Name</th>
                                    <th>Punch Date</th>
                                    <th>In Time</th>
                                    <th>Punch Remarks</th>
                                    <th>Out Time</th>
                                    <th>Out Remarks</th>
                                </tr>
                            </thead>
                            <tbody>




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
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/dayjs.min.js') }}"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script>
        $(".select2").select2();
        $(document).ready(function() {
            let picker = $('.bs-datepicker-format').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                todayBtn: 'linked',
                autoclose: true
            });

            // Set today's date
            picker.datepicker('setDate', new Date());


        });

        var table = $('#rpt_attend').DataTable({
            bFilter: true,
            ordering: true,
            info: true,
            language: {
                search: ' ',
                sLengthMenu: 'Row Per Page _MENU_ Entries',
                searchPlaceholder: "Search",
                info: "Showing _START_ - _END_ of _TOTAL_ entries",
                paginate: {
                    next: '<i class="ti ti-chevron-right"></i>',
                    previous: '<i class="ti ti-chevron-left"></i>'
                },
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: null,
                className: 'd-none',
                filename: 'Attendance_Report', // actual file name
                exportOptions: {
                    modifier: {
                        page: 'all' // export all rows
                    }
                }
            }]
        });

        function format_date(p) {
            if (p == '') {
                return '';
            } else {
                let parts = p.split('/'); // ["12","10","2025"]
                let dateObj = new Date(parts[2], parts[1] - 1, parts[0]);
                dateObj = dayjs(dateObj).format("YYYY-MM-DD");
                return dateObj;
            }

        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        function gen_details() {
            var pFrm_Date = format_date($("#frm_date").val());
            var pTo_Date = format_date($("#to_date").val());
            var pEmp_Id = $("#emp_id").val();
            if (pEmp_Id == null) {
                pEmp_Id = 0;
            }


            if (pFrm_Date == '') {
                warning_alert("Please Select From Date !!");
            } else if (pTo_Date == '') {
                warning_alert("Please Select To Date !!");
            } else {

                $.ajax({
                    url: baseUrl + "/Report/ProcessAttendDetails",
                    type: "GET",
                    data: {
                        pFrm_Date: pFrm_Date,
                        pTo_Date: pTo_Date,
                        pEmp_Id: pEmp_Id
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.status === "success") {
                            $("#nb-global-spinner").fadeIn();
                            var data = response.data;
                            var rows = [];
                            var sl = 1;


                            // Then in your AJAX success
                            table.clear(); // remove old rows
                            data.forEach(function(tbldata) {
                                rows.push([
                                    sl++,
                                    tbldata.EmpName ?? '',
                                    dayjs(tbldata.AttnDate, "MM-DD-YYYY", true)
                                    .format("DD-MMM-YYYY") ?? '',
                                    tbldata.AttnTime ?? '',
                                    tbldata.AttnRemrks ?? '',
                                    tbldata.OutTime ?? '',
                                    tbldata.OutRemrks ?? ''
                                ]);
                            });
                            table.rows.add(rows).draw();
                            $("#nb-global-spinner").fadeOut();
                        } else {
                            error_message("Something Went Wrong !!");
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = JSON.parse(xhr.responseText).errors;
                            let errorMessages = Object.values(errors).flat().join("\n");
                            error_message(errorMessages);
                        } else {
                            console.error("Error:", xhr);
                            error_message(xhr.responseJSON.message);
                        }
                    },
                });
            }


        }

        function export_excel() {

            table.button('.buttons-excel').trigger(); // trigger hidden Excel export
        }
    </script>
@endpush
