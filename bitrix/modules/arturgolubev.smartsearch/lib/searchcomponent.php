<?
namespace Arturgolubev\Smartsearch;

use \Arturgolubev\Smartsearch\Unitools as Tools;

class SearchComponent {
	public $options = array(); 
	public $baseQuery = false; 
	public $query = false; 
	
	public function baseInit($q, $type = ''){
		$this->options['debug'] = Tools::getSetting('debug');
		
		$this->options['theme_class'] = Tools::getSetting('color_theme', 'blue');
		$this->options['theme_color'] = Tools::getSetting('my_color_theme');
		
		$this->options['use_clarify'] = (Tools::getSetting('clarify_section') == "Y");
		$this->options['use_guessplus'] = (Tools::getSetting("mode_guessplus") == "Y");
		
		if($type == 'page'){
			$this->options['mode'] = Tools::getSetting("mode_spage");
			$this->options['always_use_smart'] = (Tools::getSetting("use_with_standart") == 'Y' || Tools::getSetting("use_with_standart_page") == 'Y');
		}elseif($type == 'title'){
			$this->options['theme_placeholder'] = Tools::getSetting('input_search_placeholder');
			
			$this->options['mode'] = Tools::getSetting("mode_stitle");
			$this->options['always_use_smart'] = (Tools::getSetting("use_with_standart") == 'Y' || Tools::getSetting("use_with_standart_title") == 'Y');
		}
		
		if($q){
			$this->baseQuery = $q;
			
			foreach(GetModuleEvents(\CArturgolubevSmartsearch::MODULE_ID, "onBeforePrepareQuery", true) as $arEvent)
				ExecuteModuleEventEx($arEvent, array(&$q));
			
			$q = \CArturgolubevSmartsearch::checkReplaceRules($q);
			$q = \CArturgolubevSmartsearch::prepareQuery($q);
			$q = \CArturgolubevSmartsearch::clearExceptionsWords($q);
			
			$this->query = $q;
		}
	}
}