<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
   
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> Colores</h1>
      <div class="buttons">
        <a onclick="location = '<?php echo $insert; ?>'" class="button"><span>Insertar</span></a>
        <a onclick="$('form').submit();" class="button"><span>Eliminar</span></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">

      <table class="list display" id="datatable">
        <thead>
          <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'c.code') { ?>
                <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>">Código</a>
                <?php } else { ?>
                <a href="<?php echo $sort_code; ?>">Código</a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Nombre</a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>">Nombre</a>
                <?php } ?></td>
              <td class="left"></td>
              <td class="left"><?php if ($sort == 'c.manufacturer_id') { ?>
                <a href="<?php echo $sort_manufacturer_id; ?>" class="<?php echo strtolower($order); ?>">Marca</a>
                <?php } else { ?>
                <a href="<?php echo $sort_manufacturer_id; ?>">Marca</a>
                <?php } ?></td>
              <td class="right">Acciones</td>
          </tr>
        </thead>
        <tbody>
           <tr class="filter">
              <td></td>
              <td width="20"><input type="text" name="filter_code" value="<?php echo $filter_code; ?>" /></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <td></td>
              <td align="left">
                <select name="filter_manufacturer_id">
                  <option value="">Seleccione</option>
                  <?php foreach ($manufacturers as $key => $value) { ?>
                    <?php if($filter_manufacturer_id == $value['manufacturer_id']) : ?>
                      <option value="<?php echo $value['manufacturer_id'];?>" selected="selected"><?php echo $value['name'];?></option>
                    <?php else : ?>
                      <option value="<?php echo $value['manufacturer_id'];?>"><?php echo $value['name'];?></option>
                    <?php endif; ?>
                  <?php } ?>
                </select>
              </td>
              <td align="right"><a onclick="filter();" class="button">Filtrar</a></td>
            </tr>
          <?php if ($colores) { ?>
          <?php foreach ($colores as $color) { ?>
          <tr>
            <td><input type="checkbox" name="selected[]" value="<?php echo $color['code']; ?>" /></td>
            <td width="20"><?php echo $color['code'];?></td>
            <td class="left">
                <b><?php echo $color['name']; ?></b>
            </td>
            <td class="left"><img src="<?php echo $color['image']; ?>" /></td>
            <td><?php echo $color['manufacturer_name'];?></td>
            <td class="right"><?php foreach ($color['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6">No hay resultados!</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>


<script type="text/javascript">
function filter() {
  url = 'index.php?route=catalog/product_color&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  var filter_code = $('input[name=\'filter_code\']').attr('value');
  
  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }
  
  var filter_manufacturer_id = $('select[name=\'filter_manufacturer_id\']').attr('value');
  
  if (filter_manufacturer_id) {
    url += '&filter_manufacturer_id=' + encodeURIComponent(filter_manufacturer_id);
  }
  
  location = url;
}
</script> 
  <script type="text/javascript">
    $(document).ready(function(){
    	$('#product').sortable({
    		axis: 'y',
    		forcePlaceholderSize: true,
    		placeholder: 'group_move_placeholder',
    		stop: function(event, ui)
    		{
    			$('#product input[name$="[sort_order]"]').each(function(i)
    			{
    				$(this).val(i);
    			});			
    		}
    	});
    });
    // $(document).ready(function() {
    //     $('#datatable').dataTable({"iDisplayLength": 25});
    // });
  </script>

<?php echo $footer; ?>