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
			<h4 class="mainTitle no-margin">Précommande</h4>
            <span class="mainDescription">Gestion des précommandes </span>
			<ul class="pull-right breadcrumb">
			<li><a href="index.html"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Précommande</li>
			<li>Fiche</li>
			</ul>
		</div>
                                                <?php  if (Session::has('message')) { ?>
						<div id="system-message">
						<div class="alert alert-<?php echo session('type'); ?>">
						<a class="close" data-dismiss="alert"><i class="fa fa-close"></i></a>
						<div><p><?php echo session('message'); ?></p></div>
						</div>

						</div>
						<?php  } ?>

						<div class="container-fluid container-fullw ">
							<div class="row">
								<div class="col-md-12">
                                    @if(session()->has('ok'))
                                        <div class="alert alert-success alert-dismissible">
                                            <a class="close" data-dismiss="alert"><i class="fa fa-close"></i></a>
                                            {!! session('ok') !!}</div>
                                    @endif
									<div class="row">
										<div class="col-md-8">
											<div class="panel panel-white">
                                                <div class="panel-heading border-light">
                                                    <h4 class="panel-title">Toutes les infos la precommande N° <b>{{$item->numero}}</b> </h4>
                                                    <ul class="panel-heading-tabs border-light">
                                                        <li class="middle-center">
                                                            @if($item->statut==-1)
                                                                <span class="label label-default"> annulé</span>
                                                            @endif
                                                            @if($item->statut==2)
                                                                <span class="label label-info"> En cours</span>
                                                            @endif
                                                            @if($item->statut==0)
                                                                <span class="label label-danger"> refusé</span>
                                                            @endif
                                                            @if($item->statut==1)
                                                                <span class="label label-success"> Validé</span>
                                                            @endif
                                                        </li>
                                                        <li class="middle-center">
                                                            <div class="pull-right">

                                                                  @if($item->statut==2)
                                                                <div class="btn-group" dropdown="">
                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                        Tools <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                       
                                                                        <li>
                                                                            <a href="{{URL::to('precommandes/changestate/'.$item->id."/-1")}}"> Annuler </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{URL::to('precommandes/changestate/'.$item->id."/0")}}"> Refuser </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="<?= url('precommandes/validation', [$item->id]) ?>"> Valider </a>
                                                                        </li>
                                                                        
                                                                     
                                                                    </ul>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
												
												<div class="panel-body">


                                                                                                                                 <div class="row">
                                                                                                                                 <div class="col-lg-12 col-md-12">
                                                                                                                                      <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Pos emetteur</label>
                                                                                                                                      <input type="text"   class="form-control" value="@if($item->id_point_de_vente_emetteur != null) {{ $item->posemetteur()->first()->libelle }} @endif" disabled="true" >
                                                                                                                                  </div>	
                                                                                                                                      <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Pos Destinataire</label>
                                                                                                                                      <input type="text"  class="form-control" value="@if($item->id_point_de_vente_destinataire != null) {{ $item->posdestinataire()->first()->libelle }} @endif" disabled="true" >
                                                                                                                                  </div>										
                                                                                                                                 <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Montant Versé</label>
                                                                                                                                      <input type="text"  class="form-control" value="{{$item->montantverse}}" disabled="true" >
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
                                                                                                    <input type="text"  id="email" name="email" class="form-control" value="{{date("jS F, Y", strtotime($item->created_at))}}" disabled="true" >
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label" for="name">Date dernière modification</label>
                                                                                                    <input type="text"  id="email" name="email" class="form-control" value="{{$item->updated_at}}" disabled="true" >
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label" for="name">Utilisateur émetteur</label>
                                                                                                    <input type="text"  id="email" name="email" class="form-control" value="{{$item->user()->first()->nom}} {{$item->user()->first()->prenom}}" disabled="true" >
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
                                                                                                        <th>Quantité</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                               <tbody>
                                                                                                @foreach ($item->produits as $data)

                                                                                                    <tr>
                                                                                                        <td>{{$data->libelle}}</td>
                                                                                                        <td>{{$data->pivot->qte}}</td>
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
	JavaScript

	<!--script src="assets/js/letter-icons.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/treetable.js"></script-->
	
    
@stop