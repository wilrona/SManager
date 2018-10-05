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

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-12">
                    <?php  if (Session::has('message')) { ?>
                    <div id="system-message">
                        <div class="alert alert-<?php echo session('type'); ?>">
                            <a class="close" data-dismiss="alert"><i class="fa fa-close"></i></a>
                            <div><p><?php echo session('message'); ?></p></div>
                        </div>
                    </div>
                    <?php  } ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Information du point de vente</h3>
                                </div>

                                <div class="panel-body">
                                    <form role="form" id="newstore" method="post" action="{{URL::to('warehouses/store')}}">



                                         {{ csrf_field() }}
                                         <div class="row">
                                         <div class="col-lg-12 col-md-12">
                                              <div class="form-group">
                                              <label class="control-label" for="name">Libelle *</label>
                                              <input type="text"  id="libelle" name="libelle" class="form-control" value="@isset(($item)) {{$item->libelle}} @endisset">
                                              <input type="hidden"  id="id" name="id" class="form-control" value="@isset(($item)) {{$item->id}} @endisset">
                                              {!! $errors->first('libelle', '<span class="help-block"> <i class="ti-alert text-primary"></i>
                                               <span class="text-danger">  :message</span></span> ') !!}
                                          </div>
                                              <div class="form-group">
                                              <label class="control-label" for="name">adresse *</label>
                                              <input type="text"  id="adresse" name="adresse" class="form-control" value="@isset(($item)) {{$item->adresse}} @endisset">
                                              {!! $errors->first('adresse', '<span class="help-block"> <i class="ti-alert text-primary"></i>
                                               <span class="text-danger">  :message</span></span> ') !!}
                                          </div>
                                              <div class="form-group">
                                              <label class="control-label" for="name">Téléphone *</label>
                                              <input type="text"  id="phone" name="phone" class="form-control" value="@isset(($item)) {{$item->phone}} @endisset">
                                              {!! $errors->first('phone', '<span class="help-block"> <i class="ti-alert text-primary"></i>
                                               <span class="text-danger">  :message</span></span> ') !!}
                                          </div>
                                              <div class="form-group">
                                              <label class="control-label" for="name">Email *</label>
                                              <input type="email"  id="email" name="email" class="form-control" value="@isset(($item)) {{$item->email}} @endisset">
                                              {!! $errors->first('email', '<span class="help-block"> <i class="ti-alert text-primary"></i>
                                               <span class="text-danger">  :message</span></span> ') !!}
                                          </div>

                                              <div class="form-group">
                                              <label class="control-label" for="name">Ville *</label>
                                              <input type="text"  id="ville" name="ville" class="form-control" value="@isset(($item)) {{$item->ville}} @endisset">
                                              {!! $errors->first('ville', '<span class="help-block"> <i class="ti-alert text-primary"></i>
                                               <span class="text-danger">  :message</span></span> ') !!}
                                             </div>
                                              <div class="form-group">
                                              <label class="control-label" for="name">Parent *</label>
                                              <select id="parent_id" name="parent_id" class="cs-select cs-selector cs-skin-elastic">
                                                      <option value="0"  @isset(($item)) @if($item->parent_id == null) {{"selected"}} @endif @endisset  >Aucun parent</option>
                                                          @foreach($pos as $key => $value)
                                                      <option value="{{ $value->id }}"  @isset($item) @if ($item->parent_id == $value->id) {{"selected"}}  @endif @endisset >{{ $value->libelle }}</option>
                                                          @endforeach
                                              </select>
                                              {!! $errors->first('parent_id', '<span class="help-block"> <i class="ti-alert text-primary"></i>
                                               <span class="text-danger">  :message</span></span> ') !!}
                                               </div>
                                             @if(isset($item->id))
                                               <a href="<?= url('warehouses/show', [$item->id]) ?>" class="btn btn-o btn-wide btn-default pull-left">Retour</a>
                                             @endif
                                              <input type="submit"  value="Enregistrer" class="btn btn-primary pull-right">
                                            </div>
                                          </div>


                                   </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
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