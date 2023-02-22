@extends("layouts.app")

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Manage Department Manager</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item active" aria-current="page">List</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->

				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
						  {{-- <div class="ms-auto"><a href="" --}}
                            {{-- "{{ url('customerform/0') }}"  --}}
                             {{-- class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New </a></div> --}}
						</div>
						<div class="table-responsive">
							<table id="mlist" class="table" style="width:100%">
								<thead class="table-light">
									<tr>
										<th width="5%">S.I No</th>
										<th>Users Name</th>
										<th>Email</th>
										<th width="10%">Phone</th>
										<th width="10%">Role</th>
										{{-- <th width="10%">Reset Password</th> --}}
										<th width="10%">Actions</th>
									</tr>
								</thead>
								<tbody>
                                    <?php $i = 1; ?>

                                @foreach ($managerlist as $uname)
                                    <tr>
                                        <td>{{ $i }}</td>
                                       <td>{{$uname->name}}</td>
                                        <td>{{$uname->email}}</td>
										<td>{{$uname->phone_number}}</td>
										<td>{{$uname->user_role}}</td>
                                        <td>
                                         <div class="d-flex order-actions">
                                             <a href="" class=""><i class='bx bxs-edit'></i></a>
                                             <a href="" class="ms-3"><i class='bx bxs-trash'></i></a>
                                         </div>
                                     </td>

                                     </tr>
									<?php $i++; ?>

                                     @endforeach




									</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!--end page wrapper -->
		@endsection
        @section("script")
        <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
       <script>

			 $(document).ready(function() {
				$('#mlist').DataTable();
			  } );

        </script>	@endsection
