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
            @if($page === 'provisions')
                <h4 class="mainTitle no-margin">Liste des provisions</h4>

                <span class="mainDescription">Gestion des provisions </span>
            @endif


            @if($page === 'reception')
                <h4 class="mainTitle no-margin">Liste des receptions</h4>

                <span class="mainDescription">Gestion des receptions </span>
            @endif
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                @if($page === 'reception')
                    <li>Receptions</li>
                @endif
                @if($page === 'provisions')
                    <li>Provisions</li>
                @endif
                <li>Fiche</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw ">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="panel panel-white">
                                <div class="panel-heading border-light">
                                    <h4 class="panel-title">Toutes les infos du transfert N° <b>{{$data->numero}}</b> </h4>


                                        <ul class="panel-heading-tabs border-light">
                                            <li class="middle-center">
                                                <div class="pull-right">
                                                        <div class="btn-group" dropdown="">
                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                Actions <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                @if(!$data->expedition)
                                                                <li>
                                                                    <a href="<?= url('provisions/cancel', [$data->id]) ?>">
                                                                        Annuler
                                                                    </a>
                                                                </li>

                                                                @endif

                                                                @if($data->expedition != 4)
                                                                <li>
                                                                    <a href="" data-toggle="modal" data-target="#myModal" data-backdrop="static">
                                                                        creer une expédition
                                                                    </a>
                                                                </li>
                                                                @endif

                                                            </ul>
                                                        </div>
                                                </div>
                                            </li>

                                        </ul>
                                </div>

                                <div class="panel-body">


                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Pos emetteur</label>
                                                <input type="text"   class="form-control" value="{{ $data->pos_vendeur()->first()->libelle }}" disabled="true" >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="name">Pos Destinataire</label>
                                                <input type="text"  class="form-control" value="{{ $data->pos_client()->first()->libelle }}" disabled="true" >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="name">Montant de la commande</label>
                                                <input type="text"  class="form-control" value="{{$data->montant_total}}" disabled="true" >
                                            </div>



                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Date création</label>
                                                <input type="text"  id="email" name="email" class="form-control" value="{{date("jS F, Y", strtotime($data->created_at))}}" disabled="true" >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="name">Date dernière modification</label>
                                                <input type="text"  id="email" name="email" class="form-control" value="{{$data->updated_at}}" disabled="true" >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="name">Utilisateur émetteur</label>
                                                <input type="text"  id="email" name="email" class="form-control" value="@if($data->vendeur_id != null) {{$data->vendeur()->first()->nom}} {{$data->vendeur()->first()->prenom}} @endif" disabled="true" >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="name">Etat Expédition</label>
                                                @if(!$data->expedition)
                                                    <?php $expedition = 'Non Expédié' ?>
                                                @else
                                                    @if($data->expedition === 1)
                                                        <?php $expedition = 'Expédition en cours'; ?>
                                                    @else
                                                        <?php $expedition = 'Produits Reçu'; ?>
                                                    @endif
                                                @endif
                                                <input type="text"  id="email" name="email" class="form-control" value="{{$expedition}}" disabled="true" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-body">
                                        <table class="table" id="sample_1">
                                            <thead>
                                            <tr>
                                                <th>Produits</th>
                                                <th>Prix</th>
                                                <th>Produits</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($data->produits as $prod)

                                                <tr>
                                                    <td>{{$prod->reference}}</td>
                                                    <td>{{$prod->pivot->prix}}</td>
                                                    <td>{{$prod->type_produit()->first()->libelle}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop