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
			<h4 class="mainTitle no-margin">Utilisateurs</h4>
			<span class="mainDescription">Gestion des utilisateurs </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Utilisateurs</li>
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
                                                <ul class="panel-heading-tabs border-light">
                                                    <li>
                                                        <div class="pull-right">
                                                            <a href="{{ route('user.create') }}" class="btn btn-green btn-sm" style="margin-top: 9px;"><i class="fa fa-plus"></i> Nouveau </a>

                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table  sample_5">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Nom</th>
                                                        <th>Téléphone</th>
                                                        <th>Email</th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($datas as $data)
                                                        @if($data->roles()->where('name', '!=', 'super_admin')->first())
                                                        <tr>
                                                            <td>{{ $loop->index}}</td>
                                                            <td>{{ $data->nom }} {{ $data->prenom }}</td>
                                                            <td>{{ $data->phone }}</td>
                                                            <td>{{ $data->email }}</td>
                                                            <td><a href="{{ route('user.show', $data->id) }}"><i class="fa fa-eye"></i></a></td>
                                                        </tr>
                                                        @endif
                                                        @if(!$data->profile_id && !$data->roles()->count())
                                                            <tr>
                                                                <td>{{ $loop->index }}</td>
                                                                <td>{{ $data->nom }} {{ $data->prenom }}</td>
                                                                <td>{{ $data->phone }}</td>
                                                                <td>{{ $data->email }}</td>
                                                                <td><a href="{{ route('user.show', $data->id) }}"><i class="fa fa-eye"></i></a></td>
                                                            </tr>
                                                        @endif
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