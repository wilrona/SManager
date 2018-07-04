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
            <h4 class="mainTitle no-margin">Fiche de la promotion</h4>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Promotions</li>
                <li>Fiche</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information de la promotion</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="panel-tools">
                                    <span data-original-title="@if($data->active) Désactivé @else Activé @endif" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm"><i class="fa @if($data->active) fa-circle @else fa-circle-o @endif"></i></span>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Actions <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="<?= url('promotions/edit', [$data->id]) ?>"> Modifier </a>
                                                </li>
                                                <li>
                                                    <a href="<?= url('promotions/activated', [$data->id]) ?>">@if($data->active) Désactiver @else Activer @endif </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('libelle') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Libelle : </label>
                                {!! Form::text('libelle', $data->libelle, ['class' => 'form-control', 'placeholder' => 'libelle de la promotion', 'disabled' => 'disabled']) !!}
                                {!! $errors->first('libelle', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Description : </label>
                                {!! Form::textarea('description', $data->description, ['class' => 'form-control', 'placeholder' => 'Entrer une description', 'disabled' => 'disabled']) !!}
                                {!! $errors->first('description', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('prix_promo') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Prix du produit : </label>
                                {!! Form::number('prix_promo', $data->prix_promo, ['class' => 'form-control', 'placeholder' => 'Prix promo à appliquer', 'disabled' => 'disabled']) !!}
                                {!! $errors->first('prix_promo', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('date_debut') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Date de début : </label>
                                {!! Form::text('date_debut', date('d/m/Y', strtotime($data->date_debut)), ['class' => 'form-control datepicker_start', 'placeholder' => 'Date de début', 'disabled' => 'disabled']) !!}
                                {!! $errors->first('date_debut', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('date_fin') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Date de fin : </label>
                                {!! Form::text('date_fin', date('d/m/Y', strtotime($data->date_fin)), ['class' => 'form-control datepicker_end', 'placeholder' => 'Date de fin', 'disabled' => 'disabled']) !!}
                                {!! $errors->first('date_fin', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('typeproduit_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Le produit de la promotion : </label>
                                {!! Form::select('typeproduit_id', $select, $data->typeproduit_id, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez le produit...', 'disabled' => 'disabled']) !!}
                                {!! $errors->first('typeproduit_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
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

@stop