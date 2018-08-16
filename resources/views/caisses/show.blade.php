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
                <li>Paramètres</li>
                <li>Caisses</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information sur la caisse</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('caisse.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            <a href="{{ route('caisse.edit', $data->id) }}" class="btn btn-primary btn-sm">
                                                Modifier
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    @if($data->etat == 1)
                                        <a data-original-title="Caisse Ouverte" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-success"></i></a>
                                    @endif

                                    @if($data->etat == 0)
                                        <a data-original-title="Caisse Cloturée" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-danger"></i></a>
                                    @endif

                                        @if($data->etat == 2)
                                            <a data-original-title="Caisse en recouvrement" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-warning"></i></a>
                                        @endif

                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Reference (<small>Généré automatiquement si le champ est vide</small>): </label>
                                {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Nom de la caisse : </label>
                                {!! Form::text('name', $data->name, ['class' => 'form-control', 'disabled' => '']) !!}
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