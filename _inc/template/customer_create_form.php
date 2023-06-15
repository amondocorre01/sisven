<!--MAP-->
<link rel="stylesheet" href="../assets/plugins/leaflet/leaflet.css" crossorigin="" />
<script src="../assets/plugins/leaflet/leaflet.js" crossorigin=""></script>

<form id="create-customer-form" class="form-horizontal" action="customer.php" method="post" enctype="multipart/form-data">
  <input type="hidden" id="action_type" name="action_type" value="CREATE">
  <div class="box-body">
    
    <div class="form-group">
      <label for="customer_name" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_name'), null); ?><i class="required">*</i>
      </label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="customer_name" value="<?php echo isset($request->post['customer_name']) ? $request->post['customer_name'] : null; ?>" name="customer_name" required>
      </div>
    </div>
    <div class="form-group">
      <label for="credit_balance" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_credit_balance'), null); ?>
      </label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="credit_balance" value="0" name="credit_balance" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='0';}">
      </div>
    </div>

    <div class="form-group">
      <label for="customer_mobile" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_phone'), null); ?>
      </label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="customer_mobile" value="<?php echo isset($request->post['customer_mobile']) ? $request->post['customer_mobile'] : null; ?>" name="customer_mobile">
      </div>
    </div>

    <div class="form-group">
      <label for="dob" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_date_of_birth'), null); ?>
      </label>
      <div class="col-sm-7">
        <input type="date" class="form-control" id="dob" value="<?php echo isset($request->post['dob']) ? $request->post['dob'] : null; ?>" name="dob" autocomplete="off">
      </div>
    </div>

    <div class="form-group">
      <label for="customer_email" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_email'), null); ?>
      </label>
      <div class="col-sm-7">
        <input type="email" class="form-control" id="customer_email" value="<?php echo unique_id(6);?>@gmail.com" name="customer_email">
      </div>
    </div>

    <div class="form-group">
      <label for="customer_sex" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_sex'), null); ?>
      </label>
      <div class="col-sm-7">
        <select id="customer_sex" name="customer_sex" class="form-control" required>
          <option value="1"<?php echo isset($request->post['customer_sex']) && $request->post['customer_sex'] == '1' ? ' selected' : null; ?>>
            <?php echo trans('label_male'); ?>
          </option>
          <option value="2"<?php echo isset($request->post['customer_sex']) && $request->post['customer_sex'] == '2' ? ' selected' : null; ?>>
            <?php echo trans('label_female'); ?>
          </option>
          <option value="3"<?php echo isset($request->post['customer_sex']) && $request->post['customer_sex'] == '3' ? ' selected' : null; ?>>
            <?php echo trans('label_others'); ?>
          </option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="customer_age" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_age'), null); ?>
      </label>
      <div class="col-sm-7">
        <input type="number" class="form-control" id="customer_age" value="<?php echo isset($request->post['customer_age']) ? $request->post['customer_age'] : null; ?>" name="customer_age" onKeyUp="if(this.value>140){this.value='140';}else if(this.value<0){this.value='0';}">
      </div>
    </div>

    <?php if (get_preference('invoice_view') == 'indian_gst') : ?>
    <div class="form-group">
      <label for="gtin" class="col-sm-3 control-label">
        <?php echo trans('label_gtin'); ?>
      </label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="gtin" value="" name="gtin">
      </div>
    </div>
    <?php endif;?>

    <div class="form-group">
      <label for="customer_address" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_address'), null); ?>
      </label>
      <div class="col-sm-7">
        <textarea class="form-control" id="customer_address" name="customer_address" value="<?php echo isset($request->post['customer_address']) ? $request->post['customer_address'] : null; ?>"></textarea>
      </div>
    </div>

    <div class="form-group">
      <label for="customer_city" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_city'), null); ?>
      </label>
      <div class="col-sm-7">
        <!--<input type="text" class="form-control" id="customer_city" value="<?php echo isset($request->post['customer_city']) ? $request->post['customer_city'] : null; ?>" name="customer_city">-->
        <select name="customer_city" id="customer_city">
          <option value="">Seleccione</option>
          <option value="1">Cochabamba</option>
          <option value="2">La Paz</option>
          <option value="3">Santa Cruz</option>
          <option value="4">Oruro</option>
          <option value="5">Potosi</option>
          <option value="6">Tarija</option>
          <option value="7">Chuquisaca</option>
          <option value="8">Beni</option>
          <option value="9">Pando</option>
          <option value="10">Otro</option>
        </select>
      </div>
    </div>

    <?php if (get_preference('invoice_view') == 'indian_gst') : ?>
    <div class="form-group">
      <label for="customer_state" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_state'), null); ?><i class="required">*</i>
      </label>
      <div class="col-sm-7">
        <?php echo stateSelector(isset($request->post['customer_state']) ? $request->post['customer_state'] : null, 'customer_state', 'customer_state'); ?>
      </div>
    </div>
    <?php else : ?>
      <div class="form-group">
        <label for="customer_state" class="col-sm-3 control-label">
          <?php //echo sprintf(trans('label_state'), null); ?>
          UBICACION GEOREFERENCIAL
        </label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="customer_state" value="<?php echo isset($request->post['customer_state']) ? $request->post['customer_state'] : null; ?>" name="customer_state">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-7 align-center">
          <div id="map" style="height: 30rem;"></div>
        </div>
      </div>
      <br>
    <?php endif; ?>

    <div class="form-group">
      <label for="country" class="col-sm-3 control-label">
        <?php echo trans('label_country'); ?>
      </label>
      <div class="col-sm-7">
        <?php echo countrySelector(isset($request->post['customer_country']) ? $request->post['customer_country'] : null, 'customer_country', 'customer_country'); ?>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">
        <?php echo trans('label_store'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-7 store-selector">
        <div class="checkbox selector">
          <label>
            <input type="checkbox" onclick="$('input[name*=\'customer_store\']').prop('checked', this.checked);"> Select / Deselect
          </label>
        </div>
        <div class="filter-searchbox">
          <input ng-model="search_store" class="form-control" type="text" id="search_store" placeholder="<?php echo trans('search'); ?>">
        </div>
        <div class="well well-sm store-well"> 
          <div filter-list="search_store">
          <?php foreach(get_stores() as $the_store) : ?>                    
            <div class="checkbox">
              <label>                         
                <input type="checkbox" name="customer_store[]" value="<?php echo $the_store['store_id']; ?>"<?php echo $the_store['store_id'] == store_id() ? ' checked' : null;?>>
                <?php echo $the_store['name']; ?>
              </label>
            </div>
          <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="status" class="col-sm-3 control-label">
        <?php echo trans('label_status'); ?>
      </label>
      <div class="col-sm-7">
        <select id="status" class="form-control" name="status" >
          <option <?php echo isset($request->post['status']) && $request->post['status'] == '1' ? 'selected' : null; ?> value="1">
            <?php echo trans('text_active'); ?>
          </option>
          <option <?php echo isset($request->post['status']) && $request->post['status'] == '0' ? 'selected' : null; ?> value="0">
            <?php echo trans('text_inactive'); ?>
          </option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="sort_order" class="col-sm-3 control-label">
        <?php echo sprintf(trans('label_sort_order'), null); ?>
      </label>
      <div class="col-sm-7">
        <input type="number" class="form-control" id="sort_order" value="<?php echo isset($request->post['sort_order']) ? $request->post['sort_order'] : 0; ?>" name="sort_order" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label"></label>
      <div class="col-sm-7">
        <button class="btn btn-info" id="create-customer-submit" type="submit" name="create-customer-submit" data-form="#create-customer-form" data-loading-text="Saving...">
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

<script>
  var map;
  var marker;
  $(document).ready(function () {
         var latitud = -17.414;
         var longitud = -66.1653;
         //map = L.map('map').setView([latitud, longitud], 16);
         var map = L.map('map').setView([51.505, -0.09], 13);

         L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
         }).addTo(map);
          map.on('click', onMapClick);
   });

   function onMapClick(e) {
    var lat = e.latlng.lat;
    var long = e.latlng.lng;
    if(marker != undefined) {
        map.removeLayer(marker);
    };
    marker = L.marker([lat, long],  {draggable: 'true'}).addTo(map);
    marker.on('dragend', function(event) {
          var position = marker.getLatLng();
          marker.setLatLng(position, {
          draggable: 'true'
          }).bindPopup(position).update();
    });
  };

  function onMarkerDragEnd(e) {
    var position = marker.getLatLng();
  }
</script>