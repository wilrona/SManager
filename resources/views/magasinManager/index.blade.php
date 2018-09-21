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
			<h4 class="mainTitle no-margin">Magasins</h4>
			<span class="mainDescription">Gestion des magasins </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Magasins</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

        <div class="container-fluid container-fullw padding-bottom-10">
                            @if(session()->has('ok'))
                                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                            @endif
							<div class="row">
								<div class="col-md-12">

                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Mes Magasins</h4>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table  sample_3">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Magasin</th>
                                                        <th class="col-xs-1"></th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach ($datas as $data)
                                                        <tr  @if($data->etat) class="success" @endif>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $data->name }}</td>
                                                            <td>
                                                                <a href="" class="btn btn-primary"><i class="fa fa-bar-chart"></i> Rapport</a>
                                                            </td>
                                                            <td>


                                                                @if($data->pivot->principal)
                                                                    @if($data->etat == 0)
                                                                            <a href="{{ route('magasinManager.preopen', $data->id) }}" data-toggle="modal" data-target="#myModal" data-backdrop="static" class="btn btn-primary"> <i class="fa fa-toggle-off"></i> Ouverture</a>

                                                                    @else

                                                                            <a href="{{ route('magasinManager.open', $data->id) }}" class="btn btn-primary"> <i class="fa fa-toggle-on"></i> Manager la caisse</a>

                                                                    @endif
                                                                @endif



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
@stop

@section('footer')
    @parent
    
@stop