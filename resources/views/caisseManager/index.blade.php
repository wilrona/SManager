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
			<h4 class="mainTitle no-margin">Caisses</h4>
			<span class="mainDescription">Gestion des caisses </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Caisses</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

        <div class="container-fluid container-fullw padding-bottom-10">
							<div class="row">
								<div class="col-md-12">

                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Caisse centrale du point de vente</h4>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table  sample_3">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Caisse</th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($datas_pos as $data)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $data->name }}</td>
                                                            <td><a href=""><i class="fa fa-eye"></i></a> | <a href=""><i class="fa fa-eye"></i></a></td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Mes Caisses</h4>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table  sample_3">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Caisse</th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($datas as $data)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $data->name }}</td>
                                                            <td><a href=""><i class="fa fa-eye"></i></a> | <a href=""><i class="fa fa-eye"></i></a></td>
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