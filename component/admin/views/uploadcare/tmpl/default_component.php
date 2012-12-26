<?php
defined('_JEXEC') or die('Restricted access');
error_reporting(E_ERROR);
?>
<?php
include dirname(__FILE__).'/../../../uploadcare-php/uploadcare/lib/5.2/Uploadcare.php';
jimport('joomla.application.component.helper');
$public_key = JComponentHelper::getParams('com_uploadcare')->get('publickey');
$secret_key = JComponentHelper::getParams('com_uploadcare')->get('secretkey');
if (!$public_key || !$secret_key) {
	print 'Set publickey and secretkey options. Follow "Components" -> "Uploadcare" -> "Options"';die();
}
$api = new Uploadcare_Api($public_key, $secret_key);
	
$type = 'uploadcare';

//POST
$file = null;
$scale_crop_default_width = 800;
$scale_crop_default_height = 634;
if ($_POST['save']) {
	$file_id = $_POST['file_id'];
	$file = $api->getFile($file_id);
	$file->scaleCrop($scale_crop_default_width, $scale_crop_default_height);
	$file->op('stretch/off');
	$file->store();

	$data = new stdClass();
	$data->id = null;
	$data->file_id = $file_id;

	$db = JFactory::getDBO();
	$db->insertObject('#__uploadcare', $data);

	var_dump($result);
}
if ($_GET['file_id']) {
	$file_id = $_GET['file_id'];
	$file = $api->getFile($file_id);
	$file->scaleCrop($scale_crop_default_width, $scale_crop_default_height);
	$file->op('stretch/off');
	$file->store();
}
$is_insert = false;
$is_preview = false;
if ($_POST['insert'] or $_POST['_preview']) {
	$file_id = $_POST['file_id'];
	$file = $api->getFile($file_id);
	$original = clone $file;

	if ($_POST['op_type'] == 'crop') {
		$crop_width = $_POST['crop_width'];
		$crop_height = $_POST['crop_height'];
		$crop_center = isset($_POST['crop_center']) ? true : false;
		$crop_fill_color = $_POST['crop_fill_color'];
		if ($crop_width && $crop_height) {
			$file = $file->crop($crop_width, $crop_height, $crop_center, $crop_fill_color);
		}
	}

	if ($_POST['op_type'] == 'resize') {
		$resize_width = $_POST['resize_width'];
		$resize_height = $_POST['resize_height'];
		if ($resize_width || $resize_height) {
			$file = $file->resize($resize_width, $resize_height);
		}
	}

	if ($_POST['op_type'] == 'scale_crop') {
		$scale_crop_width = $_POST['scale_crop_width'];
		$scale_crop_height = $_POST['scale_crop_height'];
		$scale_crop_center = isset($_POST['scale_crop_center']) ? true : false;
		$file = $file->scaleCrop($scale_crop_width, $scale_crop_height, $scale_crop_center);
	} else {
		$scale_crop_width = $scale_crop_default_width;
		$scale_crop_height = $scale_crop_default_height;
		$scale_crop_center = false;
	}

	if (isset($_POST['effect_flip'])) {
		$file = $file->effect('flip');
	}

	if (isset($_POST['effect_grayscale'])) {
		$file = $file->effect('grayscale');
	}

	if (isset($_POST['effect_invert'])) {
		$file = $file->effect('invert');
	}

	if (isset($_POST['effect_mirror'])) {
		$file = $file->effect('mirror');
	}

	if (isset($_POST['stretch_off'])) {
		$file->op('stretch/off');
	}

	$is_insert = true;

	if ($_POST['_preview']) {
		$is_insert = false;
		$is_preview = true;
	}
}

?>
<?php if ($is_preview): ?>
<?php echo $file->getImgTag($file->data['original_filename']); ?>
<?php die();?>
<?php endif;?>
<?php if ($is_insert): ?>
<script type="text/javascript">
/* <![CDATA[ */
window.parent.jInsertEditorText('<a href=\"<?php echo $original->getUrl($file->data['original_filename']); ?>\"><img src=\"<?php echo $file->getUrl($file->data['original_filename']); ?>\" alt=\"\" /></a>', '<?php echo $_REQUEST['e_name']; ?>');
window.parent.SqueezeBox.close();
/* ]]> */
</script>
<?php die();?>
<?php endif;?>

