<form id="form-cobros" action="cobros.php" class="form-horizontal" method="post" enctype="multipart/form-data">
<div id="form-create-cobros" class="box-body">
        <input type="hidden" id="action_type" name="action_type" value="CREATE">
        <div class="form-group">
            <label for="p_name" class="col-sm-3 control-label">NOMBRE<i class="required">*</i></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo isset($request->post['p_name']) ? $request->post['p_name'] : null; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="p_name" class="col-sm-3 control-label">MONTO<i class="required">*</i></label>
            <div class="col-sm-7">
              <input type="number" class="form-control" name="monto" id="monto" value="<?php echo isset($request->post['p_name']) ? $request->post['p_name'] : null; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="p_name" class="col-sm-3 control-label">FECHA<i class="required">*</i></label>
            <div class="col-sm-7">
              <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo isset($request->post['p_name']) ? $request->post['p_name'] : null; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="p_name" class="col-sm-3 control-label">NOTAS DE VENTA<i class="required">*</i></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="nota_venta" id="nota_venta" value="<?php echo isset($request->post['p_name']) ? $request->post['p_name'] : null; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="p_name" class="col-sm-3 control-label">PROXIMO PAGO<i class="required">*</i></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="proximo_pago" id="proximo_pago" value="<?php echo isset($request->post['p_name']) ? $request->post['p_name'] : null; ?>" required>
            </div>
        </div>

        <div class="form-group">
      <label class="col-sm-3 control-label"></label>
      <div class="col-sm-7">
        <button class="btn btn-info" id="cobros-submit" type="submit" name="cobros-submit" data-form="#form-cobros" data-loading-text="Saving...">
          <span class="fa fa-fw fa-save"></span>
          <?php echo trans('button_save'); ?>
        </button> 
        <button type="reset" class="btn btn-danger" id="reset" name="reset"><span class="fa fa-fw fa-circle-o"></span>
          <?php echo trans('button_reset'); ?>
        </button>
      </div>
    </div>
</div>
</form>
        