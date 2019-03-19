<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Shop_Warehouse_Incoming Backend Editing Controller.
 *
 * @package HostCMS
 * @subpackage Shop
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2019 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Shop_Warehouse_Incoming_Controller_Edit extends Admin_Form_Action_Controller_Type_Edit
{
	/**
	 * Set object
	 * @param object $object object
	 * @return self
	 */
	public function setObject($object)
	{
		$oShop = Core_Entity::factory('Shop', Core_Array::getGet('shop_id', 0));
		$oShop_Group = Core_Entity::factory('Shop_Group', Core_Array::getGet('shop_group_id', 0));

		parent::setObject($object);

		$oMainTab = $this->getTab('main');
		$oAdditionalTab = $this->getTab('additional');

		$oAdmin_Form_Controller = $this->_Admin_Form_Controller;

		$oMainTab
			->add($oMainRow1 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow2 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow3 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow4 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oShopItemBlock = Admin_Form_Entity::factory('Div')->class('well with-header'));

		$oMainTab
			->move($this->getField('number')->divAttr(array('class' => 'form-group col-xs-12 col-sm-3')), $oMainRow1)
			->move($this->getField('datetime')->divAttr(array('class' => 'form-group col-xs-12 col-sm-4'))->class('input-lg'), $oMainRow1);

		$oAdditionalTab->delete($this->getField('shop_warehouse_id'));

		$oDefault_Shop_Warehouse = $oShop->Shop_Warehouses->getDefault();

		$oShop_Warehouse_Select = Admin_Form_Entity::factory('Select')
			->caption(Core::_('Shop_Warehouse_Incoming.shop_warehouse_id'))
			->divAttr(
				array('class' => 'form-group col-xs-12 col-sm-2')
			)
			->options(self::fillWarehousesList($oShop))
			->class('form-control select-warehouse')
			->name('shop_warehouse_id')
			->value($this->_object->id
				? $this->_object->shop_warehouse_id
				: (!is_null($oDefault_Shop_Warehouse) ? $oDefault_Shop_Warehouse->id : 0)
			);

		$oMainRow2->add($oShop_Warehouse_Select);

		// Удаляем поле с идентификатором ответственного сотрудника
		$oAdditionalTab->delete($this->getField('user_id'));

		$aSelectResponsibleUsers = array();

		$oSite = Core_Entity::factory('Site', CURRENT_SITE);

		$aCompanies = $oSite->Companies->findAll();
		foreach ($aCompanies as $oCompany)
		{
			$oOptgroupCompany = new stdClass();
			$oOptgroupCompany->attributes = array('label' => htmlspecialchars($oCompany->name), 'class' => 'company');
			$oOptgroupCompany->children = $oCompany->fillDepartmentsAndUsers($oCompany->id);

			$aSelectResponsibleUsers[] = $oOptgroupCompany;
		}

		$oSelectResponsibleUsers = Admin_Form_Entity::factory('Select')
			->id('user_id')
			->options($aSelectResponsibleUsers)
			->name('user_id')
			->value($this->_object->user_id)
			->caption(Core::_('Shop_Warehouse_Incoming.user_id'))
			->divAttr(array('class' => ''));

		$oScriptResponsibleUsers = Admin_Form_Entity::factory('Script')
			->value('$("#user_id").selectUser({
						placeholder: "",
						language: "' . Core_i18n::instance()->getLng() . '"
					});'
			);

		$oMainRow2
			->add(
				Admin_Form_Entity::factory('Div')
					->add(
						Admin_Form_Entity::factory('Div')
							->class('hidden-sm hidden-md hidden-lg padding-top-40')
					)
					->add($oSelectResponsibleUsers)
					->class('form-group col-xs-12 col-sm-4')
			)
			->add($oScriptResponsibleUsers);

		$oMainTab->move($this->getField('posted')->divAttr(array('class' => 'form-group col-xs-12 col-sm-2 margin-top-21')), $oMainRow2);

		$oMainTab->delete($this->getField('shop_price_id'));

		$oShop_Price_Select = Admin_Form_Entity::factory('Select')
			->caption(Core::_('Shop_Warehouse_Incoming.shop_price_id'))
			->divAttr(
				array('class' => 'form-group col-xs-12 col-sm-3')
			)
			->options(self::fillPricesList($oShop))
			->class('form-control select-price')
			->name('shop_price_id')
			->value($this->_object->id
				? $this->_object->shop_price_id
				: 0
			);

		$oMainRow3->add($oShop_Price_Select);

		$oRecalcPriceLink = Admin_Form_Entity::factory('Link');
		$oRecalcPriceLink
			->divAttr(array('class' => 'form-group col-xs-12 col-sm-3 margin-top-21'))
			->a
				->class('btn btn-default')
				->onclick("$.recalcPrice()")
				->value(Core::_('Shop_Warehouse_Incoming.recalc_price'));
		$oRecalcPriceLink
			->icon
				->class('fa fa-recycle');

		$oMainRow3->add($oRecalcPriceLink);

		// Печать
		$printlayoutsButton = '
			<div class="btn-group">
				<a class="btn btn-labeled btn-success" href="javascript:void(0);"><i class="btn-label fa fa-print"></i>' . Core::_('Printlayout.print') . '</a>
				<a class="btn btn-palegreen dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-angle-down"></i></a>
				<ul class="dropdown-menu dropdown-palegreen">
		';

		$moduleName = $oAdmin_Form_Controller->module->getModuleName();

		$oModule = Core_Entity::factory('Module')->getByPath($moduleName);

		if (!is_null($oModule))
		{
			$printlayoutsButton .= Printlayout_Controller::getPrintButtonHtml($this->_Admin_Form_Controller, $oModule->id, 1, 'hostcms[checked][0][' . $this->_object->id . ']=1&shop_id=' . $oShop->id . '&shop_group_id=' . $oShop_Group->id);
		}

		$printlayoutsButton .= '
				</ul>
			</div>
		';

		$oMainRow1
			->add(Admin_Form_Entity::factory('Div')
				->class('form-group col-xs-12 col-sm-3 margin-top-21 text-align-center')
				->add(
					Admin_Form_Entity::factory('Code')->html($printlayoutsButton)
				)
		);

		$oMainTab->move($this->getField('description')->divAttr(array('class' => 'form-group col-xs-12')), $oMainRow1);

		$oShopItemBlock
			->add($oHeaderDiv = Admin_Form_Entity::factory('Div')
				->class('header bordered-palegreen')
				->value(Core::_('Shop_Warehouse_Incoming.shop_item_header'))
			)
			->add($oShopItemRow1 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oShopItemRow2 = Admin_Form_Entity::factory('Div')->class('row'));

		$itemTable = '
			<table class="table table-striped table-hover shop-item-table deals-aggregate-user-info">
				<thead>
					<tr>
						<th scope="col">' . Core::_('Shop_Warehouse_Incoming.position') . '</th>
						<th scope="col">' . Core::_('Shop_Warehouse_Incoming.name') . '</th>
						<th scope="col">' . Core::_('Shop_Warehouse_Incoming.measure') . '</th>
						<th scope="col">' . Core::_('Shop_Warehouse_Incoming.price') . '</th>
						<th scope="col">' . Core::_('Shop_Warehouse_Incoming.currency') . '</th>
						<th scope="col">' . Core::_('Shop_Warehouse_Incoming.quantity') . '</th>
						<th scope="col">' . Core::_('Shop_Warehouse_Incoming.sum') . '</th>
						<th scope="col">  </th>
					</tr>
				</thead>
				<tbody>
		';

		$aShop_Warehouse_Incoming_Items = $this->_object->Shop_Warehouse_Incoming_Items->findAll(FALSE);

		$index = 0;

		foreach ($aShop_Warehouse_Incoming_Items as $key => $oShop_Warehouse_Incoming_Item)
		{
			$oShop_Item = Core_Entity::factory('Shop_Item')->getById($oShop_Warehouse_Incoming_Item->shop_item_id);

			if (!is_null($oShop_Item))
			{
				$oShop_Item = $oShop_Item->shortcut_id
					? $oShop_Item->Shop_Item
					: $oShop_Item;

				$currencyName = $oShop_Item->Shop_Currency->name;
				$measureName = $oShop_Item->Shop_Measure->name;

				$onclick = $oAdmin_Form_Controller->getAdminActionLoadAjax($oAdmin_Form_Controller->getPath(), 'deleteShopItem', NULL, 0, $oShop_Item->id, "shop_warehouse_incoming_item_id={$oShop_Warehouse_Incoming_Item->id}");

				$externalLink = '';

				$oSiteAlias = $oShop->Site->getCurrentAlias();
				if ($oSiteAlias)
				{
					$sItemUrl = ($oShop->Structure->https ? 'https://' : 'http://')
						. $oSiteAlias->name
						. $oShop->Structure->getPath()
						. $oShop_Item->getPath();

					$externalLink = '<a class="margin-left-5" target="_blank" href="' . $sItemUrl .  '"><i class="fa fa-external-link"></i></a>';
				}

				$sum = $oShop_Warehouse_Incoming_Item->count * $oShop_Warehouse_Incoming_Item->price;

				$index = $key + 1;

				$itemTable .= '
					<tr id="' . $oShop_Warehouse_Incoming_Item->id . '" data-item-id="' . $oShop_Item->id . '">
						<td class="index">' . $index . '</td>
						<td>' . htmlspecialchars($oShop_Item->name) . $externalLink . '</td>
						<td>' . htmlspecialchars($measureName) . '</td>
						<td><span class="price">' . htmlspecialchars($oShop_Warehouse_Incoming_Item->price) . '</span><input type="hidden" class="hidden-shop-price" name="shop_item_price_' . $oShop_Warehouse_Incoming_Item->id . '" value="' . htmlspecialchars($oShop_Warehouse_Incoming_Item->price) . '" /></td>
						<td>' . htmlspecialchars($currencyName) . '</td>
						<td width="80"><input class="set-item-count form-control" name="shop_item_quantity_' . $oShop_Warehouse_Incoming_Item->id . '" value="' . $oShop_Warehouse_Incoming_Item->count . '" /></td>
						<td><span class="fact-warehouse-sum">' . $sum . '</span></td>
						<td><a class="delete-associated-item" onclick="res = confirm(\'' . Core::_('Shop_Warehouse_Incoming.delete_dialog') . '\'); if (res) {' . $onclick . '} return res;"><i class="fa fa-times-circle darkorange"></i></a></td>
					</tr>
				';
			}
		}

		$itemTable .= '
				</tbody>
			</table>
		';

		$oShopItemRow2->add(
			Admin_Form_Entity::factory('Input')
				->divAttr(array('class' => 'form-group col-xs-12'))
				->class('add-shop-item form-control')
				->placeholder(Core::_('Shop_Warehouse_Incoming.add_item_placeholder'))
				->name('set_item_name')
		)->add(
			Admin_Form_Entity::factory('Input')
				->class('index_value')
				->type('hidden')
				->name('index')
				->value($index)
		);

		$oShopItemRow2
			->add(Admin_Form_Entity::factory('Div')
				->class('form-group col-xs-12')
				->add(
					Admin_Form_Entity::factory('Code')->html($itemTable)
				)
		);

		$oCore_Html_Entity_Script = Core::factory('Core_Html_Entity_Script')
			->value("$('.add-shop-item').autocompleteShopItem('{$oShop->id}', 0, function(event, ui) {
				$('.index_value').val((parseInt($('.index_value').val()) + 1));

				$('.shop-item-table > tbody').append(
					$('<tr data-item-id=\"' + ui.item.id + '\"><td class=\"index\">' + $('.index_value').val() + '</td><td>' + $.escapeHtml(ui.item.label) + '<input type=\'hidden\' name=\'shop_item_id[]\' value=\'' + (typeof ui.item.id !== 'undefined' ? ui.item.id : 0) + '\'/>' + '</td><td>' + $.escapeHtml(ui.item.measure) + '</td><td><span class=\"price\">' + ui.item.price_with_tax + '</span><input type=\"hidden\" name=\"shop_item_price[]\" value=\"' + ui.item.price_with_tax +'\"/></td><td>' + $.escapeHtml(ui.item.currency) + '</td><td width=\"80\"><input class=\"set-item-count form-control\" onsubmit=\"$(\'.add-shop-item\').focus();return false;\" name=\"shop_item_quantity[]\" value=\"0.00\"/></td><td><span class=\"fact-warehouse-sum\"></span></td><td><a class=\"delete-associated-item\" onclick=\"$(this).parents(\'tr\').remove()\"><i class=\"fa fa-times-circle darkorange\"></i></a></td></tr>')
				);
				ui.item.value = '';
				$.changeWarehouseCounts($('.set-item-count'), 1);
				$('.shop-item-table tr:last-child').find('.set-item-count').focus();
				$.focusAutocomplete($('.set-item-count'));
			  });

			  $.changeWarehouseCounts($('.set-item-count'), 1);

			  $.focusAutocomplete($('.set-item-count'));
			  ");

		$oShopItemRow2->add($oCore_Html_Entity_Script);

		$title = $this->_object->id
			? Core::_('Shop_Warehouse_Incoming.form_edit', $this->_object->number)
			: Core::_('Shop_Warehouse_Incoming.form_add');

		$this->title($title);

		return $this;
	}

	/**
	 * Processing of the form. Apply object fields.
	 * @hostcms-event Shop_Warehouse_Incoming_Controller_Edit.onAfterRedeclaredApplyObjectProperty
	 */
	protected function _applyObjectProperty()
	{
		$iOldWarehouse = intval($this->_object->shop_warehouse_id);

		$this->_object->user_id = intval(Core_Array::getPost('user_id'));

		parent::_applyObjectProperty();

		if ($this->_object->number == '')
		{
			$this->_object->number = $this->_object->id;
			$this->_object->save();
		}

		$bNeedsRePost = FALSE;

		// Существующие товары
		$aShop_Warehouse_Incoming_Items = $this->_object->Shop_Warehouse_Incoming_Items->findAll(FALSE);
		foreach ($aShop_Warehouse_Incoming_Items as $oShop_Warehouse_Incoming_Item)
		{
			$oShop_Item = Core_Entity::factory('Shop_Item')->getById($oShop_Warehouse_Incoming_Item->shop_item_id);

			if (!is_null($oShop_Item))
			{
				$oShop_Item = $oShop_Item->shortcut_id
					? $oShop_Item->Shop_Item
					: $oShop_Item;

				$quantity = Core_Array::getPost('shop_item_quantity_' . $oShop_Warehouse_Incoming_Item->id);

				if ($quantity > 0)
				{
					$oShop_Warehouse_Incoming_Item->count != $quantity && $bNeedsRePost = TRUE;

					$price = $oShop_Item->loadPrice($this->_object->shop_price_id);

					$oShop_Warehouse_Incoming_Item->count = $quantity;
					$oShop_Warehouse_Incoming_Item->price = $price;
					$oShop_Warehouse_Incoming_Item->save();
				}
			}
		}

		// Новые товары
		$aAddShopItems = Core_Array::getPost('shop_item_id', array());

		count($aAddShopItems) && $bNeedsRePost = TRUE;

		foreach ($aAddShopItems as $key => $shop_item_id)
		{
			$iCount = $this->_object->Shop_Warehouse_Incoming_Items->getCountByshop_item_id($shop_item_id);

			if (!$iCount)
			{
				$oShop_Item = Core_Entity::factory('Shop_Item')->getById($shop_item_id);

				if (!is_null($oShop_Item))
				{
					$oShop_Item = $oShop_Item->shortcut_id
						? $oShop_Item->Shop_Item
						: $oShop_Item;

					$price = $oShop_Item->loadPrice($this->_object->shop_price_id);

					$oShop_Warehouse_Incoming_Item = Core_Entity::factory('Shop_Warehouse_Incoming_Item');
					$oShop_Warehouse_Incoming_Item
						->shop_warehouse_incoming_id($this->_object->id)
						->shop_item_id($shop_item_id)
						->count(
							isset($_POST['shop_item_quantity'][$key]) ? $_POST['shop_item_quantity'][$key] : 1
						)
						->price(
							// isset($_POST['shop_item_price'][$key]) ? $_POST['shop_item_price'][$key] : 0
							$price
						)
						->save();
				}
			}
		}

		/*Core_Array::getPost('posted')
			? $this->_object->post()
			: $this->_object->unpost();*/

		($bNeedsRePost || !Core_Array::getPost('posted')) && $this->_object->unpost();
		Core_Array::getPost('posted') && $this->_object->post();

		if ($iOldWarehouse != $this->_object->shop_warehouse_id)
		{
			$aOld_Shop_Warehouse_Entries = Core_Entity::factory('Shop_Warehouse', $iOldWarehouse)->Shop_Warehouse_Entries->getByDocument($this->_object->id, 1);

			foreach ($aOld_Shop_Warehouse_Entries as $oShop_Warehouse_Entry)
			{
				$oShop_Warehouse_Entry->delete();
			}
		}

		Core_Event::notify(get_class($this) . '.onAfterRedeclaredApplyObjectProperty', $this, array($this->_Admin_Form_Controller));
	}

	/**
	 * Fill warehouses list
	 * @return array
	 */
	public function fillWarehousesList(Shop_Model $oShop)
	{
		$aReturn = array(' … ');

		$aShop_Warehouses = $oShop->Shop_Warehouses->findAll();

		foreach ($aShop_Warehouses as $oShop_Warehouse)
		{
			$aReturn[$oShop_Warehouse->id] = $oShop_Warehouse->name . ' [' . $oShop_Warehouse->id . ']';
		}

		return $aReturn;
	}

	/**
	 * Fill prices list
	 * @return array
	 */
	public function fillPricesList(Shop_Model $oShop)
	{
		$aReturn = array(Core::_('Shop_Warehouse_Incoming.basic'));

		// if (Core::moduleIsActive('siteuser'))
		// {
			$aShop_Prices = $oShop->Shop_Prices->findAll();

			foreach ($aShop_Prices as $oShop_Price)
			{
				$aReturn[$oShop_Price->id] = $oShop_Price->name . ' [' . $oShop_Price->id . ']';
			}
		// }

		return $aReturn;
	}
}