<?php if ($file): ?>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<div id="media-items">
	<div class="media-item">
		<form enctype="multipart/form-data" method="post" action=""
			id="<?php echo $type; ?>-form">
		  <input type="hidden" name="e_name" value="<?php echo $_REQUEST['e_name']; ?>" />
			<input type="hidden" name="file_id" id="file_id"
				value="<?php echo $file_id; ?>" />


			<table class="slidetoggle describe startclosed"
				style="display: table;">
				<thead class="media-item-info">
					<tr>
						<td colspan="2">
							<p>
								<strong>File name:</strong>
								<?php echo $file->data['original_filename']; ?>
							</p>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr align="left">
						<td colspan="2"><input type="radio" name="op_type" id="resize"
							value="resize" />&nbsp;<strong><label for="resize">Resize</label>
						</strong></td>
					</tr>
					<tr align="left">
						<th class="label"><label for="resize_width">Width:</label></th>
						<td><input type="text" name="resize_width" id="resize_width" /></td>
					</tr>
					<tr align="left">
						<th class="label"><label for="resize_height">Height:</label></th>
						<td><input type="text" name="resize_height" id="resize_height" />
						</td>
					</tr>

					<tr align="left">
						<td colspan="2"><input type="radio" name="op_type"
							checked="checked" id="scale_crop" value="scale_crop" />&nbsp;<strong><label
								for="scale_crop">Scale crop</label> </strong></td>
					</tr>
					<tr align="left">
						<th class="label"><label for="scale_crop_width">Width:</label></th>
						<td><input type="text" name="scale_crop_width"
							id="scale_crop_width"
							value="<?php echo $scale_crop_default_width;?>" /></td>
					</tr>
					<tr align="left">
						<th class="label"><label for="scale_crop_height">Height:</label></th>
						<td><input type="text" name="scale_crop_height"
							id="scale_crop_height"
							value="<?php echo $scale_crop_default_height; ?>" /></td>
					</tr>
					<tr align="left">
						<th class="label"><label for="scale_crop_center">Center:</label></th>
						<td><input type="checkbox" name="scale_crop_center"
							id="scale_crop_center" checked="checked" /></td>
					</tr>

					<tr align="left">
						<td colspan="2"><strong>Effects</strong></td>
					</tr>
					<tr align="left">
						<th class="label" colspan="2"><input type="checkbox"
							name="effect_flip" id="effect_flip" />&nbsp;<label
							for="effect_flip">Flip</label></th>
					</tr>
					<tr align="left">
						<th class="label" colspan="2"><input type="checkbox"
							name="effect_grayscale" id="effect_grayscale" />&nbsp;<label
							for="effect_grayscale">Grayscale</label></th>
					</tr>
					<tr align="left">
						<th class="label" colspan="2"><input type="checkbox"
							name="effect_invert" id="effect_invert" />&nbsp;<label
							for="effect_invert">Invert</label></th>
					</tr>
					<tr align="left">
						<th class="label" colspan="2"><input type="checkbox"
							name="effect_mirror" id="effect_mirror" />&nbsp;<label
							for="effect_mirror">Mirror</label></th>
					</tr>
					<tr align="left">
						<th class="label" colspan="2"><input type="checkbox"
							name="stretch_off" id="stretch_off" checked="checked" />&nbsp;<label
							for="stretch">Stretch Off?</label></th>
					</tr>


					<tr valign="top">
						<td class="A1B1" colspan="2">
							<p>
								<strong>Preview:</strong>
							</p>
							<div id="uploadcare_preview"
								style="width: 600px; overflow-x: scroll;">
								<?php echo $file->getImgTag($file->data['original_filename']); ?>
							</div>
						</td>
					</tr>

				</tbody>
			</table>
			<input type="submit" value="Insert" class="button" name="insert" />
		</form>
	</div>
</div>
<script type="text/javascript">
jQuery(function() {
	jQuery('#<?php echo $type; ?>-form :input').change(function() {
		var form = jQuery('#<?php echo $type; ?>-form');

		/*error check*/
		if (jQuery('#resize').attr('checked')) {
			if (!jQuery('#resize_width').val()) {
				jQuery('#resize_width').css('border', '1px solid red');
			} else {
				jQuery('#resize_width').css('border', 'none');
			}
			if (!jQuery('#resize_height').val()) {
				jQuery('#resize_height').css('border', '1px solid red');
			} else {
				jQuery('#resize_height').css('border', 'none');
			}
			if (jQuery('#resize_height').val() || jQuery('#resize_width').val()) {
				jQuery('#resize_width').css('border', 'none');
				jQuery('#resize_height').css('border', 'none');
			}
		}
		if (jQuery('#scale_crop').attr('checked')) {
			if (!jQuery('#scale_crop_width').val()) {
				jQuery('#scale_crop_width').css('border', '1px solid red');
			} else {
				jQuery('#scale_crop_width').css('border', 'none');
			}
			if (!jQuery('#scale_crop_height').val()) {
				jQuery('#scale_crop_height').css('border', '1px solid red');
			} else {
				jQuery('#scale_crop_height').css('border', 'none');
			}
		}
		
		var data = form.serialize();
		data += '&_preview=true';
		jQuery.post(
				form.attr('action'),
				data,
				function (html) {
					jQuery('#uploadcare_preview').html(html);
				}
		);
		return false;
	});

	jQuery('#resize').click(function() {
		if (jQuery('#resize').attr('checked')) {
			jQuery('#scale_crop').removeAttr('checked');
			jQuery('#scale_crop_width').val('');
			jQuery('#scale_crop_height').val('');
			jQuery('#scale_crop_center').removeAttr('checked');
			jQuery('#scale_crop_width').css('border', '');
			jQuery('#scale_crop_height').css('border', '');			
		}
	});

	jQuery('#scale_crop').click(function() {
		if (jQuery('#scale_crop').attr('checked')) {
			jQuery('#resize').removeAttr('checked', '');
			jQuery('#resize_width').val('');
			jQuery('#resize_height').val('');
			jQuery('#resize_width').css('border', '');
			jQuery('#resize_height').css('border', '');
		}
	});
	
});
</script>
<?php else: ?>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<?php echo $api->widget->getScriptTag(); ?>
<form enctype="multipart/form-data" method="post" action="" class=""
	id="<?php echo $type; ?>-form">
	<input type="hidden" name="e_name" value="<?php echo $_REQUEST['e_name']; ?>" />
	<h3 class="media-title">Use Uploadcare widget to upload file.</h3>
	<?php echo $api->widget->getInputTag('file_id'); ?>
	<p class="savebutton ml-submit" id="_uc_store" style="display: none;">
		<input type="submit" value="Store" class="button" name="save" />
	</p>
</form>

<script type="text/javascript">
jQuery(function() {
  checkValueChange = function() {
		var file_id = jQuery('#<?php echo $type; ?>-form input[name=file_id]').val();
		if (!file_id) {
			setTimeout('checkValueChange()', 250); 
		} else {
		  jQuery('#_uc_store').show();
		}
  }
  setTimeout('checkValueChange()', 250);
});
</script>
<?php endif; ?>