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
            <h4 class="mainTitle no-margin">Création d'une provision</h4>
            <span class="mainDescription">Gestion des provisions </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Provisions</li>
                <li>Création</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h3 class="panel-title">Information de l'approvisonnement</h3>
                        </div>
                        <div class="panel-body">
                            {!! Form::open(['route' => 'provision.store']) !!}

                            <div class="form-group {!! $errors->has('pos_vendeurs') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente émetteur : </label>
                                {!! Form::text('pos_vendeurs', $user_pos->libelle, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                <input type="hidden" value="<?= $user_pos->id ?>" name="pos_vendeur">
                            </div>
                            <div class="form-group {!! $errors->has('pos_acheteur') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente recepteur : </label>
                                {!! Form::select('pos_acheteur', $select, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez un point de vente...']) !!}
                                {!! $errors->first('pos_acheteur', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('montantverse') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Montant versé : </label>
                                {!! Form::number('montantverse', null, ['class' => 'form-control', 'placeholder' => 'Montant versé', 'id' => 'montantverse', 'value' => 0]) !!}
                                {!! $errors->first('montantverse', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>



                            <div class="row">
                                <div class="col-md-12 space20">
                                    <a href="<?= url('provisions/add') ?>" class="btn btn-green" data-toggle="modal" data-target="#myModal" data-backdrop="static">
                                        Ajouter un produit <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>

                            {!! $errors->first('produit', '<div class="alert alert-warning"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </div>
                                ') !!}



                            <div class="table-responsive" id="loading">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($produits)
                                        @foreach($produits as $key => $value)
                                            <tr>
                                                <td>{{ $value['produit'] }}</td>
                                                <td>{{ $value['qte'] }}</td>
                                                <td><a class="delete" onclick="remove({{$key}})"><i class="fa fa-trash"></i></a></td>
                                            </tr>
                                        @endforeach
                                        <input type="hidden" name="produit" value="1">
                                    @else
                                        <tr>
                                            <td colspan="3">
                                                <h3 class="text-center">Aucun produit enregistré</h3>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="produit" value="">
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                            {!! Form::close() !!}
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
                url: "<?= url('provisions/removeStore') ?>/"+$key,
                type: 'GET',
                success : function(data){
                    $.ajax({
                        url: "<?= url('provisions/listing') ?>",
                        type: 'GET',
                        success : function(list){
                            $('#loading').html(list);
                        }
                    });
                }
            });
        }
    </script>

@stop
