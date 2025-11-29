@extends('layouts.preclinic-app')

@section('content')
<!-- ========================
			Start Page Content
		========================= -->
         
        <div class="page-wrapper">

            <!-- Start Content -->
            <div class="content">

                <!-- Start Page Header -->
                <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2 mb-3 pb-3 border-bottom">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-0">Manajemen Dokter</h4>
                    </div>
                    <div class="text-end d-flex">
                        <a href="javascript:void(0);" class="btn btn-primary ms-2 fs-13 btn-md" data-bs-toggle="modal" data-bs-target="#add_role"><i class="ti ti-plus me-1"></i>Tambah</a>
                    </div>
				</div>
				<!-- End Page Header -->

                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telp</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Diupdate</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>(Id)</td>
                                <td>(Kode)</td>
                                <td>(Nama)</td>
                                <td>(Alamat)</td>
                                <td>(Telp)</td>
                                <td>(Jenis)</td>
                                <td>(Status)</td>
                                <td>(Diupdate)</td>
                                <td>
                                    <div class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <button type="button" class="btn btn-outline-info">Ubah</button>
                                        </a>
                                        <ul class="dropdown-menu p-2">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_role">Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_role">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                                
            </div>
            <!-- End Content -->

            <!-- Footer Start -->
            <div class="footer text-center bg-white p-2 border-top">
                <p class="text-dark mb-0">2025 &copy; <a href="javascript:void(0);" class="link-primary">Preclinic</a>, All Rights Reserved</p>
            </div>
            <!-- Footer End -->

        </div>

        <!-- ========================
			End Page Content
		========================= -->

        <!-- Start Add Modal -->
        <div id="add_role" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-dark modal-title fw-bold">New Role</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                    </div>
                    <form action="roles-and-permissions.html">
                        <div class="modal-body">
                            <div class="mb-0">
                                <label class="form-label">Role<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add New Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Modal -->

        <!-- Start Add Modal -->
        <div id="edit_role" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-dark modal-title fw-bold">Edit Role</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                    </div>
                    <form action="roles-and-permissions.html">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Role<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" value="Doctor">
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                                <select class="select">
                                    <option>Select</option>
                                    <option selected="">Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Modal -->

        <!-- Start Delete Modal  -->
        <div class="modal fade" id="delete_role">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center position-relative z-1">
                        <img src="assets/img/bg/delete-modal-bg-01.png" alt="" class="img-fluid position-absolute top-0 start-0 z-n1">
                        <img src="assets/img/bg/delete-modal-bg-02.png" alt="" class="img-fluid position-absolute bottom-0 end-0 z-n1">
                        <div class="mb-3">
                            <span class="avatar avatar-lg bg-danger text-white"><i class="ti ti-trash fs-24"></i></span>
                        </div>
                        <h5 class="fw-bold mb-1">Delete Confirmation</h5>
                        <p class="mb-3">Are you sure want to delete?</p>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:void(0);" class="btn btn-light position-relative z-1 me-3" data-bs-dismiss="modal">Cancel</a>
                            <a href="roles-and-permissions.html" class="btn btn-danger position-relative z-1">Yes, Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Delete Modal  -->
@endsection

