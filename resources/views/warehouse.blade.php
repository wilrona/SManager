@extends('layouts.master')

@section('title', 'Welcome YooMee POS')

@section('sidebar')
    @parent

    <!--p>This is appended to the master sidebar.</p-->
@stop

@section('content')
    <div class="wrap-content container" id="container">
						<!-- start: BREADCRUMB -->
		<div class="breadcrumb-wrapper">
			<h4 class="mainTitle no-margin">ADD WAREHOUSE</h4>
			<span class="mainDescription">overview &amp; stats </span>
			<ul class="pull-right breadcrumb">
			<li><a href="index.html"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>WareHouses</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->
		<!-- start: FIRST SECTION -->
		<!-- start: BOOTSRAP NAV TREE -->
						<div class="container-fluid container-fullw bg-white">
							
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h4 class="panel-title">Basic <span class="text-bold">Tree</span></h4>
												</div>
												<div class="panel-body">

                                                        <p>Please fill in the information below. The field labels marked with * are required input fields.</p>
                                                        
                                                        <div class="form-group has-feedback">
                                                        <label class="control-label" for="name">Name *</label>
                                                        <input type="text" name="name" value="" class="form-control" id="name" required="required" data-bv-field="name"><i class="form-control-feedback" data-bv-icon-for="name" style="display: none;"></i>
                                                        <small class="help-block" data-bv-validator="notEmpty" data-bv-for="name" data-bv-result="NOT_VALIDATED" style="display: none;">Please enter/select a value</small></div>
                                                        <div class="form-group has-feedback">
                                                        <label class="control-label" for="code">Type *</label>
                                                        <input type="text" name="code" value="" class="form-control" id="code" required="required" data-bv-field="code"><i class="form-control-feedback" data-bv-icon-for="code" style="display: none;"></i>
                                                        <small class="help-block" data-bv-validator="notEmpty" data-bv-for="code" data-bv-result="NOT_VALIDATED" style="display: none;">Please enter/select a value</small>
                                                        </div>
                                                        <div class="form-group">
                                                        <label class="control-label" for="price_group">Parent Warehouse</label>
                                                        <select>
                                                        </select>
                                                        </div>
                                                        <div class="form-group">
                                                        <label class="control-label" for="phone">Phone</label>
                                                        <input type="text" name="phone" value="" class="form-control" id="phone">
                                                        </div>
                                                        <div class="form-group">
                                                        <label class="control-label" for="email">Email</label>
                                                        <input type="text" name="email" value="" class="form-control" id="email">
                                                        </div>
                                                       
                                                       
                                                        

												</div>
											</div>
										</div>
										
									</div>
								</div>
							
    </div>
@stop

@section('footer')
    @parent
	<script src="assets/js/letter-icons.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/treetable.js"></script>
	<script>
			jQuery(document).ready(function() {
				Main.init();
			});
	</script>
    
@stop