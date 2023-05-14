<?php
IncludeModuleLangFile(__FILE__);
if(!check_bitrix_sessid()) return;
echo CAdminMessage::ShowNote(GetMessage("PAYKEEPER_UNINSTALL_RESULT"));
?>