@extends("layouts.app")

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Manage Products </div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="index"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">List</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
                            <div class="ms-auto">
                        <a  type="button" class="btn btn-primary  elecproductmanage" data-bs-toggle="modal" data-bs-target="#exampleScrollableModal"><i class="bx bxs-plus-square"></i>Add new</a>
                            </div>
						</div>
                        <div class="table-responsive">
							<table class="table mb-0">
								<thead class="table-light">
									<tr>									
										<th  width="10%">Product ID</th>
											<th>Product Image</th>	
										<th>Product SKU </th>
										<th>Product Name</th>
										
										<th>Product Category</th>										
																										
										<th  width="10%">Actions</th>
									</tr>
								</thead>
								<tbody>
								   <?php $i = 1; ?>
								@foreach ($manageprolist as $manageproduct)
								<tr>

										<td>{{$manageproduct->id}}</td>
										<td>
										@If($manageproduct->primaryimage)
											<img src= "{{$manageproduct->primaryimage}}" style="height:50px;width:50px;cursor:pointer;" class="mdlshowimage" />
										@else
											-
										@Endif

										</td>	
										<td>{{$manageproduct->product_skuid}}</td>
										<td>{{$manageproduct->product_name}}
                                            <input type="hidden" id="dname_{{ $i }}"  value="{{$manageproduct->product_name}} " />
                                             </td>
										
                                             <td>
                                                {{$manageproduct->catname}}
                                                <input type="hidden" id="ddesc_{{ $i }}" value="{{$manageproduct->product_desc}} " />
                                                <input type="hidden" id="catid_{{ $i }}" value="{{$manageproduct->category_id}} " />
                                                <input type="hidden" id="deptid_{{ $i }}" value="{{$manageproduct->id}} " />
                                                <input type="hidden" id="product_skuid{{ $i }}" value="{{$manageproduct->product_skuid}} " />
												</td>
                                        
																		
                                       
										<td>
											<div class="d-flex order-actions">
                                               <a  href="{{ url('editproduct/'.$manageproduct->id ) }}"  class="btn btn-primary"><i class='bx bxs-edit'></i></a>

												<a href="{{ url('deleteproductmanagaement/'.$manageproduct->id ) }}"
                                                class="ms-3"><i class='bx bxs-trash'></i></a>
											</div>
										</td>
									</tr>
									<?php $i++; ?>
									@endforeach

								</tbody>
							</table>
                            <div class="col">

                            </div>
						</div>

                        <div class="col">
                            <div class="modal fade" id="productmanageModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">

                             <form class="row g-4 needs-validation" novalidate method="post" action= "{{ route('product.details') }}" autocomplete="off" >
                                @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id ="manageproductmodalLabel">Add new Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12">
                                <label for="category_id" class="form-label">Product Category</label>
                                <select class="form-select" id="category_id" name ="category_id" required>
                                   <option value ="">select</option>
                                    @foreach ($manageprodulist as $manageproduct)
                                    <option value="{{ $manageproduct->id }}">
                                        {{ $manageproduct->category_name }}</option>
                                    @endforeach
                                  </select>


                              </div>
                              <div class="mb-3">
								<label for="product_skuid" class="form-label" required>Product SKU</label>
								<input class="form-control" id="product_skuid" name="product_skuid" rows="3" required></textarea>
                <div class="invalid-feedback">Please Enter the Product SKU.</div>
							  </div>
							<div class="mb-3">
								<label for="product_name" class="form-label"  >Product Name</label>
								<input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product title"  autocomplete="off" required>
                <div class="invalid-feedback">Please Enter the Product Name.</div>
							  </div>
							  <div class="mb-3">
								<label for="product_desc" class="form-label" required>Description</label>
								<textarea class="form-control" id="product_desc" name="product_desc" rows="3"></textarea>
							  </div>
                                        </div>
                                        <div class="modal-footer">
										     <input type="hidden" id="deptid"  name="deptid">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save & Next</button>
                                        </div>
                                    </div>
                             </form>
                                </div>
                            </div>
                        </div>


						<div class="col">
                            <div class="modal fade" id="showprodimage" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">


                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id ="manageproductmodalLabel">Product Image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="dspprodimage"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



					</div>
				</div>
			</div>
		</div>
		<!--end page wrapper -->
		@endsection

        @section("script")
        <script src="{{ URL::asset('assets/js/productmanagement.js') }}">
        </script>
        <script>
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (function () {
                          'use strict'

                          // Fetch all the forms we want to apply custom Bootstrap validation styles to
                          var forms = document.querySelectorAll('.needs-validation')

                          // Loop over them and prevent submission
                          Array.prototype.slice.call(forms)
                            .forEach(function (form) {
                              form.addEventListener('submit', function (event) {
                                if (!form.checkValidity()) {
                                  event.preventDefault()
                                  event.stopPropagation()
                                }

                                form.classList.add('was-validated')
                              }, false)
                            })
                        })()
                </script>

		@endsection


