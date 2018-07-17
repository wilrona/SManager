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
            <h4 class="mainTitle no-margin">Liste des series/lots</h4>

            <span class="mainDescription">Gestion des numéros de series/lots </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Series/lots</li>
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
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('serie.import') }}" class="btn btn-green btn-sm" style="margin-top: 9px;"><i class="fa fa-plus"></i> Importé </a>

                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table sample_5 serie">
                                    <thead>
                                    <tr>
                                        <th class="">#</th>
                                        <th class="col-xs-3">No Serie</th>
                                        <th class="col-xs-3">No Lot</th>
                                        <th class="col-xs-2">Produit</th>
                                        <th class="col-xs-2">Magasin</th>
                                        <th class="col-xs-1 no-sort">Type</th>
                                        <th class="col-xs-2"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>@if($data->type == 0) {{ $data->reference }} @else Aucun @endif</td>
                                            <td>
                                                @if($data->type == 1)
                                                    {{ $data->reference }} <br>
                                                    Qté du lot : {{ $data->SeriesLots()->whereHas('Magasins', function($q) use ($mags)
                                                    {
                                                            $q->whereIn('id', $mags);
                                                    })->count() }}
                                                @else
                                                    {{ $data->lot_id ? $data->Lot()->first()->reference : '' }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $data->Produit()->first()->name }}
                                            </td>
                                            <td>
                                                @foreach($data->Magasins()->get() as $mag)
                                                    @if(in_array($mag->id, $mags))
                                                        {{ $mag->name }}
                                                    @endif

                                                @endforeach
                                            </td>
                                            <td>@if($data->type == 1) Lot @else Série @endif</td>
                                            <td>
                                                @if($data->type == 0)<a href="{{ route('serie.show', [$data->id]) }}"><i class="fa fa-eye"></i></a>@endif
                                                @if($data->type == 1)<a href="{{ route('lot.show', [$data->id]) }}"><i class="fa fa-eye"></i></a>@endif
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
    </div>
@stop

@section('footer')
    @parent

    <script>
        $(document).ready(function() {

            oTable_5.api().init().aoColumnDefs = [{
                "aTargets" : [3, 4, 5],
                "bSortable": false
            }];
            oTable_5.api().columns().every( function () {
                var column = this;
                if(column.index() === 3 || column.index() === 4 || column.index() === 5){
                    var name = null;
                    name = column.index() === 3 ? 'Produit' : column.index() === 4 ? 'Magasin' : 'Type';

                    var select = $('<select class="form-control" style="width: 100%"><option value="">'+name+'</option></select>')
                        .appendTo( $(column.header()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                }

            } );

        } );
    </script>

@stop