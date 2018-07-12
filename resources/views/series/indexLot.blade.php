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
            <h4 class="mainTitle no-margin">Liste des lots</h4>

            <span class="mainDescription">Gestion des numéros de lots </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Lots</li>
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

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table  sample_5">
                                    <thead>
                                    <tr>
                                        <th class="col-xs-1">#</th>
                                        <th>No Lots</th>
                                        <th>Produit</th>
                                        <th class="col-xs-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $data->reference }}</td>
                                            <td>
                                                {{ $data->Produit()->first()->name }}
                                            </td>
                                            <td><a href="{{ route('lot.show', [$data->id]) }}"><i class="fa fa-eye"></i></a></td>
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
@stop

@section('footer')
    @parent

@stop