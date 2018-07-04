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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Numéro</th>
                                        <th>Emetteur</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $data->numero }}</td>
                                            <td>
                                                {{ $data->pos_vendeur()->first()->libelle }}
                                            </td>
                                            <td><a href="{{ url('provisions/show', [$data->id, $page]) }}"><i class="fa fa-eye"></i></a></td>
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