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
			<li>Paramètres</li>
			<li>Magasins</li>
			</ul>
		</div>

        <div class="container-fluid container-fullw padding-bottom-10">
            @if(!isset($type[1]))
                <div class="alert alert-warning alert-dismissible">
                    La <b>reference du magasin de transit</b> n'a pas été définie dans les paramètres. <br>
                    Vous ne pouvez pas en creer un et effectuer des <b>ordres de transfert</b> entre magasin.
                </div>
            @endif
            <div class="row">

                {!! Form::open(['route' => 'magasin.store']) !!}
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information sur le magasin</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('magasin.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
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
                                <!-- <label for="exampleInputEmail1" class="text-bold"> Reference (<small>Généré automatiquement si le champ est vide</small>): </label> -->
                                {!! Form::text('reference', $reference, ['class' => 'form-control hidden', 'placeholder' => 'Reference']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Nom du magasin : </label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom du magasin']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('transite') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Type de magasin : </label>
                                {!! Form::select('transite', $type, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Type de magasin']) !!}
                                {!! $errors->first('transite', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente du magasin : </label>
                                {!! Form::select('pos_id', $pos, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Point de vente']) !!}
                                {!! $errors->first('pos_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
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