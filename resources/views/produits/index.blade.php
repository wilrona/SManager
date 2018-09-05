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
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">

            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('ok'))
                        <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                    @endif
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            @if(!$single)
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('produit.create') }}" class="btn btn-green btn-sm" style="margin-top: 9px;"><i class="fa fa-plus"></i> Nouveau </a>

                                    </div>
                                </li>

                            </ul>
                            @endif
                        </div>
                        <div class="panel-body">
                            <table class="table  sample_5">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Nom du produit</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                            @if($single)

                                                <a href="{{ route('produit.showUser', ['id' => $data->id, 'single' => true]) }}"><i class="fa fa-eye"></i></a>
                                            @else
                                                <a href="{{ route('produit.show', ['id' => $data->id]) }}"><i class="fa fa-eye"></i></a>
                                            @endif

                                        </td>
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

@stop