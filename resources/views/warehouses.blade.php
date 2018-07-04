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
			<h4 class="mainTitle no-margin">WareHouses</h4>
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
									<h5 class="over-title margin-bottom-15"><span class="text-bold">jsTree</span></h5>
									<p>
										jsTree is jquery plugin, that provides interactive trees. jsTree is easily extendable, themable and configurable, it supports HTML & JSON data sources and AJAX loading.
									</p>
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h4 class="panel-title">Basic <span class="text-bold">Tree</span></h4>
												</div>
												<div class="panel-body">
													<table id="tree-table" class="table table-hover table-bordered">
                                                        <tbody>
                                                        <th>#</th>
                                                        <th>Test</th>
                                                        <tr data-id="1" data-parent="0" data-level="1">
                                                        <td data-column="name">YooMee Direction Générale</td>
                                                        <td>Additional info</td>
                                                        </tr>
                                                        <tr data-id="2" data-parent="1" data-level="2" >
                                                        <td data-column="name">Node 1</td>
                                                        <td>Additional info</td>
                                                        </tr>
                                                        <tr data-id="3" data-parent="1" data-level="2">
                                                        <td data-column="name">Node 1</td>
                                                        <td>Additional info</td>
                                                        </tr>
                                                        <tr data-id="4" data-parent="3" data-level="3">
                                                        <td data-column="name">Node 1</td>
                                                        <td>Additional info</td>
                                                        </tr>
                                                        <tr data-id="5" data-parent="3" data-level="3">
                                                        <td data-column="name">Node 1</td>
                                                        <td>Additional info</td>
                                                        </tr>
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