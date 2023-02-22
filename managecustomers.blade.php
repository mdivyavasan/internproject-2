@extends("layouts.app")

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Manage Customer</div>
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
						  <div class="ms-auto"><a href="{{ url('customerform/0') }}"  class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New </a></div>
						</div>
						<div class="table-responsive">
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th width="15%">S.I No</th>
										<th>Shop name</th>
										<th>Phone </th>
										<th>GST</th>
										<th>Client Status</th>
										<th  width="10%">Actions</th>
									</tr>
								</thead>
								<tbody>
                                    <?php $i = 1; ?>
								@foreach ($customerlist as $cusname)

                                    <tr>
                                        <td>{{ $i }}</td>

                                        <td>{{$cusname->shop_name}}</td>
                                        <td>{{$cusname->phone_number}}</td>
                                        <td>{{$cusname->gst_number}}</td>
										<td>{{$cusname->client_status}}</td>
                                        <td>
                                         <div class="d-flex order-actions">
											<a href="{{ url('customerform/'.$cusname->id ) }}" class=""><i class='bx bxs-edit'></i></a>
                                     		
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
