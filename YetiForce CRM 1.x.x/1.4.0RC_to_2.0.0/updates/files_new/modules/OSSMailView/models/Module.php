<?php
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
class OSSMailView_Module_Model extends Vtiger_Module_Model {
	public function getSettingLinks() {
		$settingsLinks = parent::getSettingLinks();
		$layoutEditorImagePath = Vtiger_Theme::getImagePath('LayoutEditor.gif');
		$db = PearDatabase::getInstance();
		$result = $db->query("SELECT fieldid FROM vtiger_settings_field WHERE name =  'OSSMailView' AND description =  'OSSMailView'", true);
		$settingsLinks[] = array(
			'linktype' => 'LISTVIEWSETTING',
			'linklabel' => 'Konfiguracja modułu',
			'linkurl' => 'index.php?module=OSSMailView&parent=Settings&view=index&block=4&fieldid=' . $db->query_result($result, 0, 'fieldid'),
			'linkicon' => $layoutEditorImagePath
		);
		return $settingsLinks;
	}
	public function isPermitted($actionName) {
		if($actionName == 'EditView'){
			return false;
		}else{
			return ($this->isActive() && Users_Privileges_Model::isPermitted($this->getName(), $actionName));
		}
	}
	function getSideBarLinks() {
		$quickLinks = array();  
		$quickLinks[] =	array(
				'linktype' => 'SIDEBARLINK',
				'linklabel' => 'LBL_RECORDS_LIST',
				'linkurl' => $this->getListViewUrl(),
				'linkicon' => '',
			);
		if(Vtiger_DashBoard_Model::verifyDashboard($this->getName())){
			$quickLinks[] = array(
				'linktype' => 'SIDEBARLINK',
				'linklabel' => 'LBL_DASHBOARD',
				'linkurl' => $this->getDashBoardUrl(),
				'linkicon' => '',
			);
		}
		foreach($quickLinks as $quickLink) {
			$links['SIDEBARLINK'][] = Vtiger_Link_Model::getInstanceFromValues($quickLink);
		}
		return $links;
	}
	public function getMailCount($owner, $dateFilter) {
		$db = PearDatabase::getInstance();

		if (!$owner) {
			$currenUserModel = Users_Record_Model::getCurrentUserModel();
			$owner = $currenUserModel->getId();
		} else if ($owner === 'all') {
			$owner = '';
		}

		$params = array();
		if(!empty($owner)) {
			$ownerSql =  ' AND smownerid = ? ';
			$params[] = $owner;
		}
		if(!empty($dateFilter)) {
			$dateFilterSql = ' AND createdtime BETWEEN ? AND ? ';
			$params[] = $dateFilter['start'] . ' 00:00:00';
			$params[] = $dateFilter['end'] . ' 23:59:59';
		}

		$result = $db->pquery('SELECT COUNT(*) count, ossmailview_sendtype FROM vtiger_ossmailview
						INNER JOIN vtiger_crmentity ON vtiger_ossmailview.ossmailviewid = vtiger_crmentity.crmid
						AND deleted = 0 '.Users_Privileges_Model::getNonAdminAccessControlQuery($this->getName()). $ownerSql . $dateFilterSql . ' GROUP BY ossmailview_sendtype', $params);

		$response = array();
		
		for($i=0; $i<$db->num_rows($result); $i++) {
			$saleStage = $db->query_result($result, $i, 'ossmailview_sendtype');
			$response[$i][0] = $saleStage;
			$response[$i][1] = $db->query_result($result, $i, 'count');
			$response[$i][2] = vtranslate($saleStage, $this->getName());
				
		}
		return $response;
	}
}
