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
			<span class="mainDescription">Gestion des points de vente </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Point de vente</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

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

                                        <div class="panel panel-white">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nom</th>
                                                        <th>Parent</th>
                                                        <th>Adresse</th>
                                                        <th>Téléphone</th>
                                                        <th>Email</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($datas as $data)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $data->libelle }}</td>
                                                            <td>@if($data->parent_id != null) {{ $data->parent()->first()->libelle }} @endif</td>
                                                            <td>{{ $data->adresse }}</td>
                                                            <td>{{ $data->phone }}</td>
                                                            <td>{{ $data->email }}</td>
                                                            <td><a href="{{ url('warehouses/show', [$data->id]) }}"><i class="fa fa-eye"></i></a></td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>

                                                {{ $datas->links() }}
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
	<!--script>
			jQuery(document).ready(function() {

				$(".edit").on("click", function() {
					edit=JSON.parse($(this).attr("id"));
					//console.log(edit.id);
					//console.log(edit);
					$("#id").val(edit.id);
					$("#adresse").val(edit.adresse);
					$("#libelle").val(edit.libelle);
					$("#phone").val(edit.phone);
					$("#email").val(edit.email);
					parent=edit.parent_id; 
					if(parent==null){
					   parent='0';
					}
					$('#parent_id option[value='+parent+']').attr('selected','selected');
                                    });
                                    
                                 $(".close").on("click", function() {
                                   $("#newstore")[0].reset(); 
                                 });
			});
	</script-->
    
@stop