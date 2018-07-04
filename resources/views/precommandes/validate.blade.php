<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 07/06/2018
 * Time: 11:00
 */
?>
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
            <h4 class="mainTitle no-margin">Précommandes</h4>
            <span class="mainDescription">Gestion des précommandes</span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Précommandes</li>
                <li>Validation</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Toutes les infos la précommande N° <b>{{$current->numero}}</b> </h4>
                        </div>
                        <div class="panel-body">

                            <div class="row margin-top-20">
                                <div class="col-md-6">
                                    <h3 class="margin-bottom-0">Recherche et ajout des produits</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="form-field-search" class="form-control" name="search_produit" placeholder="Entrer un numéro de serie">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary submit_search">
                                                <i class="fa fa-search"></i>
                                                Go!
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12 padding-top-20 pre-scrollable">
                                    <table class="table table-striped table-bordered table-hover table-full-width sample_3" id="sample_3">
                                        <thead>
                                            <tr>
                                                <th>Serie</th>
                                                <th>Produit</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{--<tr>--}}
                                                {{--<td colspan="3">--}}
                                                    {{--<h4 class="text-center margin-bottom-0">Aucun produit trouvé</h4>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-white">
                        <div class="panel-body">
                            <h3 class="">Produits Ajoutés</h3>
                            <div class="row">

                                <div class="col-md-12 padding-top-20">
                                    <table class="table table-striped table-bordered table-hover table-full-width sample_4" id="sample_4">
                                        <thead>
                                        <tr>
                                            <th>N° Serie</th>
                                            <th>Produit</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($precommande_reference as $precmd)
                                            <tr>
                                                <td>{{ $precmd['reference'] }}</td>
                                                <td>{{ $precmd['produit'] }}</td>
                                                <td><button class="btn btn-danger btn-sm">Supprimer</button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="margin-top-50">
                                <a href="<?= url('precommandes/show', [$current->id]) ?>" class="btn btn-o btn-wide btn-default pull-left">Retour</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title"><b>Produits demandés</b></h4>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                @foreach ($current->produits as $data)

                                    <tr>
                                        <td>{{$data->libelle}}</td>
                                        <td><span id="{{ $data->id }}">0</span>/{{$data->pivot->qte}}</td>
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

@stop

@section('footer')
    @parent

    <script>



        function searchProduct($current){
            $value = $current.val();


            $.ajax({
                url: "<?= route('precommande.validation.search') ?>/"+$value+"/<?= $current->id ?>",
                type: 'GET',
                success : function(data){
                    oTable_3.fnClearTable();
                    var $data = data.data;
                    if($data.one_product === 1){
                        $.each( $data.produits, function( key, value ) {
                            oTable_4.fnAddData( [
                                value.reference,
                                value.produit,
                                '<button class="btn btn-danger btn-sm">Supprimer</button>'
                            ] );
                        });
                    }else{
                        $.each( $data.produits, function( key, value ) {
                            oTable_3.fnAddData( [
                                value.reference,
                                value.produit,
                                '<button class="btn btn-primary btn-sm">Ajouter</button>'
                            ] );
                        });
                    }




                }
            });

//            console.log(oTable_3);

        }


        $('#form-field-search').on('keyup', function () {
            searchProduct($(this));
        });

        $('.submit_search').on('click', function (e)  {
            e.preventDefault();
            $this = $('#form-field-search');
            searchProduct($this);
        })
    </script>


@stop
