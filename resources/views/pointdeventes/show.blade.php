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
            <h4 class="mainTitle no-margin">Point de vente</h4>
            <span class="mainDescription">Gestion des points de vente </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Paramètres</li>
                <li>Points de vente</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information sur le point de vente</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('pos.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            <a href="{{ route('pos.edit', $data->id) }}" class="btn btn-primary btn-sm">
                                                Modifier
                                            </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Reference : </label>
                                {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Nom du POS : </label>
                                {!! Form::text('name', $data->name, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('type') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Type de POS : </label>
                                {!! Form::select('type', $type, $data->type, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('type', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Caisse du point de vente</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Caisse</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php if($data->Caisses()->count()):

                                    foreach($data->Caisses()->get() as $key => $value):
                                    ?>
                                    <tr>
                                        <td><?= $key + 1?></td>
                                        <td><?= $value->name ?></td>
                                    </tr>
                                    <?php
                                    endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="2">
                                        <h4 class="text-center" style="margin: 0;">Aucune caisse enregistrée</h4>
                                    </td>
                                </tr>
				                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Magasin du point de vente</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Magasin</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php if($data->Magasins()->count()):

				                foreach($data->Magasins()->get() as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td><?= $value->name ?></td>
                                </tr>
				                <?php
				                endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="2">
                                        <h4 class="text-center" style="margin: 0;">Aucun magasin enregistré</h4>
                                    </td>
                                </tr>
				                <?php endif; ?>
                                </tbody>
                            </table>
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