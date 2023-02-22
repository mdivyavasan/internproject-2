		@extends("layouts.app")

		@section("style")
		<link href="{{ URL::asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
		<link href="{{ URL::asset('assets/plugins/datetimepicker/css/classic.time.css') }}" rel="stylesheet" />
		<link href="{{ URL::asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
		<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
		<link href="{{ URL::asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

	    @endsection


		@section("wrapper")
            <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Work Order</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item active" aria-current="page">Add / Edit work order </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
					<div class="d-lg-flex align-items-center mb-3 gap-1">
                        <a href="{{ url('/manageworkorders') }}"
                        type="button" class="btn btn-secondary"><i class="fadeIn animated bx bx-left-arrow-alt"></i>Back</a>
                        <div class="ms-auto">
                        </div>
                    </div>

					<?php
						$seltab = $customdata->atab ;

						$stab1 = "true";
						$stab2 = "false";
						$stab3 = "false";

						$ctab1 = "show active";
						$ctab2 = "";
						$ctab3 = "";

						if($seltab == "customerinfo"){
							$stab1 = "active";
							$stab2 = "";
							$stab3 = "";
							$ctab1 = "show active";
							$ctab2 = "";
							$ctab3 = "";
						}

						if($seltab == "orderinfotab"){
							$stab1 = "";
							$stab2 = "active";
							$stab3 = "";
							$ctab1 = "";
							$ctab2 = "show active";
							$ctab3 = "";
						}

						if($seltab == "matetab"){
							$stab1 = "";
							$stab2 = "";
							$stab3 = "active";
							$ctab1 = "";
							$ctab2 = "";
							$ctab3 = "show active";
						}

					?>

                    <div class="row">
                        <div class="col-xl-12 mx-auto">
                            <div class="card">
                                <div class="card-body">
								@if ($customdata->id != 0)
									<h4 class="mb-0">Work Order ID: {{ $customdata->workorder_id }} | Customer Name: {{ $customdata->client_name }}</h4>
								@else
									<h4 class="mb-0">Creating New Work Order</h4>
								@endif

								<hr />
								<ul class="nav nav-tabs nav-primary mb-0" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link {{ $stab1 }}" data-bs-toggle="tab" href="#customerinfo" role="tab" aria-selected="true">
									<div class="d-flex align-items-center">
										<div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
										</div>
										<div class="tab-title">Customer Information - {{ $customdata->client_name }}</div>
									</div>
								</a>
							</li>

							@if ($customdata->id != 0)
								<li class="nav-item" role="presentation">
									<a class="nav-link {{ $stab2 }}" data-bs-toggle="tab" href="#orderinfotab" role="tab" aria-selected="true">
										<div class="d-flex align-items-center">
											<div class="tab-icon"><i class='bx bx-bookmark-alt font-18 me-1'></i>
											</div>
											<div class="tab-title">Order Item Details</div>
										</div>
									</a>
								</li>
								<li class="nav-item" role="presentation">
									<a class="nav-link {{ $stab3 }}" data-bs-toggle="tab" href="#matetab" role="tab" aria-selected="true">
										<div class="d-flex align-items-center">
											<div class="tab-icon"><i class='bx bx-star font-18 me-1'></i>
											</div>
											<div class="tab-title">Materials Received</div>
										</div>
									</a>
								</li>
							@endif
						</ul>
						<div class="tab-content pt-3">
							<div class="tab-pane fade {{ $ctab1 }}" id="customerinfo" role="tabpanel">

							 <form id="needs-validation" novalidate method="post" action="{{ route('workorder.save') }}" >
                             @csrf

							 <div class="row g-4">

										<div class="col-md-6">
										<label for="inputFirstName" class="form-label   ">Search Customer</label>
										<div class="input-group mb-3">
                                         <select id="customerid" class="single-select">
                                            <option value="select" >select</option>
                                            @foreach ($customerlist as $manageproduct)
                                            <option value="{{ $manageproduct->id }}">
                                                {{ $manageproduct->shop_name." - ".$manageproduct->phone_number }}</option>
                                            @endforeach
										 </select><button class="btn btn-outline-secondary  getcustomerdetails" type="button" id="button-addon2">Get Details</button>
                                        </div>
										</div>
										<div class="col-md-6">
                                            <label for="scustomerid" class="form-label">Work Order ID</label>
											<div>{{ $customdata->workorder_id }}</div>
											<input type="hidden" name="scustomerid" id="scustomerid" value="{{ $customdata->customer_id }}" />

                                        </div>
										<div class="col-md-6">
                                            <label for="client_code" class="form-label">Client Code</label>
                                            <input placeholder="Client code" tabindex="1" type="text" class="form-control" id="client_code" name="client_code" value="{{ $customdata->client_code }}" required/>
                                            <div class="invalid-feedback">Please Enter the Client Code.</div>
                                        </div>
										<div class="col-md-6">
                                            <label for="client_name" class="form-label">Client Name</label>
                                            <input placeholder="Client Name" tabindex="2" type="" class="form-control" id="client_name" name="client_name" value="{{ $customdata->client_name }}" required/>
                                            <div class="invalid-feedback">Please Enter the Client Name.</div>
                                        </div>
										<div class="col-md-6">
                                            <label for="phone_number" class="form-label">Client Phone Number</label>
                                            <input placeholder="Enter phone number" tabindex="3"  type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $customdata->phone_number }}" required/>
                                            <div class="invalid-feedback">Please Enter the Client Phone Number.</div>
                                        </div>
										<div class="col-md-6">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" tabindex="4" id="address" name="address" placeholder="Address" rows="3" required>{{ $customdata->address }}</textarea>
                                            <div class="invalid-feedback">Please Enter the Address.</div>
                                        </div>

										<div class="col-md-6">
                                            <label for="order_type" class="form-label">Order Type</label>
                                            <select id="order_type" tabindex="5" class="form-select" name="order_type" required>
											 <option value="">select</option>

											 <?php
													$arrOrdertype = ["New Work","Repair Work"];
												    $itotcount = count($arrOrdertype);
												?>
												<?php
													for($i=0; $i<$itotcount ; $i++) {
														$selected = ($customdata->order_type == $arrOrdertype[$i]) ? 'selected="selected"' : '';
												?>
												   <option {{ $selected }} value="{{ $arrOrdertype[$i] }}">{{ $arrOrdertype[$i] }}</option>
												<?php } ?>
											</select>
                                            <div class="invalid-feedback">Please Enter the Order Type.</div>
                                        </div>

										<div class="col-md-6">
                                            <label for="order_date" class="form-label">Order Date</label>
                                            <input type="text" placeholder="Order date" id="order_date" name="order_date" required tabindex="6" class="form-control datepicker" value="{{ $customdata->order_date }}"  />
                                            <div class="invalid-feedback">Please Enter the Order Date.</div>
                                        </div>

										<div class="col-md-6">
                                            <label for="exp_deliverydate" class="form-label">Expected Delivery Date</label>
                                            <input type="text" placeholder="Delivery date" id="exp_deliverydate" name="exp_deliverydate" required tabindex="7" class="form-control datepicker" value="{{ $customdata->exp_deliverydate }}" />
                                            <div class="invalid-feedback">Please Enter the Expected Delivery Date.</div>
                                        </div>

										<div class="col-md-6">
                                            <label for="order_status" class="form-label">Order Status</label>
                                            <select id="order_status" tabindex="5" class="form-select" name="order_status" required>
											<option value="">select</option>
											  <?php
													$arrStatus = ["New","Inprogress","Completed","Delivered","Cancelled","Onhold"];
												    $itotcount = count($arrStatus);
												?>
												<?php
													for($i=0; $i<$itotcount ; $i++) {
														$selected = ($customdata->order_status == $arrStatus[$i]) ? 'selected="selected"' : '';
												?>
												   <option {{ $selected }} value="{{ $arrStatus[$i] }}">{{ $arrStatus[$i] }}</option>
												<?php } ?>
											</select>
                                            <div class="invalid-feedback">Please Enter the Order Status.</div>
                                        </div>

                                        <div class="ms-auto">
											@if ($customdata->id != 0)
												<button class= "btn btn-primary "type = "submit" >Save</button>
											@else
												<button class= "btn btn-primary "type = "submit" >Save & Next</button>
											@endif
                                            </div>
											</div>
                                            <input type="hidden" class="form-control" id="id" name="id" value="{{  $customdata->id}}">

							 </form>




							</div>



							@if ($customdata->id != 0)


							<div class="tab-pane fade {{ $ctab2 }}" id="orderinfotab" role="tabpanel">


								<div class="ms-auto">
                                                </div>
                                                <div class="d-lg-flex align-items-center mb-4 gap-3">


                                                    <div class="ms-auto">
                                                         <a href="javascript:void(0)" type="button" class="btn btn-primary orderitemdetails"><i class="bx bxs-plus-square"></i>Add New </a>

                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead class="table-light">
                                                           <tr>
                                                                <th width="5%">S.I No</th>
																<th>Product SKUID</th>
                                                                <th>Product Name</th>
																<th>Lot Number</th>
																<th>Order Quantity</th>
																<th>Update Details</th>
                                                                <th width="5%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
														<?php $i = 1;
														$olists = $customdata->orderitems;
														?>
														@foreach ($olists as $sproduct)
														<tr>
														<td>{{ $i }}</td>
														<td>{{ $sproduct->product_skuid }}</td>
														<td>{{ $sproduct->product_name }}</td>
														<td>{{ $sproduct->lotnumber }}</td>
														<td>{{ $sproduct->orderquantity }}</td>
														<th><a href="{{ url('workorderitems/'.$sproduct->id) }}" class="">View</a></th>
														<td>
														<div class="d-flex order-actions">
															<a href="{{ url('delwdassproduct/'.$sproduct->id ) }}" class="ms-3"><i class='bx bxs-trash'></i></a>
														</div>

														</td>
														</tr>

														<?php $i++; ?>
														@endforeach
                                                            </tbody>
                                                    </table>
                                                </div>


							</div>





							<div class="tab-pane fade {{ $ctab3 }}" id="matetab" role="tabpanel">

						<div class="ms-auto">
                                                </div>
                                                <div class="d-lg-flex align-items-center mb-4 gap-3">


                                                    <div class="ms-auto">
                                                         <a type="button" class="btn btn-primary" id="addmaterial" ></i>Add New </a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="5%">S.I No</th>
																<th>Material Name</th>
                                                                <th> Quantity </th>
                                                                <th> Date </th>
                                                                <th width="5%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                        $materialrlist = $customdata->materialitems;
                                                            ?>

                                                            @foreach ($materialrlist as $matrialrecivedname)
                                                            <tr>
                                                                <td>{{ $i }}</td>

                                                                <td>{{$matrialrecivedname->material_name}}
                                                                 <input type="hidden" id="mname_{{ $i }}" value="{{$matrialrecivedname->material_id }}" />
                                                                <input type="hidden" id="qnty_{{ $i }}"  value="{{$matrialrecivedname->received_qty}}" />
                                                                <input type="hidden" id="wmitemid_{{ $i }}"  value="{{$matrialrecivedname->id}}" />

                                                                <td>{{$matrialrecivedname->received_qty." ".$matrialrecivedname->scale_name }}</td>
                                                                <td>{{ @date("d-M-Y h:i:s",@strtotime($matrialrecivedname->received_date)) }}</td>

                                                                </td>
                                                                <td>
                                                                 <div class="d-flex order-actions">
                                                                     <a   dataid="{{ $i }}" class="editmaterial"><i class='bx bxs-edit'></i></a>                                                                    
                                                                 </div>
                                                             </td>
                                                             </tr>
                                                             <?php $i++; ?>
                                                             @endforeach
														</tbody>
                                                    </table>
                                                </div>


							</div>

							@endif

						</div>


                                </div>


                                        <div class="col">
                                            <!-- Button trigger modal -->

                                            <!-- Modal -->
                                            <div class="modal fade" id="departModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
													 <form  id="needs-validation" novalidate method="post" action="{{ route('workorder.items') }}">
													 @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="col-12">
                                                                <label for="category_id" class="form-label">Product Category</label>
                                                                <select  class="form-select" id="category_id" name ="category_id" required>
                                                                    <option value ="">select</option>
                                                                    @foreach ($manageprodulist as $manageproduct)
                                                                    <option value="{{ $manageproduct->id }}"> {{ $manageproduct->category_name }}</option>
                                                                    @endforeach
                                                                  </select>
                                                                  <div class="invalid-feedback">Please Enter the Product Category.</div>
                                                              </div>
                                                            <div class="col-12">
                                                                <label for="product_id" class="form-label">Products</label>
                                                                <select class="form-select prodaddlist" id="product_id" name ="product_id" required>
                                                                  </select>
                                                                  <div class="invalid-feedback">Please Enter the Products.</div>
                                                              </div>

                                                        </div>
                                                        <div class="modal-footer">
															<input type="hidden" name="workorderid" value="{{ $customdata->id }}">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Add</button>
                                                        </div>
														</form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                          {{-- material recieved modal --}}
                          <div class="col">
                            <div class="modal fade" id="materalrecivedmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                     <form id="needs-validation" novalidate method="post"  action="{{ route('materialrecived.detail') }}">
                                     @csrf
                                        <div class="modal-body">
                                            <div class="modal-header">
                                                <h5 class="modal-title" class="title" id="title">Material Recieved</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="col-12">
                                                <label for="material_id" class="form-label">Select Material</label>
                                                <select  class="form-select" id="material_id" name ="material_id" required>
                                                    <option value ="">select</option>
                                                    @foreach ($managematrial as $managemat)
                                                    <option datascale="{{$managemat->scale_name}}" value="{{ $managemat->id }}">
                                                        {{ $managemat->material_name }}</option>
                                                        @endforeach
                                                  </select>
                                                  <div class="invalid-feedback">Please Select the Products.</div>
                                              </div>
                                            <div class="col-12">
                                                <label for="received_qty" class="form-label">Received Quantity</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control border-start-1" id="received_qty" name="received_qty" required/>
													<div id="mscale" style="padding:10px;color:#ff0000;"></div>
                                                    <div class="invalid-feedback">Please Enter the Received Quantity.</div>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="modal-footer">

                                            <input type="hidden" name="mworkorderid" value="{{ $customdata->id }}">
                                            <input type="hidden" name="wmitemid" id="wmitemid" />
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
</div>

</div>

		@endsection

  @section("script")
  <script>
		var urlhome = "{{ URL::to('') }}";
	    </script>
	<script src="{{ URL::asset('assets/plugins/datetimepicker/js/legacy.js') }}"></script>
	<script src="{{ URL::asset('assets/plugins/datetimepicker/js/picker.js') }}"></script>
	<script src="{{ URL::asset('assets/plugins/datetimepicker/js/picker.time.js') }}"></script>
	<script src="{{ URL::asset('assets/plugins/datetimepicker/js/picker.date.js') }}"></script>
	<script>
		$('.datepicker').pickadate({
			selectMonths: true,
	        selectYears: true,
			format: 'yyyy-mm-dd'
		})
	</script>
	<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/workorders.js') }}"></script>
	<script>
		$('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
		
		$('.prodaddlist').select2({
									theme: 'bootstrap4',
									width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
									placeholder: $(this).data('placeholder'),
									allowClear: Boolean($(this).data('allow-clear')),
								});
	</script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
          'use strict'

          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.querySelectorAll('#needs-validation')

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




