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
			<h4 class="mainTitle no-margin">Points de vente</h4>
			<span class="mainDescription">Ajouter  point de vente </span>
			<ul class="pull-right breadcrumb">
			<li><a href="index.html"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Point de vente</li>
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
									
									<div class="row">
										<div class="col-md-8">
											<div class="panel panel-white">
                                                <div class="panel-heading border-light">
                                                    <h4 class="panel-title">Toutes les infos sur le point de vente <b>{{$item->libelle}}</b> </h4>
                                                    <ul class="panel-heading-tabs border-light">
                                                        <li class="middle-center">
                                                            <div class="pull-right">
                                                                <div class="btn-group" dropdown="">
                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                        Tools <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        <li>
                                                                            <a href="<?= url('warehouses/edit', ['id' => $item->id]) ?>"><i class="fa fa-edit"></i> Editer </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{URL::to('warehouses/changestate/'.$item->id."/".$item->etat)}}">
                                                                                @if($item->etat==1)
                                                                                    <i class="fa fa-remove"></i>Désactiver
                                                                                @endif
                                                                                @if($item->etat==0)
                                                                                    <i class="fa fa-check"></i>Activer
                                                                                @endif
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
												
												<div class="panel-body">

                                                                                                               
                                                                                                                                

                                                                                                                                 {{ csrf_field() }}
                                                                                                                                 <div class="row">
                                                                                                                                 <div class="col-lg-12 col-md-12">
                                                                                                                                      <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Libelle</label>
                                                                                                                                      <input type="text"  id="libelle" name="libelle" class="form-control" value="{{$item->libelle}}" disabled="true" >
                                                                                                                                  </div>
                                                                                                                                      <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">adresse</label>
                                                                                                                                      <input type="text"  id="adresse" name="adresse" class="form-control" value="{{$item->adresse}}" disabled="true" >
                                                                                                                                  </div>	
                                                                                                                                      <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Téléphone</label>
                                                                                                                                      <input type="text"  id="phone" name="phone" class="form-control" value="{{$item->phone}}" disabled="true" >
                                                                                                                                  </div>										
                                                                                                                                 <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Email</label>
                                                                                                                                      <input type="text"  id="email" name="email" class="form-control" value="{{$item->email}}" disabled="true" >
                                                                                                                                  </div>
                                                                                                                                 <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Parent *</label>
                                                                                                                                      <input type="text"  disabled="true" class="form-control" value="<?php  if($item->parent_id!=null) { echo App\PointDeVente::find($item->id)->parent->libelle; }?>">
                                                                                                                                      
                                                                                                                                  </div>
                                                                                                                                  <div class="form-group">
                                                                                                                                      <label class="control-label" for="name">Ville</label>
                                                                                                                                      <input type="text"   class="form-control" value="{{$item->ville}}" disabled="true" >
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
                                                                                            </div>
                                                                                         </div>
                                                                                    </div>
                                                                                 </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                         <div class="panel panel-white">
											 <div class="panel-body"></div>
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