<?if(!check_bitrix_sessid()) return;?>

<?echo CAdminMessage::ShowNote(GetMessage("ARTURGOLUBEV_GMERCHANT_INSTALL_SUCCESS", array("#MOD_NAME#"=>GetMessage("arturgolubev.gmerchant_MODULE_NAME"))));?>

<h3><?=GetMessage("ARTURGOLUBEV_GMERCHANT_WHAT_DO");?></h3>

<?if(!CModule::IncludeModule('catalog') || !CModule::IncludeModule('sale')){?>
	<div class="adm-info-message-wrap adm-info-message-red">
		<div class="adm-info-message">
			<?=GetMessage("ARTURGOLUBEV_GMERCHANT_SALE_NOT_FOUND")?>
			<div class="adm-info-message-icon"></div>
		</div>
	</div>
<?}?>

<div><?=GetMessage("ARTURGOLUBEV_GMERCHANT_WHAT_DO_TEXT");?></div>