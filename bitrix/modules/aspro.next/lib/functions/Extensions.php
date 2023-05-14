<? 
namespace Aspro\Next\Functions;
class Extensions extends \CNext{
    public static function register(){
		$arJSCoreConfig = [
			'dropdown-select' => [
				'js' => SITE_TEMPLATE_PATH.'/js/dropdown-select.min.js',
				'css' => SITE_TEMPLATE_PATH.'/css/dropdown-select.min.css',
                'rel' => [self::partnerName.'_menu-list'],
			],
            'menu-list' => [
				'css' => SITE_TEMPLATE_PATH.'/css/menu-list.min.css',
			],
		];

		foreach ($arJSCoreConfig as $ext => $arExt) {
			\CJSCore::RegisterExt(self::partnerName.'_'.$ext, array_merge($arExt, ['skip_core' => true]));
		}
	}

	public static function init($arExtensions){
		$arExtensions = is_array($arExtensions) ? $arExtensions : (array)$arExtensions;

		if($arExtensions){
			$arExtensions = array_map(function($ext){
				return strpos($ext, self::partnerName) !== false ? $ext : self::partnerName.'_'.$ext;
			}, $arExtensions);

			\CJSCore::Init($arExtensions);
		}
	}
}
?>