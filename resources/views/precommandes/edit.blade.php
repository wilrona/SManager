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
			<li>Fiche</li>
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
                                    <h3 class="panel-title">Effectuer une précommande</h3>
                                </div>

                                <div class="panel-body">
                                     {!! Form::open(['route' => 'precommande.store']) !!}
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-bold text-capitalize" for="name">Pos emetteur <a style="#" id="edit-pos"><i class="fa fa-edit"></i></a></label>
                                                            <!--input type="text" class="form-control" value="{{ $pos->libelle}}" disabled-->
                                                            <select class="form-control" id="posemetteur"  disabled>
                                                                <option value="0" selected>{{ $pos->libelle }}</option>
                                                                @isset(($pos->enfants)) 
                                                                @foreach($pos->enfants as $key => $value)  
                                                                <option value="{{ $value->id }}">{{ $value->libelle }}</option>
                                                                 @endforeach
                                                                 @endisset
                                                            </select>
                                                            <input type="hidden" id="posemetteur2" name="posemetteur"  class="form-control" value="0">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="text-bold text-capitalize" for="name">Pos destinataire </label>
                                                            <!--input type="text" id="posemetteur" name="posemetteur"  class="form-control" value="@if($pos->parent_id != null) {{ $pos->parent()->first()->libelle }} @endif" disabled>
                                                            <input type="text" id="posdest" name="posdest"  class="form-control" value="@if($pos->parent_id != null) {{ $pos->parent()->first()->libelle }} @endif" disabled-->
                                                            <select class="form-control" id="posdest"  disabled>
                                                                <option value="0" selected>@if($pos->parent_id != null) {{ $pos->parent()->first()->libelle }} @endif</option>
                                                                <option value="{{ $pos->id }}">{{ $pos->libelle }}</option>
                                                            </select>
                                                             <input type="hidden" id="posdest2" name="posdest"  class="form-control" value="0">
                                                        </div>
                                                        

                                                    </div>
                                                </div>

                                               
                                                    
                                                      
                                                      <div class="form-group {!! $errors->has('montantverse') ? 'has-error' : '' !!}">
                                                            <label for="montantverse" class="text-bold text-capitalize"> Montant Versé</label>
                                                            <input type="text" id="montantverse" name="montantverse" class="form-control"  value="0">
                                                           
                                                        </div>
                                    <div class="row">
                                        <div class="col-md-12 space20">
                                            <button class="btn btn-green" data-toggle="modal" data-target="#modalproduit" id="add">
                                                Ajouter un produit <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                                        <div class="table-responsive">
                                                            <table class="table" id="listproduit">
								<thead>
								   <tr>
															<!--th></th-->
                                                                     <th>Produit</th>
								     <th>Quantité</th>
															<!--th>Edit</th-->
								     <th></th>
								  </tr>
								</thead>
													<tbody>
                                                                                                         @isset(($produit)) 
                                                                                                            @foreach($produit as $key => $value)  
                                                                                                                <tr id={{$value}}>
															<!--th></th-->
                                                                                                                        <td>{{$libelle[$key]}}</td>
															<td>{{$qte[$key]}}</td>
															<!--th>Edit</th-->
															<td><a class="delete" onclick="remove({{$value}})"><i class="fa fa-trash"></i></a></td>
														</tr>
                                                                                                            @endforeach
                                                                                                            
                                                                                                         @endisset   
													</tbody>
												</table>
											</div>
										

                                                      
                                                             @if(isset($item->id))
                                                                <a href="<?= url('precommandes/show', [$item->id]) ?>" class="btn btn-o btn-wide btn-default pull-left">Retour</a>
                                                            @endif
                                                            @if($pos->parent_id != null)
                                                                {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                                                            @endif
                                                            {!! Form::close() !!}   
                                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
        </div>
						
		<!--/. ABOUT MODAL POPUP DIV-->
    <div class="modal fade" id="modalproduit" tabindex="-1" role="dialog" aria-labelledby="mService1" aria-hidden="true" >
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="mService1"> <i class="fa fa-plus"></i> Choisir un produit </h4>
	      </div>
	      <div class="modal-body">
		        <div class="mian-popup-body">
				<p id="resultlogin"></p>
                                <form id="formproduit" >
                                     {{ csrf_field() }}
                                     <div class="form-group">
                                         <label>Produit</label>
                                         <select id="prdt" class="form-control" name="prdt"> 
                                             @foreach($prdts as $key => $value)
                                             <option value="{{ $value->id}}">{{ $value->libelle}}</option>
                                              @endforeach
                                         </select>
                                     </div>
                                     <div class="form-group">
                                         <label>Quantité</label>
                                       
                                         <input id="qte" type="text" value="1" min="1" name="qte" touchspin data-verticalbuttons="true" data-verticalupclass="ti-angle-up" data-verticaldownclass="ti-angle-down" class="form-control">
                                     </div>
                                     <div class="form-actions " style="margin-top: 15PX; ">
                                          <input type="hidden"  class="form-control" name="libelle" id="libelle">
                                     <input type="button"  id="newproduit" class="btn btn-primary btn-block" value="Ajouter"/>
                                     </div>
                                </form>
		        </div>
	      </div>
	     
	    </div>
	  </div>
	</div>				
					
    </div>
@stop

@section('footer')
    @parent
<!-- start: JavaScript Event Handlers for this page -->

		<!-- end: JavaScript Event Handlers for this page -->
	<!--script src="assets/js/letter-icons.js"></script>
	<script src="assets/js/main.js"></script-->
	<script>
         var pos= <?php echo $pos->id;?>;
         var parent_pos= <?php echo $pos->parent_id;?>;
        // var child_pos= <?php echo $pos->enfants;?>;
         //////////////////////////////////////////////////
         var listeall= <?php echo $prdtsall;?>;
         var liste= <?php echo $prdts;?>; //$pos->enfants
       
         var value=[]; //array();
         var idx=[];
         /*alert(liste.length);*/
         if((liste.length==0)){
               $('#add').attr('disabled', true);
          }

         $('#add').on('click', function(e){
             e.preventDefault();
         });


        function remove(id){
            console.log(id);
            var p= listeall.find( d => d.id === id);
            console.log(p);
            $("#prdt").append("<option value="+p.id+">"+p.libelle+"</option>");
            $('#'+id).remove();
            
            var rowCount = $('#listproduit >tbody >tr').length;
            var rowOption = $('#prdt >option').length;
            
            //alert(rowCount+"  "+liste.length+"  "+rowOption);
            if((rowCount<liste.length)|| (liste.length>0) || (rowOption>0)){
               $('#add').attr('disabled', false); 
            }
           // alert(qte);
           
            
            
             var i=idx.findIndex(x => x.produit === id);
             //qte=; value[i]
             //qte = (typeof qte !== 'undefined') ? qte : value[i];
             idx.splice(i,1);
             value.splice(i,1);
             // alert(qte); //="0"
            
            
             $.ajax({
                type: 'get',
                url: "<?php echo URL::to('precommandes/destock');?>/"+id,
                //dataType: "json",
                       // data: "prdt="+id+"&qte="+qte, // prdt: idx, qte: value,
                success: function(response) {
                            console.log(response);
                }
             });
             
             
             /*idx.splice(i,1);
             value.splice(i,1);*/
        }
        
        $("#newproduit").on("click", function () { //{{URL::to('precommandes/stock')}}
            
           $("#libelle").val("");
            var idprdt= $("#prdt").val();
            var produit= $("#prdt  option:selected").text();
            $("#libelle").val(produit);
            var data=$('#formproduit').serialize();
            var qte= $("#qte").val(); 
            $("#listproduit > tbody").append("<tr id="+idprdt+"><td>"+produit+"</td><td>"+qte+"</td><td><a class='delete' onclick='remove("+idprdt+")'><i class='fa fa-trash'></i></a></td></tr>");
            $("#prdt option[value='"+idprdt+"']").remove();
            
            value.push(qte);
            idx.push(idprdt);
            
            var rowCount = $('#listproduit >tbody >tr').length;
           // alert(rowCount+" "+liste.length);
            
            if((rowCount>=liste.length) || (liste.length==0)){
               $('#add').attr('disabled', true); 
            }
            $('#modalproduit').modal('hide');
            
            //console.log(data);
            /*var data=[];
            data["prdt"]=idx;
            data["qte"]=value;
            data["_token"]="0000000000000000";*/
            //alert(data);
            $.ajax({
		type: 'Post',
		url: "<?php echo URL::to('precommandes/stock');?>",
		//dataType: "json",
                data: data, // prdt: idx, qte: value, 
		success: function(response) {
                   // console.log(response);
		}
	    });
           
            
           
           // console.log(data);
        });
        

        $("#posemetteur").change(function() {
            var posemetteur = $("#posemetteur").val();
            console.log(posemetteur);
            if(posemetteur=="0"){ //pos en cours
                //$("#posdest").val(posemetteur);
                //console.log("posemetteur 0");
                $('#posdest option').removeAttr('selected').filter('[value=0]').attr('selected', true);
                $("#posdest").val("0").change();
                $("#posdest2").val(0);
            }else{
                //$('#posdest option[value='+pos+']').attr('selected','selected');
                $('#posdest option').removeAttr('selected').filter('[value='+pos+']').attr('selected', true);
                //console.log(pos);
                 $("#posdest").val(pos).change();
                 $("#posdest2").val(pos);
            }
            $("#posemetteur2").val(posemetteur);
            $('#posemetteur').attr('disabled', true);
        });
        
        $("#edit-pos").on("click", function(){
            $('#posemetteur').removeAttr('disabled');
        });
        </script>
	
    
@stop