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
            <h4 class="mainTitle no-margin">Unités de produit</h4>
            <span class="mainDescription">Gestion des unités de produit </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Paramètres</li>
            <li>Unités de produit</li>
			</ul>
		</div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                {!! Form::open(['route' => 'unite.store']) !!}
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information sur l'unité de produit </h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('unite.index') }}"  class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            {!! Form::submit('Valider', ['class' => 'btn btn-primary btn-sm']) !!}
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <!--<label for="exampleInputEmail1" class="text-bold"> Reference (<small>Généré automatiquement si le champ est vide</small>): </label>-->
                                {!! Form::text('reference', $reference, ['class' => 'form-control hidden', 'placeholder' => 'Reference']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Nom de l'unité de produit : </label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom unité']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-4">

                </div>
                {!! Form::close() !!}
            </div>
        </div>
						
						
					
    </div>
@stop

@section('footer')
    @parent

	<!--script src="assets/js/letter-icons.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/treetable.js"></script-->
	
    
@stop