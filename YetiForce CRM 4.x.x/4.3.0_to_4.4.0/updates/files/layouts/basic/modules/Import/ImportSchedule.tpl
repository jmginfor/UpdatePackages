{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
	<div class="tpl-Import-ImportSchedule pt-5">
		<table class="u-w-90per m-auto searchUIBasic well">
			<tr>
				<td class="font-x-large text-center">
					<h3>
						<strong>
							{\App\Language::translate('LBL_IMPORT_SCHEDULED', $MODULE)}
						</strong>
					</h3
				</td>
			</tr>
			{if $ERROR_MESSAGE neq ''}
				<tr>
					<td class="text-center">
						{$ERROR_MESSAGE}
					</td>
				</tr>
			{/if}
			<tr>
				<td>
					<table class="text-center w-100 bg-light text-dark dvtSelectedCell thickBorder importContents">
						<tr>
							<td>{\App\Language::translate('LBL_SCHEDULED_IMPORT_DETAILS', $MODULE)}</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="float-right">
					<button class="btn btn-danger btn-sm delete" value="{\App\Language::translate('LBL_CANCEL_IMPORT', $MODULE)}" type="button" name="cancel"
							onclick="location.href = 'index.php?module={$FOR_MODULE}&view=Import&mode=cancelImport&import_id={$IMPORT_ID}'">
						<span class="font-weight-bold">{\App\Language::translate('LBL_CANCEL_IMPORT', $MODULE)}</span>
					</button>
					{include file=\App\Layout::getTemplatePath('Import_Done_Buttons.tpl', 'Import')}
				</td>
			</tr>
		</table>
	</div>
{/strip}
