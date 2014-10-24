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

$cryptinstall="./cryptographp.fct.php";
include $cryptinstall; 
?>


<html>
<div align="center">
<b>Exemple d'utilisation de Cryptographp v1.4</b><br>
(Cet exemple fonctionne m�me si les cookies sont d�sactiv�es)<br><br>

<form action="verifier.php?<?PHP echo SID; ?>" method="post">
<table cellpadding=1>
  <tr><td align="center"><?php dsp_crypt(0,1); ?></td></tr>
  <tr><td align="center">Recopier le code:<br><input type="text" name="code"></td></tr>
  <tr><td align="center"><input type="submit" name="submit" value="Envoyer"></td></tr>
</table>
<br><br><br>
Cryptographp (c) 2006-2007 Sylvain BRISON<br>
http://www.cryptographp.com
</form>

</div>
</html>


