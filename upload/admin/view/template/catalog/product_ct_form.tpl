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
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><?php foreach ($languages as $language) { ?>
              <input type="text" name="option_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($option_description[$language['language_id']]) ? $option_description[$language['language_id']]['name'] : ''; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
              <?php } ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_type; ?></td>
            <td>
              <select name="type">
                <optgroup label="Color - Talla">
                <?php if ($type == 'select_ct') { ?>
                <option value="select_ct" selected><?php echo $text_select; ?></option>
                <?php } else { ?>
                <option value="select_ct"><?php echo $text_select; ?></option>
                <?php } ?>
                </optgroup>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
          </tr>
        </table>
        <table id="option-value" class="list">
          <thead>
            <tr>
              <td class="left"><span class="required">*</span> <?php echo $entry_option_value; ?></td>
              <td class="left"><?php echo $entry_image; ?></td>
              <td class="left">Color</td>
              <td class="left">Talla</td>
              <td class="left">Barcode</td>
              <td class="right"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $option_value_row = 0; ?>
          <?php foreach ($option_values as $option_value) { ?>
          <tbody id="option-value-row<?php echo $option_value_row; ?>">
            <tr>
              <td class="left"><input type="hidden" name="option_value[<?php echo $option_value_row; ?>][option_value_id]" value="<?php echo $option_value['option_value_id']; ?>" />
                <?php foreach ($languages as $language) { ?>
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                <b>
                <?php echo isset($option_value['option_value_description'][$language['language_id']]) ? $option_value['option_value_description'][$language['language_id']]['name'] : ''; ?>
                </b>
                <?php if (isset($error_option_value[$option_value_row][$language['language_id']])) { ?>
                <span class="error"><?php echo $error_option_value[$option_value_row][$language['language_id']]; ?></span>
                <?php } ?>
                <?php } ?></td>
              <td class="left"><img src="<?php echo $option_value['thumb']; ?>" alt="" id="thumb<?php echo $option_value_row; ?>" /></td>
              <td class="left"><?php echo $option_value['option_value_color_talla']['color_name']; ?></td>
              <td class="left"><?php echo $option_value['option_value_color_talla']['talla_id']; ?></td>
              <td class="left"><?php echo $option_value['option_value_color_talla']['barcode']; ?></td>
              <td class="right"><?php echo $option_value['sort_order']; ?></td>
              <td class="left">
                <a href="<?php echo $option_value['edit_option_href']; ?>" class="button">Editar</a>
                <a onclick="javascript:removeOption('<?php echo $option_value['option_value_id']; ?>', '<?php echo $option_value_row;?>');" class="button"><?php echo $button_remove; ?></a>
              </td>
            </tr>
          </tbody>
          <?php $option_value_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="6"></td>
              <td class="left"><a href="<?php echo $add_option;?>" class="button"><?php echo $button_add_option_value; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('select[name=\'type\']').bind('change', function() {
	if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this.value == 'image') {
		$('#option-value').show();
	} else {
		$('#option-value').hide();
	}
});

var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue() {
	html  = '<tbody id="option-value-row' + option_value_row + '">';
	html += '  <tr>';	
    html += '    <td class="left"><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value="" />';
	<?php foreach ($languages as $language) { ?>
	html += '<input type="text" name="option_value[' + option_value_row + '][option_value_description][<?php echo $language['language_id']; ?>][name]" value="" /> <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
    <?php } ?>
	html += '    </td>';
    html += '    <td class="left"><div class="image"><img src="<?php echo $no_image; ?>" alt="" id="thumb' + option_value_row + '" /><input type="hidden" name="option_value[' + option_value_row + '][image]" value="" id="image' + option_value_row + '" /><br /><a onclick="image_upload(\'image' + option_value_row + '\', \'thumb' + option_value_row + '\');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#thumb' + option_value_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + option_value_row + '\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a></div></td>';
	html += '    <td class="right"><input type="text" name="option_value[' + option_value_row + '][sort_order]" value="" size="1" /></td>';
	html += '    <td class="left"><a onclick="$(\'#option-value-row' + option_value_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#option-value tfoot').before(html);
	
	option_value_row++;
}
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
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


function removeOption(option_value_id, option_value_row){
  $.ajax({
    url: 'index.php?route=catalog/product_ct/delete_option&token=<?php echo $token; ?>&option_value_id=' + option_value_id,
    dataType: 'json',
    success: function(response) {
      if(response.status == 'OK'){
        $('#option-value-row'+option_value_row).remove();
      }
    }
  });
  console.log(option_value_id);
  console.log(option_value_row);
}
//--></script> 
<?php echo $footer; ?>