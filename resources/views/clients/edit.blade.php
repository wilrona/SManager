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
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Clients</li>
                <li>Création</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                {!! Form::model($data, ['route' => ['client.update', $data->id]]) !!}
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Information du client</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('client.show', $data->id) }}" class="btn btn-o btn-sm btn-default">Retour</a>
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
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Reférence : </label>
                                {!! Form::text('reference', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('reference') !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('famille_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Famille de client : </label>
                                {!! Form::select('famille_id', $familles, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez une famille de client...']) !!}
                                {!! $errors->first('famille_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom : </label>
                                {!! Form::text('nom', null, ['class' => 'form-control', 'placeholder' => 'Entrer le nom']) !!}
                                {!! $errors->first('nom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('prenom') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Prenom : </label>
                                {!! Form::text('prenom', null, ['class' => 'form-control', 'placeholder' => 'Entrer le prenom']) !!}
                                {!! $errors->first('prenom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('dateNais') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Date de naissance : </label>
                                {!! Form::date('dateNais', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone']) !!}
                                {!! $errors->first('dateNais', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('sexe') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Sexe : </label>
                                {!! Form::select('sexe', $sexe, null, ['class' => 'js-example-basic form-control input-lg', 'placeholder' => 'Selectionnez un sexe...']) !!}
                                {!! $errors->first('sexe', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('nationalite') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Nationalité : </label>
                                {!! Form::select('nationalite', $nationalite, null, ['class' => 'js-example-basic form-control input-lg', 'placeholder' => 'Selectionnez une nationalité...']) !!}
                                {!! $errors->first('nationalite', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('profession') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Profession : </label>
                                {!! Form::text('profession', null, ['class' => 'form-control', 'placeholder' => 'Entrer la profession']) !!}
                                {!! $errors->first('profession', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <hr>

                            <div class="form-group {!! $errors->has('noCNI') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numero CNI (carte d'identité) : </label>
                                {!! Form::text('noCNI', null, ['class' => 'form-control', 'placeholder' => 'Entrer le numero CNI']) !!}
                                {!! $errors->first('noCNI', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('dateCNI') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Date de délivrance CNI : </label>
                                {!! Form::date('dateCNI', null, ['class' => 'form-control', 'placeholder' => 'Entrer la date de délivrance']) !!}
                                {!! $errors->first('dateCNI', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <hr>

                            <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone Principal: </label>
                                {!! Form::number('phone', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone principal']) !!}
                                {!! $errors->first('phone', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('phone_un') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone 1: </label>
                                {!! Form::number('phone_un', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone 1']) !!}
                                {!! $errors->first('phone_un', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('phone_deux') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone 2: </label>
                                {!! Form::number('phone_deux', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone 2']) !!}
                                {!! $errors->first('phone_deux', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse email : </label>
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Entrer une adresse email']) !!}
                                {!! $errors->first('email', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('ville_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Ville du client : </label>
                                {!! Form::select('ville_id', $villes, null, ['class' => 'js-example-basic form-control input-lg', 'placeholder' => 'Selectionnez une ville...']) !!}
                                {!! $errors->first('ville_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('quartier') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Quartier : </label>
                                {!! Form::text('quartier', null, ['class' => 'form-control', 'placeholder' => 'Entrer un ville']) !!}
                                {!! $errors->first('quartier', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('adresse') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse Complete : </label>
                                {!! Form::textarea('adresse', null, ['class' => 'form-control', 'placeholder' => 'Entrer une adresse']) !!}
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

    <script>
        $(".js-example-basic").select2({
//            dropdownParent: $("#myModal-vt"),
            allowClear: true,
            theme: "bootstrap",
            language: "fr"
        });
    </script>

@stop
