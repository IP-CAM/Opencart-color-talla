<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
        <!-- <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a> -->
        <a href="javascript:history.go(-1)" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <?php $option_value_row = 0 ; ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="option-value" class="form">
          <tr>
            <td>Nombre Opción</td>
            <td class="left">
                <input type="hidden" name="option_value_id" value="<?php echo $option_value_id; ?>" />
                <?php foreach ($languages as $language) { ?>
                <input type="text" name="option_value_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($option_description[$language['language_id']]) ? $option_description[$language['language_id']]['name'] : ''; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                <?php if (isset($error_option_value[$language['language_id']])) { ?>
                <span class="error"><?php echo $error_option_value[$language['language_id']]; ?></span>
                <?php } ?>
                <?php } ?></td>
          </tr> 
          <tr class="hidse">
            <td>Option ID</td>
            <td>
              <select name="option_id">
                <?php foreach ($option_list as $key => $value) { ?>
                  <?php if($option_id==$value['option_id']): ?>
                    <option value="<?php echo $value['option_id'];?>" selected="selected"><?php echo $value['name'];?></option>
                  <?php else: ?>
                    <option value="<?php echo $value['option_id'];?>"><?php echo $value['name'];?></option>
                  <?php endif; ?>
                <?php } ?>
              </select>

            </td>
          </tr>
          <tr>
            <td>image</td>
            <td class="left">
              <div class="image">
                  <img src="<?php echo $thumb; ?>" alt="" id="thumb" />
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="image"  />
                  <br />
                  <a onclick="image_upload('image', 'thumb');">Buscar</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');">Limpiar</a>
              </div>
            </td>
          </tr>
          <tr>
            <td>Orden</td>
            <td><input type="text" name="sort_order" value="<?php echo $sort_order;?>"/></td>
          </tr>

          <tr>
            <td>Código de Barras</td>
            <td><input type="text" name="barcode" value="<?php echo $barcode;?>"/></td>
          </tr>

          <tr>
            <td>SKU</td>
            <td><input type="text" name="sku" value="<?php echo $sku;?>" readonly="readonly"/></td>
          </tr>  

          <tr>
            <td>Color</td>
            <td>
                <input type="text" name="color_name" value="<?php echo isset($color_name['name'])?$color_name['name']:'';?>"/>
                <input type="hidden" name="color_id" value="<?php echo $color_id;?>"/>
            </td>
          </tr> 

          <tr>
            <td>Talla</td>
            <td>
                <input type="text" name="talla_name" value="<?php echo isset($talla_name['name'])?$talla_name['name']:'';?>"/>
                <input type="hidden" name="talla_id" value="<?php echo $talla_id;?>"/>
            </td>
          </tr> 

          <tr>
            <td>Producto</td>
            <td>
              <input type="text" name="product_name" value="<?php echo isset($product_name['name'])?$product_name['name']:'';?>"/>
              <input type="hidden" name="product_id" value="<?php echo $product_id;?>"/>
            </td>
          </tr>  

          <?php $option_value_row = 0; ?>
          <?php foreach ($option_values as $option_value) { ?>
          <tbody id="option-value-row<?php echo $option_value_row; ?>">
            <tr>
              <td class="left">
                <input type="hidden" name="[option_value_id]" value="<?php echo $option_value['option_value_id']; ?>" />
                <?php foreach ($languages as $language) { ?>
                <input type="text" name="[option_value_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($option_value['option_value_description'][$language['language_id']]) ? $option_value['option_value_description'][$language['language_id']]['name'] : ''; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                <?php if (isset($error_option_value[$option_value_row][$language['language_id']])) { ?>
                <span class="error"><?php echo $error_option_value[$option_value_row][$language['language_id']]; ?></span>
                <?php } ?>
                <?php } ?></td>
              <td class="left"><div class="image"><img src="<?php echo $option_value['thumb']; ?>" alt="" id="thumb<?php echo $option_value_row; ?>" />
                  <input type="hidden" name="[image]" value="<?php echo $option_value['image']; ?>" id="image<?php echo $option_value_row; ?>"  />
                  <br />
                  <a onclick="image_upload('image<?php echo $option_value_row; ?>', 'thumb<?php echo $option_value_row; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $option_value_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $option_value_row; ?>').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
              <td class="left"><?php echo $option_value['option_value_color_talla']['color_id']; ?></td>
              <td class="left"><?php echo $option_value['option_value_color_talla']['talla_id']; ?></td>
              <td class="left"><?php echo $option_value['option_value_color_talla']['barcode']; ?></td>
              <td class="right"><input type="text" name="[sort_order]" value="<?php echo $option_value['sort_order']; ?>" size="1" /></td>
              <td class="left">
                <a href="<?php echo $option_value['edit_option_href']; ?>" class="button">Editar</a>
                <a onclick="$('#option-value-row<?php echo $option_value_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a>
              </td>
            </tr>
          </tbody>
          <?php $option_value_row++; ?>
          <?php } ?>
        </table>
         
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          console.log(item);
          return {
            label: item.name,
            value: item.product_id,
            sku : item.sku
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'product_id\']').val(ui.item.value);
    $('input[name=\'product_name\']').val(ui.item.label);
    $('input[name=\'sku\']').val(ui.item.sku);
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});


$('input[name=\'color_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product_color/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.code
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'color_id\']').val(ui.item.value);
    $('input[name=\'color_name\']').val(ui.item.label);
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});


$('input[name=\'talla_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product_talla/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.talla_id
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'talla_id\']').val(ui.item.value);
    $('input[name=\'talla_name\']').val(ui.item.label);
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});

//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: 'Subir Imagen',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
          dataType: 'text',
          success: function(data) {
            $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: 800,
    height: 400,
    resizable: false,
    modal: false
  });
};
//--></script> 
<?php echo $footer; ?>