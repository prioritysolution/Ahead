@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
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
                    <h2 class="mb-1">Leave Approval</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('Home') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            {{-- <li class="breadcrumb-item">
									Login
								</li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Leave Approval</li>
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

                <div class="col-xl-12">
                    <div class="card flex-fill border-primary attendance-bg">
                        <div class="card-header justify-content-between">
                            <div class="card-title text-center">
                                <h4 class="fw-medium text-gray-5 mb-1" style="font-weight: 900 !important;">Leave Approval
                                </h4>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="custom-datatable-filter table-responsive">
                                            <table class="table" id="rpt_attend">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="no-sort">
                                                            SL
                                                        </th>
                                                        <th>Applied Date</th>
                                                        <th>Application No</th>
                                                        <th>Employee Name</th>
                                                        <th>Leave From</th>
                                                        <th>Leave To</th>
                                                        <th>No. Of Days</th>
                                                        <th>Leave Type</th>
                                                        <th>Reason</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sl = 1;
                                                    @endphp
                                                    @foreach ($appl_list as $pend_appl)
                                                        <tr>
                                                            <td> {{ $sl++ }} </td>
                                                            <td> {{ $pend_appl->ApplDt }} </td>
                                                            <td> {{ $pend_appl->ApplNo }} </td>
                                                            <td> {{ $pend_appl->EmpNm }} </td>
                                                            <td> {{ $pend_appl->LvFrm }} </td>
                                                            <td> {{ $pend_appl->LvTo }} </td>
                                                            <td> {{ $pend_appl->LvNo }} </td>
                                                            <td> {{ $pend_appl->LvType }} </td>
                                                            <td> {{ $pend_appl->LvReason }} </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm action-btn open-leave-modal"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#leaveActionModal"
                                                                    data-id="{{ $pend_appl->Id }}">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
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

                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /Page Wrapper -->
    <div class="modal fade" id="leaveActionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title">Leave Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- Hidden ID -->
                    <input type="hidden" id="leave_id" name="leave_id">

                    <!-- ACTION DROPDOWN -->
                    <div class="mb-3">
                        <label class="form-label">Action</label>
                        <select class="form-select select2" id="leave_status">
                            <option value="" Selected Disabled>Select Action</option>
                            @foreach ($sts_list as $status)
                                <option value=" {{ $status->Id }} ">{{ $status->Value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- REMARKS -->
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarks" cols="30" rows="5" placeholder="Enter remarks (optional)"></textarea>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal" onclick="apprv_leave();">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/js/payroll/lev_apprv.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#rpt_attend').DataTable({
                dom: 'frtip', // 🔍 search + table + pagination
                paging: true, // ✅ pagination ON
                pageLength: 10, // rows per page
                lengthChange: false, // ❌ hide "Show entries"
                info: false, // ❌ hide "Showing x to y"
                searching: true, // ✅ search ON
                ordering: true, // ✅ sorting (optional)
            });
        });
    </script>
@endpush
