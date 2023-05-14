<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/search/classes/general/title.php");

use \Arturgolubev\Smartsearch\Unitools as UTools;

class CSearchTitleExt extends CAllSearchTitle
{
	function searchTitle($phrase = "", $nTopCount = 5, $arParams = array(), $bNotFilter = false, $order = "")
	{
		$extended_mode = (UTools::getSetting("mode_stitle") != 'standart');
	
		$DB = CDatabase::GetModuleConnection('search');
		$bOrderByRank = ($order == "rank");

		$arWords = array();
		
		$sqlHaving = array();
		$sqlWords = array();
		if (!empty($this->_arPhrase))
		{
			$last = true;
			foreach (array_reverse($this->_arPhrase, true) as $word => $pos)
			{
				$arWords[] = $word;
				
				if ($last && !preg_match("/[\\n\\r \\t]$/", $phrase))
				{
					$last = false;
					if (strlen($word) >= $this->minLength)
					{
						if($extended_mode)
							$s = $sqlWords[] = "ct.WORD like '%".$DB->ForSQL($word)."%'";
						else
							$s = $sqlWords[] = "ct.WORD like '".$DB->ForSQL($word)."%'";
					}
					else
						$s = "";
				}
				else
				{
					if($extended_mode)
						$s = $sqlWords[] = "ct.WORD like '%".$DB->ForSQL($word)."%'";
					else
						$s = $sqlWords[] = "ct.WORD = '".$DB->ForSQL($word)."'";
				}

				if ($s)
					$sqlHaving[] = "(sum(".$s.") > 0)";
			}
		}

		if (!empty($sqlWords))
		{
			$bIncSites = false;
			$strSqlWhere = CSearch::__PrepareFilter($arParams, $bIncSites);
			if ($bNotFilter)
			{
				if (!empty($strSqlWhere))
					$strSqlWhere = "NOT (".$strSqlWhere.")";
				else
					$strSqlWhere = "1=0";
			}

			/* $strSql = "
				SELECT
					sc.ID
					,sc.MODULE_ID
					,sc.ITEM_ID
					,sc.TITLE
					,sc.PARAM1
					,sc.PARAM2
					,sc.DATE_CHANGE
					,sc.URL as URL
					,sc.CUSTOM_RANK as CUSTOM_RANK
					,scsite.URL as SITE_URL
					,scsite.SITE_ID
					,if(locate('".$DB->ForSQL(ToUpper($phrase))."', upper(sc.TITLE)) > 0, 1, 0) RANK1
					,locate('".$DB->ForSQL(ToUpper($phrase))."', upper(sc.TITLE)) RANK2
					,min(ct.POS) RANK3
				FROM
					b_search_content_title ct
					inner join b_search_content sc on sc.ID = ct.SEARCH_CONTENT_ID
					INNER JOIN b_search_content_site scsite ON sc.ID = scsite.SEARCH_CONTENT_ID and ct.SITE_ID = scsite.SITE_ID
				WHERE
					".CSearch::CheckPermissions("sc.ID")."
					AND ct.SITE_ID = '".SITE_ID."'
					AND (".implode(" OR ", $sqlWords).")
					".(!empty($strSqlWhere)? "AND ".$strSqlWhere: "")."
				GROUP BY
					ID, MODULE_ID, ITEM_ID, TITLE, PARAM1, PARAM2, DATE_CHANGE, URL, SITE_URL, SITE_ID
				".(count($sqlHaving) > 1? "HAVING ".implode(" AND ", $sqlHaving): "")."
				ORDER BY ".(
				$bOrderByRank?
					"RANK1 DESC, CUSTOM_RANK DESC, RANK2 ASC, RANK3 ASC, TITLE":
					"DATE_CHANGE DESC, RANK1 DESC, RANK2 ASC, RANK3 ASC, TITLE"
				)."
				LIMIT 0, ".($nTopCount + 1)."
			"; */
			
			$strSelect = "
			sc.ID
			,sc.MODULE_ID
			,sc.ITEM_ID
			,sc.TITLE
			,sc.PARAM1
			,sc.PARAM2
			,sc.DATE_CHANGE
			,sc.URL as URL
			,sc.CUSTOM_RANK as CUSTOM_RANK
			,scsite.URL as SITE_URL
			,scsite.SITE_ID
			";
			
			if(!empty($arWords)){
				$strSelectRank = '';
				foreach ($arWords as $word)
				{
					if (strlen($strSelectRank) > 0)
						$strSelectRank .= " + ";
					$strSelectRank .= "if(locate('".$DB->ForSql(ToUpper($word))."', upper(sc.TITLE)) > 0, locate('".$DB->ForSql(ToUpper($word))."', upper(sc.TITLE)), 250)";
				}
				$strSelect .= ', '.$strSelectRank." as RANK1";
			}
			
			
			$strSql = "
				SELECT
					".$strSelect."
				FROM
					b_search_content_title ct
					inner join b_search_content sc on sc.ID = ct.SEARCH_CONTENT_ID
					INNER JOIN b_search_content_site scsite ON sc.ID = scsite.SEARCH_CONTENT_ID and ct.SITE_ID = scsite.SITE_ID
				WHERE
					".CSearch::CheckPermissions("sc.ID")."
					AND ct.SITE_ID = '".SITE_ID."'
					AND (".implode(" OR ", $sqlWords).")
					".(!empty($strSqlWhere)? "AND ".$strSqlWhere: "")."
				GROUP BY
					ID, MODULE_ID, ITEM_ID, TITLE, PARAM1, PARAM2, DATE_CHANGE, URL, SITE_URL, SITE_ID
				".(count($sqlHaving) > 1? "HAVING ".implode(" AND ", $sqlHaving): "")."
				ORDER BY ".(
				$bOrderByRank?
					"CUSTOM_RANK DESC, RANK1 ASC, TITLE":
					"DATE_CHANGE DESC, RANK1 ASC, TITLE"
				)."
				LIMIT 0, ".($nTopCount + 1)."
			";
			
			// AddMessage2Log($strSql, 'search.title strSql', 0);
			// AddMessage2Log($arWords, 'search.title arWords', 0);

			$r = $DB->Query($strSql);
			CDBResult::__construct($r);
			// parent::CDBResult($r);
			return true;
		}
		else
		{
			return false;
		}
	}

	function getRankFunction($phrase)
	{
		$DB = CDatabase::GetModuleConnection('search');
		return "if(locate('".$DB->ForSQL(ToUpper($phrase))."', upper(sc.TITLE)) > 0, 1, 0)";
	}

	function getSqlOrder($bOrderByRank)
	{
		if ($bOrderByRank)
			return "RANK1 DESC, TITLE";
		else
			return "DATE_CHANGE DESC, RANK1 DESC, TITLE";
	}
}
