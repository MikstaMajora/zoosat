<?php
IncludeModuleLangFile(__FILE__);
if(!check_bitrix_sessid()) return;
echo CAdminMessage::ShowNote(GetMessage("PAYKEEPER_INSTALL_RESULT"));
?>