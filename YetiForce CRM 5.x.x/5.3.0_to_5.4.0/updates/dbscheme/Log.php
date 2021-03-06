<?php

namespace Importers;

/**
 * Class that imports base database.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Log extends \App\Db\Importers\Base
{
	public $dbType = 'log';

	public function scheme()
	{
		$this->tables = [
			'l_#__magento' => [
				'columns' => [
					'id' => $this->primaryKey(10)->unsigned(),
					'time' => $this->dateTime()->notNull(),
					'category' => $this->stringType(100),
					'message' => $this->stringType(500),
					'code' => $this->smallInteger(5),
					'trace' => $this->text(),
				],
				'engine' => 'InnoDB',
				'charset' => 'utf8'
			],
		];
	}
}
