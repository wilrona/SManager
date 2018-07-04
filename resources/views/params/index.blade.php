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
			<h4 class="mainTitle no-margin">Configuration</h4>
			<span class="mainDescription">Gestion des configurations </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Configuration</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-12">
                        @if(session()->has('ok'))
                            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                        @endif

                        <div class="panel panel-white">
                            <div class="panel-heading border-light">
                                <h4 class="panel-title">Configurations de l'application</h4>
                            </div>
                            <div class="panel-body">
                                <div class="tabbable tabs-left" style="height: 100%">
                                    <ul class="nav nav-tabs">
                                        @foreach($datas as $data)
                                            <li @if($data['active'] == true) class="active" @endif>
                                                <a href="#{{ $data['name'] }}" data-toggle="tab"> {{ $data['display_name'] }} </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" style="height: 100%">
                                        @foreach($datas as $data)
                                            <div class="tab-pane fade @if($data['active'] == true) in active @endif" id="{{ $data['name'] }}">
                                                <p>
                                                    Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.
                                                </p>
                                                <p>
                                                    Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.
                                                </p>
                                            </div>
                                        @endforeach
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
    
@stop