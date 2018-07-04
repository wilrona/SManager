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
			<h4 class="mainTitle no-margin">Welcome to Packet</h4>
			<span class="mainDescription">overview &amp; stats </span>
			<ul class="pull-right breadcrumb">
			<li><a href="index.html"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Products</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->
		<!-- start: FIRST SECTION -->
		<div class="container-fluid container-fullw padding-bottom-10">
        </div>
    </div>
@stop

@section('footer')
    @parent
    
@stop