<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (rgpost("uninstall")) {
	check_admin_referer("uninstall", "gf_IranDargah_uninstall");
	self::uninstall();
	echo '<div class="updated fade" style="padding:20px;">' . __("درگاه با موفقیت غیرفعال شد و اطلاعات مربوط به آن نیز از بین رفت برای فعالسازی مجدد میتوانید از طریق افزونه های وردپرس اقدام نمایید .", "gravityformsIranDargah") . '</div>';

	return;
} else if (isset($_POST["gf_IranDargah_submit"])) {

	check_admin_referer("update", "gf_IranDargah_update");
	$settings = [
		"gname"        => rgpost('gf_IranDargah_gname'),
		"merchant_key" => rgpost('gf_IranDargah_merchant_key'),
		"sandbox"      => rgpost('gf_IranDargah_sandbox'),
	];
	update_option("gf_IranDargah_settings", array_map('sanitize_text_field', $settings));
	if (isset($_POST["gf_IranDargah_configured"])) {
		update_option("gf_IranDargah_configured", sanitize_text_field($_POST["gf_IranDargah_configured"]));
	} else {
		delete_option("gf_IranDargah_configured");
	}
} else {
	$settings = get_option("gf_IranDargah_settings");
}

if (!empty($_POST)) {
	echo '<div class="updated fade" style="padding:6px">' . __("تنظیمات ذخیره شدند .", "gravityformsIranDargah") . '</div>';
} else if (isset($_GET['subview']) && $_GET['subview'] == 'gf_IranDargah' && isset($_GET['updated'])) {
	echo '<div class="updated fade" style="padding:6px">' . __("تنظیمات ذخیره شدند .", "gravityformsIranDargah") . '</div>';
}
?>

<form action="" method="post">
	<?php wp_nonce_field("update", "gf_IranDargah_update") ?>
	<h3>
		<span>
			<i class="fa fa-credit-card"></i>
			<?php _e("تنظیمات ایران درگاه", "gravityformsIranDargah") ?>
		</span>
	</h3>
	<table class="form-table">
		<tr>
			<th scope="row"><label
					for="gf_IranDargah_configured"><?php _e("فعالسازی", "gravityformsIranDargah"); ?></label>
			</th>
			<td>
				<input type="checkbox" name="gf_IranDargah_configured"
					   id="gf_IranDargah_configured" <?php echo get_option("gf_IranDargah_configured") ? "checked='checked'" : "" ?>/>
				<label class="inline"
					   for="gf_IranDargah_configured"><?php _e("بله", "gravityformsIranDargah"); ?></label>
			</td>
		</tr>
		<?php
		$gateway_title = __("IranDargah", "gravityformsIranDargah");
		if (sanitize_text_field(rgar($settings, 'gname'))) {
			$gateway_title = sanitize_text_field($settings["gname"]);
		}
		?>
		<tr>
			<th scope="row">
				<label for="gf_IranDargah_gname">
					<?php _e("عنوان", "gravityformsIranDargah"); ?>
					<?php gform_tooltip('gateway_name') ?>
				</label>
			</th>
			<td>
				<input style="width:350px;" type="text" id="gf_IranDargah_gname" name="gf_IranDargah_gname"
					   value="<?php echo $gateway_title; ?>"/>
			</td>
		</tr>
		<tr>
			<th scope="row"><label
					for="gf_IranDargah_sandbox"><?php _e("سندباکس", "gravityformsIranDargah"); ?></label>
			</th>
			<td>
				<input type="checkbox" name="gf_IranDargah_sandbox"
					   id="gf_IranDargah_sandbox" <?php echo rgar($settings, 'sandbox') ? "checked='checked'" : "" ?>/>
				<label class="inline"
					   for="gf_IranDargah_sandbox"><?php _e("بله", "gravityformsIranDargah"); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label
					for="gf_IranDargah_merchant_key"><?php _e("مرچنت کد", "gravityformsIranDargah"); ?></label></th>
			<td>
				<input style="width:350px;text-align:left;direction:ltr !important" type="text"
					   id="gf_IranDargah_merchant_key" name="gf_IranDargah_merchant_key"
					   value="<?php echo sanitize_text_field(rgar($settings, 'merchant_key')) ?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input style="font-family:tahoma !important;" type="submit"
								   name="gf_IranDargah_submit" class="button-primary"
								   value="<?php _e("ذخیره تنظیمات", "gravityformsIranDargah") ?>"/></td>
		</tr>
	</table>
</form>
<form action="" method="post">
	<?php
	wp_nonce_field("uninstall", "gf_IranDargah_uninstall");
	if (self::has_access("gravityforms_IranDargah_uninstall")) {
		?>
		<div class="hr-divider"></div>
		<div class="delete-alert alert_red">
			<h3>
				<i class="fa fa-exclamation-triangle gf_invalid"></i>
				<?php _e("غیرفعال‌سازی افزونه درگاه پرداخت ایران درگاه", "gravityformsIranDargah"); ?>
			</h3>
			<div
				class="gf_delete_notice"><?php _e("تذکر: بعد از غیرفعال‌سازی تمامی اطلاعات مربوط به ایران درگاه حذف خواهد شد", "gravityformsIranDargah") ?></div>
			<?php
			$uninstall_button = '<input  style="font-family:tahoma !important;" type="submit" name="uninstall" value="' . __("غیرفعال‌سازی ایران درگاه", "gravityformsIranDargah") . '" class="button" onclick="return confirm(\'' . __("تذکر : بعد از غیرفعال‌سازی تمامی اطلاعات مربوط به IranDargah حذف خواهد شد . آیا همچنان مایل به غیرفعال‌سازی می‌باشید؟", "gravityformsIranDargah") . '\');"/>';
			echo apply_filters("gform_IranDargah_uninstall_button", $uninstall_button);
			?>
		</div>
	<?php } ?>
</form>