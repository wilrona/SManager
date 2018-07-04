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
            <h4 class="mainTitle no-margin">Clients</h4>
            <span class="mainDescription">Gestion des clients </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Clients</li>
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
                            <h4 class="panel-title">Information du client</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('client.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            <a href="<?= route('client.edit', [$data->id]) ?>" class="btn btn-primary btn-sm">
                                                Modifier
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                            <div class="panel-body">

                                <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Reférence : </label>
                                    {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>

                                <div class="form-group {!! $errors->has('famille_id') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold"> Famille de client : </label>
                                    {!! Form::select('famille_id', $familles, $data->famille_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('famille_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>

                                <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom : </label>
                                    {!! Form::text('nom', $data->nom, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('nom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('prenom') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Prenom : </label>
                                    {!! Form::text('prenom', $data->prenom, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('prenom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('dateNais') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Date de naissance : </label>
                                    {!! Form::date('dateNais', $data->dateNais, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('dateNais', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone Principal: </label>
                                    {!! Form::number('phone', $data->phone, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('phone', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('phone_un') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone 1: </label>
                                    {!! Form::number('phone_un', $data->phone_un, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('phone_un', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('phone_deux') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone 2: </label>
                                    {!! Form::number('phone_deux', $data->phone_deux, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('phone_deux', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse email : </label>
                                    {!! Form::email('email', $data->email, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('email', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('ville') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Ville : </label>
                                    {!! Form::text('ville', $data->ville, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('ville', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                                <div class="form-group {!! $errors->has('adresse') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse Complete : </label>
                                    {!! Form::textarea('adresse', $data->adresse, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! $errors->first('adresse', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>



                            </div>
                    </div>

                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop