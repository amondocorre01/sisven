<?php 
ob_start();
session_start();
include '../_init.php';

// Redirect, If user is not logged in
if (!is_loggedin()) {
  redirect(root_url() . '/index.php?redirect_to=' . url());
}

// Redirect, If User has not Read Permission
if (user_group_id() != 1 && !has_permission('access', 'read_product')) {
	redirect(root_url() . '/'.ADMINDIRNAME.'/dashboard.php');
}

// Set Document Title
$document->setTitle(trans('title_product'));

// Add Script
$document->addScript('../assets/tinymce/tinymce.min.js');
$document->addScript('../assets/itsolution24/angular/controllers/CobrosController.js');

// Include Header and Footer
include("header.php"); 
include ("left_sidebar.php"); 
?>
<!-- Content Wrapper Start -->
<div class="content-wrapper" ng-controller="CobrosController">
  	<!-- Content Header Start -->
	<section class="content-header">
		<h1>
			COBROS
			<small>
				<?php echo store('name'); ?>	
			</small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php">
					<i class="fa fa-dashboard"></i> 
					<?php echo trans('text_dashboard'); ?>
				</a>
			</li>
			<li>
				<?php if (isset($request->get['location']) && $request->get['location']=='trash'): ?>
					<a href="cobros.php"><?php echo 'COBROS'; ?></a>	
				<?php else: ?>
					<?php echo 'COBROS'; ?>	
				<?php endif; ?>
			</li>
			<?php if (isset($request->get['location']) && $request->get['location']=='trash'): ?>
				<li class="active">
					<?php echo trans('text_trash'); ?>	
				</li>
			<?php endif; ?>
		</ol>
	</section>
  	<!-- Content Header End -->

	<!-- Content Start -->
	<section class="content">

		<?php if(DEMO) : ?>
	    <div class="box">
	      <div class="box-body">
	        <div class="alert alert-info mb-0">
	          <p><span class="fa fa-fw fa-info-circle"></span> <?php echo $demo_text; ?></p>
	        </div>
	      </div>
	    </div>
	    <?php endif; ?>
	    
    	<?php if (user_group_id() == 1 || has_permission('access', 'create_product')) : ?>
	    <div class="box box-info<?php echo create_box_state(); ?>">
	        <div class="box-header with-border">
				<h3 class="box-title">
					<span class="fa fa-fw fa-plus"></span> <?php echo sprintf(trans('text_add_new'), trans('text_product')); ?>
				</h3>
				<button  type="button" class="btn btn-box-tool add-new-btn" onclick="openFormCreate();" data-widget="collapse" data-collapse="true">
					<i class="fa <?php echo !create_box_state() ? 'fa-minus' : 'fa-plus'; ?>"></i>
				</button>
	        </div>

	        <?php if (isset($error_message)): ?>
	        	<div class="alert alert-danger">
					<p>
						<span class="fa fa-warning"></span> 
						<?php echo $error_message; ?>
					</p>
	        	</div>
	        <?php elseif (isset($success_message)): ?>
	          <div class="alert alert-success">
				<p>
					<span class="fa fa-check"></span> 
					<?php echo $success_message; ?>
				</p>
	          </div>
	        <?php endif; ?>

	        <!-- Include Product Form -->
	        <?php include('../_inc/template/cobros_create_form.php'); ?>

	    </div>
	    <?php endif; ?>

	    <div class="row">

		    <form action="product_bulk_action.php" method="post" enctype="multipart/form-data" id="product-list-form">
			    <div class="col-xs-12">
			        <div class="box box-success">
				        <div class="box-header">
				            <h3 class="box-title">
				            	<?php echo sprintf(trans('text_view_all'), trans('text_product')); ?>	
				            </h3>

				            <!--Box Tools End-->
				            <div class="box-tools pull-right">

				               <!-- Filter Product Supplier Wise -->
				               <?php //include('../_inc/template/partials/product_filter.php'); ?>

					            <!-- Trash Box -->
				                <div class="btn-group">
					                <a type="button" class="btn btn-danger" href="product.php?location=trash">
					                  	<span class="fa fa-trash"></span> 
					                  	<?php echo trans('button_trash'); ?> 
					                  	<i class="badge badge-warning" id="total-trash">
					                  		<?php echo total_trash_product(); ?>
					                  	</i>
					                </a>
				                </div>

				                <!-- Bulk Action -->
			                	<?php if (user_group_id() == 1 || has_permission('access', 'product_bulk_action')) : ?>
				                <div class="btn-group">
					                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
					                	<?php echo trans('button_bulk'); ?>
					                    <span class="caret"></span>
					                </button>
					                <ul class="dropdown-menu" role="menu">
					                	<?php if (user_group_id() == 1 || has_permission('access', 'delete_all_product')) : ?>
						                    <li>
						                    	<a id="delete-all" href="#" data-form="#product-list-form" data-loading-text="Deleting...">
						                    		<?php echo trans('button_delete_all'); ?>
						                    	</a>
						                    </li>
						                    <?php if(isset($request->get['location']) && $request->get['location'] == 'trash') : ?>
						                    <li>
						                    	<a id="restore-all" href="#" data-form="#product-list-form" data-datatable="cobros-list" data-loading-text="Restoring...">
						                      		<?php echo trans('button_restore_all'); ?>
						                    	</a>
						                    </li>
					                    <?php endif;?>
					                    <?php endif; ?>
					                 </ul>
				                </div>
					            <?php endif; ?>

				            </div>
				            <!--  Box Tools End-->

				        </div>
						<div class="box-body">
							<div class="table-responsive">
								<?php
									$print_columns = '1,2,3,4,5';
									if (user_group_id() != 1) {
										if (! has_permission('access', 'show_purchase_price')) {
											//$print_columns = str_replace('6', '', $print_columns);
										}
									}
									$hide_colums = "";
									if (user_group_id() != 1) {
										if (! has_permission('access', 'product_bulk_action')) {
											$hide_colums .= "0,";
										}
										if (! has_permission('access', 'delete_product')) {
											$hide_colums .= "6,";
										}
									}

								?>  
								<table id="cobros-list" class="table table-bordered table-striped table-hover" data-hide-colums="<?php echo $hide_colums; ?>" data-print-columns="<?php echo $print_columns;?>">
								    <thead>
								        <tr class="bg-gray">
								            <th class="w-5 product-head text-center">
								            	<input type="checkbox" onclick="$('input[name*=\'select\']').prop('checked', this.checked);">
								            </th>
								            <th class="w-5">
								            	Nombre
								            </th>
								            <th class="w-10">
								            	Monto
								            </th>
								            <th class="w-20">
								            	Fecha
								            </th>
								            <th class="w-15">
								            	Notas de venta
								            </th>
                                            <th class="w-15">
								            	Proximo pago
								            </th>
								            <th class="w-5">
								            	<?php echo trans('label_delete'); ?>
								            </th>
								        </tr>
								    </thead>
								</table>
							</div>
						</div>
			        </div>
			    </div>
			</form>
	    </div>

	</section>
  	<!-- Content end -->

</div>
<!--  Content Wrapper End -->

<script type="text/javascript">
$(document).ready(function() {
	storeApp.intiTinymce();
	$('#form-create-cobros').hide();
});

function openFormCreate(){
	if(esVisible($('#form-create-cobros'))){
		$('#form-create-cobros').hide();
	}else{
		$('#form-create-cobros').show();
	}

}
/*$('#cobros-submit').on('click', function(e){
	console.log('registrando');
	e.preventDefault();
	let nombre = $('#nombre').val();
	let monto = $('#monto').val();
	let fecha = $('#fecha').val();
	let nota_venta = $('#nota_venta').val();
	let proximo_pago = $('#proximo_pago').val();
	if(nombre.trim() != '' && monto.trim() != '' && fecha.trim() != '' && nota_venta != '' && proximo_pago != ''){
		var $tag = $(this);
        var $btn = $tag.button("loading");
        var form = $($tag.data("form"));
        form.find(".alert").remove();
        var actionUrl = form.attr("action");
        
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize()+'&description='+tinymce.activeEditor.getContent(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            
            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = response.data.msg;
            window.toastr.success(alertMsg, "Success!");

            productId = response.data.id;
            
            dt.DataTable().ajax.reload(function(json) {
                if ($("#row_"+productId).length) {
                    $("#row_"+productId).flash("yellow", 5000);
                }
            }, false);

            setTimeout(function() {
                // Reset form
                $("#reset").trigger("click");
                $("#category_id").val(null).trigger("change");
                $("#sup_id").val(null).trigger("change");
                $("#brand_id").val(null).trigger("change");
                $("#box_id").val(null).trigger("change");
                $("#unit_id").val(null).trigger("change");
                $("#random_num").val(null).trigger("click");
                $("#p_thumb img").attr("src", "../assets/itsolution24/img/noimage.jpg");
                $("#p_image").val("");
            }, 100);


        }, function(response) {

            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
		//$('#form-cobros').submit();
	}else{
		alert('Verifique los datos del formulario');
	}
});*/

function esVisible(elemento) {
    var esVisible = false;
    if ($(elemento).is(':visible') && $(elemento).css("visibility") != "hidden"
            && $(elemento).css("opacity") > 0) {
        esVisible = true;
    }
    return esVisible;
}


function confirmDelete(e){
	let iden = $(e).attr('iden');
		window.swal({
          title: "Eliminar!",
          text: "¿Estás seguro(a)?",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        .then(function (willDelete) {
            if (willDelete) {
				let url = 'http://localhost/sisven' + "/_inc/cobros.php";
				console.log('url',url);
				//let datos = {id_cobro:iden, action_type:'DELETE'};

				var datos = new FormData();
    			datos.append("id_cobro",iden);
				datos.append("action_type",'DELETE');
				$.ajax({
					url: url,
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success:function(respuesta){
						window.swal("success!", "Eliminado correctamente!", "success");
						$("#cobros-list").DataTable().ajax.reload( null, false);
					}
				});
            }
        });
}


</script>

<?php include ("footer.php"); ?>