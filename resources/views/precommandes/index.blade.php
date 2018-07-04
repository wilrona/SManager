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
			<h4 class="mainTitle no-margin">Précommandes</h4>
			<span class="mainDescription">Gestion des précommandes </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Point de vente</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

        <div class="container-fluid container-fullw padding-bottom-10">
							<div class="row">
								<div class="col-md-12">

									<?php  if (Session::has('message')) { ?>
                                    <div id="system-message">
                                        <div class="alert alert-<?php echo session('type'); ?>">
                                            <a class="close" data-dismiss="alert"><i class="fa fa-close"></i></a>
                                            <div><p><?php echo session('message'); ?></p></div>
                                        </div>
                                    </div>
									<?php  } ?>

                                        <div class="panel panel-white">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Numéro </th>
                                                        <th>Pos emetteur</th>
                                                        <th>POS Destinateur</th>
                                                        <th>Statut</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($datas as $data)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{$data->numero}}</td>
                                                            <td>@if($data->id_point_de_vente_emetteur != null) {{ $data->posemetteur()->first()->libelle }} @endif</td>
                                                            <td>@if($data->id_point_de_vente_destinataire != null) {{ $data->posdestinataire()->first()->libelle }} @endif</td>

                                                            <td>
                                                                 @if($data->statut==-1)
                                                                 <span class="label label-default"> annulé</span>
                                                                 @endif
                                                                 @if($data->statut==2)
                                                                 <span class="label label-info"> En cours</span>
                                                                 @endif
                                                                 @if($data->statut==0)
                                                                 <span class="label label-danger"> refusé</span>
                                                                 @endif
                                                                 @if($data->statut==1)
                                                                 <span class="label label-success"> Validé</span>
                                                                 @endif
                                                            </td>
                                                            <td><a href="{{ url('precommandes/show', [$data->id]) }}"><i class="fa fa-eye"></i></a></td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>

                                                {{ $datas->links() }}
                                            </div>
                                        </div>
								</div>
							</div>
						</div>
						
						
						 
    </div>
@stop

@section('footer')
    @parent
	JavaScript

	
    
@stop