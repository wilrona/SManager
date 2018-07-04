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
            <h4 class="mainTitle no-margin">Liste des Promotions</h4>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Promotions</li>
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
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Libelle</th>
                                    <th>Prix</th>
                                    <th>Produit</th>
                                    <th>Date fin</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                {{--success--}}

                                @foreach ($datas as $data)
                                    <tr @if($data->active) class="success" @endif>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->libelle }}</td>
                                        <td>
                                                {{ $data->prix_promo }}
                                        </td>
                                        <td>
                                            {{ $data->type_produit()->first()->libelle }}
                                        </td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($data->date_fin)) }}
                                        </td>
                                        <td><a href="{{ url('promotions/show', [$data->id]) }}"><i class="fa fa-eye"></i></a></td>
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