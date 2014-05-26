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
              <td class="left"><?php if ($sort == 't.talla_id') { ?>
                <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>">Código</a>
                <?php } else { ?>
                <a href="<?php echo $sort_code; ?>">Código</a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 't.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Nombre</a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>">Nombre</a>
                <?php } ?></td>

              <td class="left"><?php if ($sort == 't.type') { ?>
                <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>">Tipo</a>
                <?php } else { ?>
                <a href="<?php echo $sort_type; ?>">Tipo</a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.sort_order') { ?>
                <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>">Orden</a>
                <?php } else { ?>
                <a href="<?php echo $sort_sort_order; ?>">Orden</a>
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
              <td></td>
              <td align="right"><a onclick="filter();" class="button">Filtrar</a></td>
            </tr>
          <?php if ($tallas) { ?>
          <?php foreach ($tallas as $talla) { ?>
          <tr>
            <td><input type="checkbox" name="selected[]" value="<?php echo $talla['talla_id']; ?>" /></td>
            <td width="20"><?php echo $talla['talla_id'];?></td>
            <td class="left">
                <b><?php echo $talla['name']; ?></b>
            </td>
            <td><?php echo $talla['type'];?></td>
            <td><?php echo $talla['sort_order'];?></td>
            <td class="right"><?php foreach ($talla['action'] as $action) { ?>
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
  url = 'index.php?route=catalog/product_talla&token=<?php echo $token; ?>';
  
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
  </script>

<?php echo $footer; ?>