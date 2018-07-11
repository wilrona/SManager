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
            <h4 class="mainTitle no-margin">Produits</h4>
            <span class="mainDescription">Gestion des produits </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Produits</li>
                <li>Modification</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            @if(session()->has('warning'))
                <div class="alert alert-warning alert-dismissible">{!! session('warning') !!}</div>
            @endif
            <div class="row">
                {!! Form::model($data, ['route' => ['produit.update', $data->id]]) !!}
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Information du produit</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('produit.show', $data->id) }}" class="btn btn-o btn-sm btn-default">Retour</a>
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
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Reference : </label>
                                {!! Form::text('reference', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('reference') !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom du produit : </label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom du produit']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Description : </label>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Entrer une description']) !!}
                                {!! $errors->first('description', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('unite_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Unité du produit : </label>
                                {!! Form::select('unite_id', $unites, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('unite_id') !!}
                                {!! $errors->first('unite_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('famille_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Famille du produit : </label>
                                {!! Form::select('famille_id', $familles, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('famille_id') !!}
                                {!! $errors->first('famille_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('bundle') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Type de produit : </label>
                                {!! Form::select('bundle', $select_bundle, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('bundle') !!}
                                {!! $errors->first('bundle', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('prix') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Prix du produit (<small>le prix du produit ne sera pas pris en compte pour les composés de produit (Bundle, Offres)</small>) : </label>
                                @if($data->bundle == 0)
                                    {!! Form::number('prix', null, ['class' => 'form-control', 'placeholder' => 'Prix']) !!}
                                @else
                                    {!! Form::number('prix', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! Form::hidden('prix') !!}
                                @endif
                                {!! $errors->first('prix', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>







                        </div>
                    </div>
                    @if($data->bundle == 1)
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Produits du bundle</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('produit.addBundle', $data->id) }}" class="btn btn-green btn-sm" style="margin-top: 9px;" data-toggle="modal" data-target="#myModal" data-backdrop="static"><i class="fa fa-plus"></i> Ajouter les produits</a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table table-stylish">
                                <thead>
                                    <tr>
                                        <th class="col-xs-1">#</th>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th>Prix</th>
                                        <th class="col-xs-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
		                        <?php if($produits):


		                            foreach($produits as $key => $value):
		                        ?>
                                    <tr>
                                        <td><?= $key + 1?></td>
                                        <td><?= $value['produit_name'] ?></td>
                                        <td><?= $value['quantite'] ?></td>
                                        <td><?= $value['prix'] ?></td>
                                        <td><a class="delete" onclick="remove(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
                                    </tr>
		                        <?php
		                            endforeach;
                                else:
		                        ?>
                                    <tr>
                                        <td colspan="5">
                                            <h4 class="text-center" style="margin: 0;">Aucun produit enregistré</h4>
                                        </td>
                                    </tr>
		                        <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Groupe de prix</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('produit.addGroupePrix', [$data->id, 1]) }}" class="btn btn-green btn-sm" style="margin-top: 9px;" data-toggle="modal" data-target="#myModal" data-backdrop="static"><i class="fa fa-plus"></i> Prix de famille de client</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('produit.addGroupePrix', [$data->id, 0]) }}" class="btn btn-green btn-sm" style="margin-top: 9px;" data-toggle="modal" data-target="#myModal" data-backdrop="static"><i class="fa fa-plus"></i> Prix pour client</a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body" id="loading_GroupPrix">
                            <table class="table table-stylish">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Client</th>
                                    <th>Prix</th>
                                    <th>Remise</th>
                                    <th>Qté min</th>
                                    <th>Programmé</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if($groupePrix):


                                foreach($groupePrix as $key => $value):
                                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value['produit_name'] ?></td>
                                    <td><?= $value['prix'] ?></td>
                                    <td><?= $value['remise'] ?><?php if($value['type_remise'] == 1): ?> % <?php endif; ?></td>
                                    <td><?= $value['quantite'] ?></td>
                                    <td>
	                                    <?php if(empty($value['date_debut']) && empty($value['date_fin'])):  ?> Non <?php endif; ?>
	                                    <?php if($value['date_debut']):  ?>
                                        <div><strong>Debut </strong>: <?= date('d-m-Y', strtotime($value['date_debut'])); ?></div>
	                                    <?php endif; ?>
	                                    <?php if($value['date_fin']):  ?>
                                        <div><strong>Fin </strong>: <?= date('d-m-Y', strtotime($value['date_fin'])); ?></div>
	                                    <?php endif; ?>
                                    </td>
                                    <td><a class="delete" onclick="remove_groupe(<?= $key ?>)"><i class="fa fa-trash"></i></a></td>
                                </tr>
                                <?php
                                endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="7">
                                        <h4 class="text-center" style="margin: 0;">Aucun groupe de prix enregistré</h4>
                                    </td>
                                </tr>
                                <?php endif; ?>

                                </tbody>
                            </table>
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
        function remove($key){
            $.ajax({
                url: "<?= route('produit.removeBundle') ?>/"+$key,
                type: 'GET',
                success : function(data){
                    $.ajax({
                        url: "<?= route('produit.listing') ?>",
                        type: 'GET',
                        success : function(list){
                            $('#loading').html(list);
                        }
                    });
                }
            });
        }

        function remove_groupe($key){
            $.ajax({
                url: "<?= route('produit.removeGroupePrix') ?>/"+$key,
                type: 'GET',
                success : function(data){
                    $.ajax({
                        url: "<?= route('produit.listingGroupePrix') ?>",
                        type: 'GET',
                        success : function(list){
                            $('#loading_GroupPrix').html(list);
                        }
                    });
                }
            });
        }
    </script>

@stop
