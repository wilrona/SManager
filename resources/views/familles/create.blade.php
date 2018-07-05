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
            @if($type == 0)
                <h4 class="mainTitle no-margin">Familles de produit</h4>
                <span class="mainDescription">Gestion des familles de produit </span>
            @else
                <h4 class="mainTitle no-margin">Familles de client</h4>
                <span class="mainDescription">Gestion des familles de client </span>
            @endif
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Paramètres</li>
                @if($type == 0)
                    <li>Familles de produit</li>
                @else
                    <li>Familles de client</li>
                @endif
			</ul>
		</div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                {!! Form::open(['route' => 'famille.store']) !!}
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information sur la @if($type == 0) Familles de produit  @else Familles de client @endif</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a @if($type == 0) href="{{ route('famillepro.index') }}"  @else href="{{ route('famillecli.index') }}" @endif  class="btn btn-o btn-sm btn-default">Retour</a>
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
                                <label for="exampleInputEmail1" class="text-bold"> Nom de @if($type == 0) la famille de produit @else la famille de client @endif : </label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom de la famille']) !!}
                                {!! Form::hidden('type', $type) !!}
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