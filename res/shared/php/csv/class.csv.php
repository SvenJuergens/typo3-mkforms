<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009-2014 DMK E-BUSINESS GmbH (dev@dmk-ebusiness.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

//+ Jonas Raoni Soares Silva
//@ http://jsfromhell.com
// taken from http://snippets.dzone.com/posts/show/3128

class CSV{
	var $cellDelimiter;
	var $valueEnclosure;
	var $rowDelimiter;

 	function CSV($cellDelimiter, $rowDelimiter, $valueEnclosure){
 		$this->cellDelimiter = $cellDelimiter;
 		$this->valueEnclosure = $valueEnclosure;
 		$this->rowDelimiter = $rowDelimiter;
 		$this->o = array();
 	}
 	function getArray(){
 		return $this->o;
 	}
 	function setArray($o){
 		$this->o = $o;
 	}
 	function getContent(){
 		if(!(($bl = strlen($b = $this->rowDelimiter)) && ($dl = strlen($d = $this->cellDelimiter)) && ($ql = strlen($q = $this->valueEnclosure))))
 			return '';
 		for($o = $this->o, $i = -1; ++$i < count($o);){
 			for($e = 0, $j = -1; ++$j < count($o[$i]);)
 				(($e = strpos($o[$i][$j], $q) !== false) || strpos($o[$i][$j], $b) !== false || strpos($o[$i][$j], $d) !== false)
 				&& $o[$i][$j] = $q . ($e ? str_replace($q, $q . $q, $o[$i][$j]) : $o[$i][$j]) . $q;
 			$o[$i] = implode($d, $o[$i]);
 		}
 		return implode($b, $o);
 	}
 	function setContent($s){
 		$this->o = array();
 		if(!strlen($s))
 			return true;
 		if(!(($bl = strlen($b = $this->rowDelimiter)) && ($dl = strlen($d = $this->cellDelimiter)) && ($ql = strlen($q = $this->valueEnclosure))))
 			return false;
 		for($o = array(array('')), $this->o = &$o, $e = $r = $c = 0, $i = -1, $l = strlen($s); ++$i < $l;){
 			if(!$e && substr($s, $i, $bl) == $b){
 				$o[++$r][$c = 0] = '';
 				$i += $bl - 1;
 			}
 			elseif(substr($s, $i, $ql) == $q){
 				$e ? (substr($s, $i + $ql, $ql) == $q ?
 				$o[$r][$c] .= substr($s, $i += $ql, $ql) : $e = 0)
 				: (strlen($o[$r][$c]) == 0 ? $e = 1 : $o[$r][$c] .= substr($s, $i, $ql));
 				$i += $ql - 1;
 			}
 			elseif(!$e && substr($s, $i, $dl) == $d){
 				$o[$r][++$c] = '';
 				$i += $dl - 1;
 			}
 			else
 				$o[$r][$c] .= $s[$i];
 		}
 		return true;
 	}
}

?>