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
      <h1><img src="view/image/category.png" alt="" />Colores</h1>
      <div class="buttons">
      	<a onclick="$('#form').submit();" class="button"><span>Guardar</span></a>
      	<a onclick="location = '<?php echo $cancel; ?>';" class="button"><span>Cancelar</span></a>
      </div>
    </div>
    <div class="content">
      
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="form">
				<tbody>
					<tr>
						<td>Cod Color</td>
						<td><input type="text" value="<?php echo $code;?>" name="code"></td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td><input type="text" value="<?php echo $name;?>" name="name"></td>
					</tr>
					<tr>
						<td>Imagen</td>
						<td>
							<div class="image">
								<img src="<?php echo $thumb;?>" alt="" id="thumb"><br>
              					<input type="hidden" name="image" value="<?php echo $image; ?>" id="image">
              					<a onclick="image_upload('image', 'thumb');">Browse</a>&nbsp;&nbsp;|&nbsp;&nbsp;
              					<a onclick="$('#thumb').attr('src', '<?php echo $thumb;?>'); $('#image').attr('value', '');">Clear</a>
              				</div>
						</td>
					</tr>
					<tr>
						<td>Manufacturer</td>
						<td><input type="text" value="<?php echo $manufacturer_id;?>" name="manufacturer_id"></td>
					</tr>
				</tbody>
			</table>
		</form>
      
    </div>
  </div>
</div>


<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: 'Subir Imagen Color',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
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
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
    html  = '<tbody id="image-row' + image_row + '">';
	html += '  <tr>';
	
	html += '    <td class="left"><div class="image"><img src="<?php echo $no_image; ?>" alt="" id="thumb' + image_row + '" /><input type="hidden" name="album_image[' + image_row + '][image]" value="" id="image' + image_row + '" /><br /><a onclick="image_upload(\'image' + image_row + '\', \'thumb' + image_row + '\');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a><br/></div></td>';
	
	html += '    <td class="right"><input type="text" name="album_image[' + image_row + '][sort_order]" value="" size="2" /></td>';
	html += '    <td class="left"><a onclick="$(\'#image-row' + image_row  + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#images tfoot').before(html);
	
	image_row++;
}
//--></script> 
 
	
<?php echo $footer; ?>