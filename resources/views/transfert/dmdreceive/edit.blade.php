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
            <h4 class="mainTitle no-margin">Demandes Stocks</h4>
            <span class="mainDescription">Gestion des demandes de stock </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Demande de stock</li>
                <li>Fiche</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
                @if(session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible">{!! session('warning') !!}</div>
                @endif
            <div class="row">
                {!! Form::model($data, ['route' => ['receive.update', $data->id]]) !!}
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Information de la demande reçue</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('receive.show', $data->id) }}" class="btn btn-o btn-sm btn-default">Retour</a>
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
                                <!--<label for="exampleInputEmail1" class="text-bold text-capitalize"> Reference : </label>-->
                                {!! Form::text('reference', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('reference') !!}

                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_dmd_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente demandeur : </label>
                                {!! Form::select('pos_dmd_id', $pos, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('pos_dmd_id') !!}
                                {!! $errors->first('pos_dmd_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('mag_dmd_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Magasin associé : </label>
                                {!! Form::select('mag_dmd_id', $mag, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('mag_dmd_id') !!}
                                {!! $errors->first('mag_dmd_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente destinataire : </label>
                                {!! Form::select('pos_appro_id', $pos, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('pos_appro_id') !!}
                                {!! $errors->first('pos_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('mag_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Magasin de sortie des produits : </label>
                                @if($data->mag_appro_id)
                                {!! Form::select('mag_appro_id', $my_mag, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('mag_appro_id') !!}
                                @else
                                {!! Form::select('mag_appro_id', $my_mag, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez l\'un de vos magasins...']) !!}
                                @endif
                                {!! $errors->first('mag_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('motif') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Motif de la demande : </label>
                                {!! Form::textarea('motif', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('motif') !!}
                                {!! $errors->first('motif', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>


                        </div>
                    </div>

                </div>
                <div class="col-md-4"></div>
                {!! Form::close() !!}
            </div>
        </div>

					
    </div>
@stop

@section('footer')
    @parent
	
    
@stop