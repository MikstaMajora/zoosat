<?
namespace Arturgolubev\Gmerchant;

class Ui {
	static function showRelationSelect($group, $key, $IBLOCK, $value = "", $emptyValue = "", $hideSkuProps = 0){
		$params = array();
		
		$arPictureProps = ['additional_image_link', 'additional_image_link_sku'];
		
		if(!in_array($key, $arPictureProps)){
			$params['hide_files'] = 1;
		}else{
			
		}
		
		?><select class="js-select-search" onChange="checkChangeParams(this);" name="XML_DATA[<? echo htmlspecialcharsbx($group)?>][<? echo htmlspecialcharsbx($key)?>]">
			<option value=""<? echo ($value == "" ? ' selected' : ''); ?>><?=(($emptyValue) ? $emptyValue : GetMessage('YANDEX_SKIP_PROP'))?></option>
			<?
			foreach ($IBLOCK['TEXT_FIELDS'] as $fieldname){
				?><option value="<?=$fieldname?>"<? echo ($value == $fieldname ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_SALE_FIELD_".$fieldname)?></option><?
			}
			if (!empty($IBLOCK['SALE_FIELDS'])){
				?><optgroup label="<? echo GetMessage('GOOGLE_PRODUCT_FIELDS')?>"><?
					foreach ($IBLOCK['SALE_FIELDS'] as $fieldname){
						?><option value="<?=$fieldname?>"<? echo ($value == $fieldname ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_SALE_FIELD_".$fieldname)?> [<?=str_replace(array("_SKU", "_MAIN"),'',$fieldname)?>]</option><?
					}
				?></optgroup><?
			}
			
			
			if (!empty($IBLOCK['PROPERTY'])){
				?><optgroup label="<? echo GetMessage('GOOGLE_PRODUCT_PROPS')?>"><?
				foreach ($IBLOCK['PROPERTY'] as $key => $arProp){
					if($params['hide_files'] && $arProp['PROPERTY_TYPE'] == 'F') continue;
					
					?><option value="<?=$arProp['ID']?>"<? echo ($value == $arProp['ID'] ? ' selected' : ''); ?>><?=htmlspecialcharsbx($arProp['NAME'])?> [<?=htmlspecialcharsbx($key)?>]</option><?
				}
				?></optgroup><?
			}
			
			if(!$hideSkuProps){
				if (!empty($IBLOCK['SALE_SKU_FIELDS'])){
					?><optgroup label="<? echo GetMessage('GOOGLE_SKU_FIELDS')?>"><?
					foreach ($IBLOCK['SALE_SKU_FIELDS'] as $fieldname){
						?><option value="<?=$fieldname?>"<? echo ($value == $fieldname ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_SALE_FIELD_".$fieldname)?> [<?=str_replace(array("_SKU", "_MAIN"),'',$fieldname)?>]</option><?
					}
					?></optgroup><?
				}
				if (!empty($IBLOCK['OFFERS_PROPERTY'])){
					?><optgroup label="<? echo GetMessage('GOOGLE_SKU_PROPS')?>"><?
					foreach ($IBLOCK['OFFERS_PROPERTY'] as $key => $arProp){
						if($params['hide_files'] && $arProp['PROPERTY_TYPE'] == 'F') continue;
						?><option value="<?=$arProp['ID']?>"<? echo ($value == $arProp['ID'] ? ' selected' : ''); ?>><?=htmlspecialcharsbx($arProp['NAME'])?> [<?=htmlspecialcharsbx($key)?>]</option><?
					}
					?></optgroup><?
				}
			}
		?></select><?
	}
	
	static function showRelationInput($group, $key, $IBLOCK, $value = "", $text_field_value) {
		?><input type="text" size="45" name="TEXT_FIELDS[<? echo htmlspecialcharsbx($group)?>][<? echo htmlspecialcharsbx($key)?>]" style="margin-top: 5px; <?=(($value == "TEXT_FIELD") ? '' : 'display:none;');?>" value="<?=$text_field_value?>"><?
	}
	
	static function appendFilterRow(&$IBLOCK, $intCount, $strParam, $strUnit)
	{
		return '<tr id="yandex_params_tbl_'.$intCount.'">
			<td style="text-align: left; border-bottom: 1px dotted #666; padding: 5px 0;" valign="top">'.self::_filterRowColName($IBLOCK, $intCount, $strParam).'</td>
			<td style="text-align: left; border-bottom: 1px dotted #666; padding: 5px 0;" valign="top">'.self::_filterRowColSymbol($IBLOCK, $intCount, $strParam).'</td>
			<td style="text-align: left; border-bottom: 1px dotted #666; padding: 5px 0;" valign="top">'.self::_filterRowColValue($IBLOCK, $intCount, $strParam).'</td>
		</tr>';
	}
	
	static function _filterRowColName(&$IBLOCK, $intCount, $value)
	{
		ob_start();
		self::__filterRowColName('PARAMS','ID_'.$intCount, $IBLOCK, $value);
		$strResult = ob_get_contents();
		ob_end_clean();
		return $strResult;
	}
		static function __filterRowColName($group, $key, $IBLOCK, $valueSaved = "")
		{
			$tmp = explode('|', $valueSaved);
			$value = $tmp[0];
			?>
			
			<select name="XML_DATA[<? echo htmlspecialcharsbx($group)?>][<? echo htmlspecialcharsbx($key)?>]" style="max-width: 550px;">
				<option value=""<? echo ($value == "" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_ELEMENTS_EMPTY");?></option>
				
				<?if(count($IBLOCK['FILTER_FIELDS'])):?>
					<optgroup label="<? echo GetMessage('GOOGLE_FILTER_ELEMENTS_FIELDS')?>">
					<?
					foreach ($IBLOCK['FILTER_FIELDS'] as $tmp)
					{
						if(is_array($tmp))
						{
							$field = $tmp["FILTER"];
							$name = $tmp["NAME"];
							$type = ($tmp["TYPE"]) ? ', '.$tmp["TYPE"] : '';
						}
						else
						{
							$field = $tmp;
							$name = GetMessage("AG_GM_FILTER_NAME_".$field);
							$type = (GetMessage("AG_GM_FILTER_TYPE_".$field)) ? ', '.GetMessage("AG_GM_FILTER_TYPE_".$field) : '';
						}
						
						?><option value="<?=$field?>"<? echo ($value == $field ? ' selected' : ''); ?>><?=htmlspecialcharsbx($name)?> [<?=htmlspecialcharsbx($field)?><?=$type?>]</option><?
					}
					?>
					</optgroup>
				<?endif;?>
				<optgroup label="<? echo GetMessage('GOOGLE_FILTER_ELEMENTS_PROPS')?>">
					<?
					foreach ($IBLOCK['PROPERTY'] as $key => $arProp)
					{
						if($arProp["PROPERTY_TYPE"] == 'F' || $arProp["USER_TYPE"] == 'map_yandex')
							continue;
						// echo '<pre>'; print_r($arProp); echo '</pre>';
						$subtext = ''; 
						if ($arProp["PROPERTY_TYPE"] == "L" && $arProp["USER_TYPE"] != "directory") $subtext .= GetMessage("GOOGLE_FILTER_PROPERTY_LIST");
						if ($arProp["PROPERTY_TYPE"] == "N") $subtext .= GetMessage("GOOGLE_FILTER_PROPERTY_NUMBER");
						if ($arProp["PROPERTY_TYPE"] == "S" && $arProp["USER_TYPE"] != "directory") $subtext .= GetMessage("GOOGLE_FILTER_PROPERTY_STRING");
						if ($arProp["USER_TYPE"] == "directory") $subtext .= GetMessage("GOOGLE_FILTER_PROPERTY_DIRECTORY");
						if ($arProp["LINK_IBLOCK_ID"] > 0) $subtext .= GetMessage("GOOGLE_FILTER_PROPERTY_IB_ELEMENT");
						if($subtext) $subtext = ', '.$subtext;
						
						?><option value="<?=$arProp['ID']?>"<? echo ($value == $arProp['ID'] ? ' selected' : ''); ?>><?=htmlspecialcharsbx($arProp['NAME'])?> [ID <?=htmlspecialcharsbx($key)?><?=$subtext?>]</option><?
					}
					?>
				</optgroup>
			</select><?
		}
	static function _filterRowColSymbol(&$IBLOCK, $intCount, $value)
	{
		ob_start();
		self::__filterRowColSymbol('PARAMS','ID_'.$intCount, $IBLOCK, $value);
		$strResult = ob_get_contents();
		ob_end_clean();
		return $strResult;
	}
		static function __filterRowColSymbol($group, $key, $IBLOCK, $valueSaved = "")
		{
			$tmp = explode('|', $valueSaved);
			$value = $tmp[1];
			?>
			<select name="XML_DATA[<? echo htmlspecialcharsbx($group)?>][<? echo htmlspecialcharsbx($key)?>_symbol]">
				<option value="equally" <? echo ($value == "" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_SYMBOL_EQUALL");?></option>
				<option value="noequally" <? echo ($value == "noequally" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_SYMBOL_NOEQUALL");?></option>
				<option value="empty" <? echo ($value == "empty" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_SYMBOL_EMPTY");?></option>
				<option value="noempty" <? echo ($value == "noempty" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_SYMBOL_NOEMPTY");?></option>
				<option value="like" <? echo ($value == "like" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_SYMBOL_LIKE");?></option>
				<option value="more" <? echo ($value == "more" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_SYMBOL_MORE");?></option>
				<option value="less" <? echo ($value == "less" ? ' selected' : ''); ?>><?=GetMessage("GOOGLE_FILTER_SYMBOL_LESS");?></option>
			</select>
			<?
		}
	static function _filterRowColValue(&$IBLOCK, $intCount, $value)
	{
		ob_start();
		self::__filterRowColValue('PARAMS','ID_'.$intCount, $IBLOCK, $value);
		$strResult = ob_get_contents();
		ob_end_clean();
		return $strResult;
	}
		static function __filterRowColValue($group, $key, $IBLOCK, $valueSaved = "")
		{
			// echo '<pre>'; print_r($valueSaved); echo '</pre>';
			$tmp = explode('|', $valueSaved);
			$value = explode(';', $tmp[2]);
			
			foreach($value as $k=>$val){
				if($val == '') unset($value[$k]);
			}
			
			if(count($value))
				$value = array_values($value);
			else
				$value = array("");
			
			foreach($value as $val):
				?><span style="white-space: nowrap">
					<input type="text" name="XML_DATA[<? echo htmlspecialcharsbx($group)?>][<? echo htmlspecialcharsbx($key)?>_value][]" value="<?=$val?>">
					<input type="button"  onClick="addOrField(this); return false;" value="<?=GetMessage("GOOGLE_FILTER_SYMBOL_OR");?>">
				</span><br><?
			endforeach;
		}
}