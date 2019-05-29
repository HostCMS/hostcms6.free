<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Admin forms.
 *
 * @package HostCMS
 * @subpackage Skin
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2019 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Skin_Bootstrap_Admin_Form_Entity_File extends Skin_Default_Admin_Form_Entity_File 
{
	/**
	 * Execute business logic
	 */
	public function execute()
	{
		$oCore_Registry = Core_Registry::instance();
		$iAdmin_Form_Count = $oCore_Registry->get('Admin_Form_Count', 0);
		$oCore_Registry->set('Admin_Form_Count', $iAdmin_Form_Count + 1);

		$aTypicalLargeParams = array(
			// image_big_max_width - значение максимальной ширины большого изображения;
			'max_width' => defined('MAX_SIZE_LOAD_IMAGE_BIG') ? MAX_SIZE_LOAD_IMAGE_BIG : 0,

			// image_big_max_height - значение максимальной высоты большого изображения;
			'max_height' => defined('MAX_SIZE_LOAD_IMAGE_BIG') ? MAX_SIZE_LOAD_IMAGE_BIG : 0,

			// big_image_path - адрес большого загруженного изображения
			'path' => '',
			'originalName' => NULL,

			// show_big_image_params - параметр, определяющий отображать ли настройки большого изображения
			'show_params' => TRUE,

			// watermark_position_x - значение поля ввода с подписью "По оси X"
			'watermark_position_x' => '50%',

			// watermark_position_y - значение поля ввода с подписью "По оси Y"
			'watermark_position_y' => '100%',

			// used_watermark_big_image_show - отображать ли checkbox с подписью "Наложить водяной знак на большое изображение" (1 - отображать (по умолчанию), 0 - не отображать);
			'place_watermark_checkbox' => TRUE,

			// used_watermark_big_image_checked - вид ображения checkbox'а с подписью "Наложить водяной знак на большое изображение" (1 - отображать выбранным (по умолчанию), 0 - невыбранным);
			'place_watermark_checkbox_checked' => TRUE,

			// onclick_delete_big_image - значение onclick для удаления большой картинки
			'delete_onclick' => '',

			// href_delete_big_image - значение href для удаления большой картинки
			'delete_href' => NULL,

			'caption' => $this->caption,
			'name' => $this->name,
			'id' => $this->id,

			// used_big_image_preserve_aspect_ratio - параметр Отображать ли checkbox с подписью "Сохранять пропорции изображения" (1 - отображать (по умолчанию), 0 - не отображать);
			'preserve_aspect_ratio_checkbox' => TRUE,

			// used_big_image_preserve_aspect_ratio_checked - вид ображения checkbox'а с подписью "Сохранять пропорции изображения" (1 - отображать выбранным (по умолчанию), 0 - невыбранным);
			'preserve_aspect_ratio_checkbox_checked' => TRUE,

			// Показать поле описания файла
			'show_description' => FALSE,

			// Описания файла
			'description' => ''
		);

		// image_watermark_position_x_show - показывать поле задания положения "водяного" знака по оси X
		$aTypicalLargeParams['place_watermark_x_show'] = $aTypicalLargeParams['place_watermark_checkbox'];

		// image_watermark_position_y_show - показывать поле задания положения "водяного" знака по оси Y
		$aTypicalLargeParams['place_watermark_y_show'] = $aTypicalLargeParams['place_watermark_checkbox'];

		// Объединяем с типовыми параметрами
		$this->largeImage += $aTypicalLargeParams;

		// -------------------

		$aTypicalSmallParams = array(
			// load_small_image_show - отображать ли поле загрузки малого изображения (1 - отображать (по умолчанию), 0 - не отображать);
			'show' => TRUE,

			// image_small_max_width - значение максимальной ширины малого изображения;
			'max_width' => defined('MAX_SIZE_LOAD_IMAGE') ? MAX_SIZE_LOAD_IMAGE : 0,

			// image_small_max_height - значение максимальной высоты малого изображения;
			'max_height' => defined('MAX_SIZE_LOAD_IMAGE') ? MAX_SIZE_LOAD_IMAGE : 0,

			// small_image_path - адрес малого загруженного изображения
			'path' => '',
			'originalName' => NULL,

			// show_small_image_params - параметр, определяющий отображать ли настройки малого изображения
			'show_params' => TRUE,

			// make_small_image_from_big_show - отображать ли checkbox с подписью "Создать малое изображение из большого" (1 - отображать (по умолчанию), 0 - не отображать);
			'create_small_image_from_large' => TRUE,

			// make_small_image_from_big_checked - вид ображения checkbox'а с подписью "Создать малое изображение из большого" выбранным (1 - отображать выбранным (по умолчанию), 0 - невыбранным);
			'create_small_image_from_large_checked' => TRUE,

			// used_watermark_small_image_show - отображать ли checkbox с подписью "Наложить водяной знак на малое изображение" (1 - отображать (по умолчанию), 0 - не отображать);
			'place_watermark_checkbox' => TRUE,

			// used_watermark_small_image_checked - вид ображения checkbox'а с подписью "Наложить водяной знак на малое изображение" (1 - отображать выбранным (по умолчанию), 0 - невыбранным);
			'place_watermark_checkbox_checked' => TRUE,

			// onclick_delete_small_image - значение onclick для удаления малой картинки
			'delete_onclick' => '',

			// href_delete_small_image - значение href для удаления малой картинки
			'delete_href' => NULL,

			// load_small_image_caption - заголовок поля загрузки малого изображения
			'caption' => Core::_('Admin_Form.small_image'),

			'name' => 'small_' . $this->largeImage['name'],
			'id' => 'small_' . $this->largeImage['id'],

			// used_small_image_preserve_aspect_ratio - параметр Отображать ли checkbox с подписью "Сохранять пропорции изображения" (1 - отображать (по умолчанию), 0 - не отображать);
			'preserve_aspect_ratio_checkbox' => TRUE,

			// Не задан вид ображения checkbox'а с подписью "Наложить водяной знак на большое изображение" (1 - отображать выбранным (по умолчанию), 0 - невыбранным);
			'preserve_aspect_ratio_checkbox_checked' => TRUE,

			// Показать поле описания файла
			'show_description' => FALSE,

			// Описания файла
			'description' => ''
		);

		// Объединяем с типовыми параметрами
		$this->smallImage += $aTypicalSmallParams;

		// ----------
		$windowId = $this->_Admin_Form_Controller->getWindowId();

		$oLarge_Core_Html_Entity_Div = new Core_Html_Entity_Div();

		// Установим атрибуты div'a.
		if (is_array($this->divAttr))
		{
			foreach ($this->divAttr as $attrName => $attrValue)
			{
				$oLarge_Core_Html_Entity_Div->$attrName($attrValue);
			}
		}

		$oLarge_Main_Block_Core_Html_Entity_Div = Core::factory('Core_Html_Entity_Div')
			->class('row');

		$oLarge_Core_Html_Entity_Div
			->class((count($this->_children) ? 'input-group' : '') . ($oLarge_Core_Html_Entity_Div->class != '' ? ' ' . $oLarge_Core_Html_Entity_Div->class : ''));

		if (count($this->_children))
		{
			$oLarge_Core_Html_Entity_Div
				->add(
					Core::factory('Core_Html_Entity_Div')
						->class('col-xs-12')
						->add($oLarge_Main_Block_Core_Html_Entity_Div)
				);
		}
		else
		{
			$oLarge_Core_Html_Entity_Div->add($oLarge_Main_Block_Core_Html_Entity_Div);
		}

		//$sDivClass = 'col-xs-12 col-sm-6';

		$sDivClass = $this->smallImage['show'] || $this->largeImage['show_description']
			? 'col-xs-12 col-sm-6'
			: 'col-xs-12';

		$oLarge_Input_Div = Core::factory('Core_Html_Entity_Div')
			->id('file_large_' . $iAdmin_Form_Count)
			->class('form-group ' . $sDivClass)
			->add(
				Core::factory('Core_Html_Entity_Span')
					->class('caption')
					->value($this->largeImage['caption'])
			)
			->add(
				$oLarge_Input_Group_Div = Core::factory('Core_Html_Entity_Div')
					->class('input-group')
					->add(
						Core::factory('Core_Html_Entity_Input')
							->class('form-control' . ($this->largeImage['path'] != '' ? ' hidden' : ''))
							->name($this->largeImage['name'])
							->id($this->largeImage['id'])
							->type('file')
					)
			);

		if ($this->largeImage['path'] != '')
		{
			$prefixRand = strpos($this->largeImage['path'], '?') === FALSE
				? '?'
				: '&';

			$originalName = $this->largeImage['originalName'] != '' ? $this->largeImage['originalName'] : basename($this->largeImage['path']);

			$oLarge_Input_Group_Div->add(
				Admin_Form_Entity::factory('Code')
					->html('<div id="file_preview_large_' . $this->largeImage['id'] . '" class="file-caption" style="display:block; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; width: calc(100% - 15px)"><i class="' . $this->_getIcon($originalName) . ' margin-right-5"></i><a target="_blank" href="' . htmlspecialchars($this->largeImage['path']) . $prefixRand . 'rnd=' . rand() .'">'
						. htmlspecialchars($originalName . $originalName . $originalName)
						. '</a></div>')
			);
		}

		$oLarge_Main_Block_Core_Html_Entity_Div
			->add($oLarge_Input_Div);

		if ($this->largeImage['path'] != '' || $this->largeImage['show_params'])
		{
			// Картинка с контролем большого изображения
			if ($this->largeImage['path'] != '')
			{
				$prefixRand = strpos($this->largeImage['path'], '?') === FALSE
					? '?'
					: '&';

				$oLarge_Input_Group_Div->add(
					Core::factory('Core_Html_Entity_A')
						->id('preview_large_' . $this->largeImage['id'])
						->class('input-group-addon control-item ')
						->onclick('$("#' . $windowId . ' input#' . $this->largeImage['id'] . ', #' . $windowId . ' div#file_preview_large_' . $this->largeImage['id'] . '").toggleClass(\'hidden\'); $("#' . $windowId . ' a#preview_large_' . $this->largeImage['id'] . ' > i").toggleClass(\'fa-pencil fa-image\')')
						->add(Admin_Form_Entity::factory('Code')->html('<i class="fa fa-pencil"></i>'))
					)
					->add(
						Core::factory('Core_Html_Entity_A')
							->id('delete_large_' . $this->largeImage['id'])
							->class('input-group-addon control-item')
							->onclick("res = confirm('" . Core::_('Admin_Form.msg_information_delete') . "'); if (res) { {$this->largeImage['delete_onclick']} } else {return false;}")
							->add(Admin_Form_Entity::factory('Code')->html('<i class="fa fa-trash"></i>'))
					);
			}
		}

		// Настройки большого изображения
		if ($this->largeImage['show_params'])
		{
			$oLargeWatermark_Div = Core::factory('Core_Html_Entity_Div')
				->id("{$windowId}_watermark_{$this->largeImage['name']}")
				->class('form-horizontal')
				->style("display: none")
				->add(
					Core::factory('Core_Html_Entity_Div')
						->class('form-group')
						->add(
							Core::factory('Core_Html_Entity_Label')
								->class('col-xs-12 col-lg-8 control-label')
								->value(Core::_('Admin_Form.large_image_max_width'))
						)
						->add(
							Core::factory('Core_Html_Entity_Div')
								->class('col-xs-12 col-lg-4')
								->add(
									Core::factory('Core_Html_Entity_Input')
										->type('text')
										->class('form-control')
										->name('large_max_width_' . $this->largeImage['name'])
										->value($this->largeImage['max_width'])
								)
						)
						->add(
							Core::factory('Core_Html_Entity_Div')
								->class('clearfix')
						)
					)
				->add(
					Core::factory('Core_Html_Entity_Div')
						->class('form-group')
						->add(
							Core::factory('Core_Html_Entity_Label')
								->class('col-xs-12 col-lg-8 control-label')
								->value(Core::_('Admin_Form.large_image_max_height'))
							)
						->add(
							Core::factory('Core_Html_Entity_Div')
								->class('col-xs-12 col-lg-4')
								->add(
									Core::factory('Core_Html_Entity_Input')
										->type('text')
										->class('form-control')
										->name('large_max_height_' . $this->largeImage['name'])
										->value($this->largeImage['max_height'])
								)
						)
						->add(
							Core::factory('Core_Html_Entity_Div')
								->class('clearfix')
						)
				);

			// Отображать Сохранять пропорции изображения
			if ($this->largeImage['preserve_aspect_ratio_checkbox'])
			{
				$Core_Html_Entity_Checkbox = Core::factory('Core_Html_Entity_Input')
					->type('checkbox')
					->name("large_preserve_aspect_ratio_{$this->largeImage['name']}")
					->id("large_preserve_aspect_ratio_{$this->largeImage['name']}")
					->value(1);

				if ($this->largeImage['preserve_aspect_ratio_checkbox_checked'])
				{
					$Core_Html_Entity_Checkbox
						->checked('checked');
				};

				$oLargeWatermark_Div
					->add(
						Core::factory('Core_Html_Entity_Div')
						->class('form-group col-xs-12')
						->add(
							Core::factory('Core_Html_Entity_Label')
								->class('checkbox-inline')
								->value(Core::_('Admin_Form.image_preserve_aspect_ratio'))
								->add($Core_Html_Entity_Checkbox)
								->add(
									Core::factory('Core_Html_Entity_Span')
										->class('text')
								)
						)
					)
					->add(
						Core::factory('Core_Html_Entity_Div')
							->class('clearfix')
					);
			}

			// Наложить водяной знак на изображение
			if ($this->largeImage['place_watermark_checkbox'] == 1)
			{
				$Core_Html_Entity_Checkbox = Core::factory('Core_Html_Entity_Input')
					->type('checkbox')
					->name("large_place_watermark_checkbox_{$this->largeImage['name']}")
					->id("large_place_watermark_checkbox_{$this->largeImage['name']}")
					->value(1);

				if ($this->largeImage['place_watermark_checkbox_checked'])
				{
					$Core_Html_Entity_Checkbox
						->checked('checked');
				};

				$oLargeWatermark_Div
					->add(
						Core::factory('Core_Html_Entity_Div')
						->class('form-group col-xs-12')
						->add(
							Core::factory('Core_Html_Entity_Label')
								->class('checkbox-inline')
								->value(Core::_('Admin_Form.place_watermark'))
								->add($Core_Html_Entity_Checkbox)
								->add(
									Core::factory('Core_Html_Entity_Span')
										->class('text')
								)
						)
					)
					->add(
						Core::factory('Core_Html_Entity_Div')
							->class('clearfix')
					);
			}

			// Отображать поле положения "водяного" знака по оси X
			if ($this->largeImage['place_watermark_x_show'] == 1)
			{
				//$oLargeWatermark_Table
				$oLargeWatermark_Div
					->add(
						Core::factory('Core_Html_Entity_Div')
							->class('form-group')
							->add(
								Core::factory('Core_Html_Entity_Label')
									->class('col-xs-12 col-lg-8 control-label')
									->value(Core::_('Admin_Form.watermark_position_x'))
							)
							->add(
								Core::factory('Core_Html_Entity_Div')
									->class('col-xs-12 col-lg-4')
									->add(
										Core::factory('Core_Html_Entity_Input')
											->type('text')
											->class('form-control')
											->name("watermark_position_x_{$this->largeImage['name']}")
											->value($this->largeImage['watermark_position_x'])
									)
							)
							->add(
								Core::factory('Core_Html_Entity_Div')
									->class('clearfix')
							)
					);
			}

			// Отображать поле положения "водяного" знака по оси Y
			if ($this->largeImage['place_watermark_y_show'] == 1)
			{
				//$oLargeWatermark_Table
				$oLargeWatermark_Div
					->add(
						Core::factory('Core_Html_Entity_Div')
							->class('form-group')
							->add(
								Core::factory('Core_Html_Entity_Label')
									->class('col-xs-12 col-lg-8 control-label')
									->value(Core::_('Admin_Form.watermark_position_y'))
							)
							->add(
								Core::factory('Core_Html_Entity_Div')
									->class('col-xs-12 col-lg-4')
									->add(
										Core::factory('Core_Html_Entity_Input')
											->type('text')
											->class('form-control')
											->name("watermark_position_y_{$this->largeImage['name']}")
											->value($this->largeImage['watermark_position_y'])
									)
							)
							->add(
								Core::factory('Core_Html_Entity_Div')
									->class('clearfix')
							)
					);
			}
			// -----------------

			// Настройки большого изображения
			if ($this->largeImage['show_params'])
			{
				$oLarge_Input_Group_Div
					->add(
						Core::factory('Core_Html_Entity_Span')
							->id('file_large_settings_' . $iAdmin_Form_Count)
							->class('input-group-addon control-item')
							->addAllowedProperty('data-title')
							->set('data-title', '<b>' . Core::_('Admin_Form.window_large_image') . '</b>')
							->add(
								Admin_Form_Entity::factory('Code')->html('<i class="fa fa-cog"></i>')
							)
					)
					->add($oLargeWatermark_Div);
			}
		}

		// Быстрый просмотр большого изображения
		if ($this->largeImage['path'] != '')
		{
			if (Core_File::isValidExtension($this->largeImage['path'], array('jpg', 'jpeg', 'gif', 'png')))
			{
				$prefixRand = strpos($this->largeImage['path'], '?') === FALSE
					? '?'
					: '&';

				$oLarge_Input_Group_Div->add(Core::factory('Core_Html_Entity_Script')
					->value('$(function(){
							$("#' . $windowId . ' #file_preview_large_' . $this->largeImage['id'] . '").popover({
								content: \'<img src="' . htmlspecialchars($this->largeImage['path']) . $prefixRand . 'rnd=' . rand() .'" style="max-width:200px" />\',
								html: true,
								placement: \'top\',
								container: $(\'#file_large_' . $iAdmin_Form_Count . '\'),
								trigger: "hover"
							});
						});'
					));
			}
		}

		if ($this->largeImage['show_description'])
		{
			$oLarge_Main_Block_Core_Html_Entity_Div
				->add(
					Core::factory('Core_Html_Entity_Div')
						->class('form-group col-xs-12 col-sm-6')
						->add(
							Core::factory('Core_Html_Entity_Span')
								->class('caption')
								->value(Core::_('Admin_Form.file_description'))
						)
						->add(
							Core::factory('Core_Html_Entity_Input')
								// ->placeholder(Core::_('Admin_Form.file_description'))
								->type('text')
								->name("description_{$this->largeImage['name']}")
								->class('form-control description-large')
								->value($this->largeImage['description'])
						)
			);
		}
		// -- Малое изображение

		// Отображать поле загрузки малого изображения
		if ($this->smallImage['show'])
		{
			$oSmall_Input_Div = Core::factory('Core_Html_Entity_Div')
				->id('file_small_' . $iAdmin_Form_Count)
				->class('form-group ' . $sDivClass . ($this->smallImage['show_description'] ? ' clear' : ''))
				->add(
					Core::factory('Core_Html_Entity_Span')
						->class('caption')
						->value($this->smallImage['caption'])
				)
				->add(
					$oSmall_Input_Group_Div = Core::factory('Core_Html_Entity_Div')
					->class('input-group')
					->add(
						Core::factory('Core_Html_Entity_Input')
							->class('form-control' . ($this->smallImage['path'] != '' ? ' hidden' : ''))
							->name($this->smallImage['name'])
							->id($this->smallImage['id'])
							->type('file')
					)
				);

			if ($this->smallImage['path'] != '')
			{
				$prefixRand = strpos($this->smallImage['path'], '?') === FALSE
					? '?'
					: '&';

				$originalName = $this->smallImage['originalName'] != '' ? $this->smallImage['originalName'] : basename($this->smallImage['path']);

				$oSmall_Input_Group_Div->add(
					Admin_Form_Entity::factory('Code')
						->html('<div id="file_preview_' . $this->smallImage['id'] . '" class="file-caption"><i class="' . $this->_getIcon($originalName) . ' margin-right-5"></i><a target="_blank" href="' . htmlspecialchars($this->smallImage['path']) . $prefixRand . 'rnd=' . rand() .'">'
							. htmlspecialchars($originalName)
							. '</a></div>')
				);
			}

			$oLarge_Main_Block_Core_Html_Entity_Div
				->add($oSmall_Input_Div);

			if ($this->smallImage['path'] != '' || $this->smallImage['show_params'])
			{
				// Картинка с контролем малого изображения
				if ($this->smallImage['path'] != '')
				{
					$prefixRand = strpos($this->smallImage['path'], '?') === FALSE
						? '?'
						: '&';

					$oSmall_Input_Group_Div->add(
						Core::factory('Core_Html_Entity_A')
							->id('preview_' . $this->smallImage['id'])
							->class('input-group-addon control-item')
							->onclick('$("#' . $windowId . ' input#' . $this->smallImage['id'] . ', #' . $windowId . ' div#file_preview_' . $this->smallImage['id'] . '").toggleClass(\'hidden\'); $("#' . $windowId . ' a#preview_' . $this->smallImage['id'] . ' > i").toggleClass(\'fa-pencil fa-image\')')
							->add(Admin_Form_Entity::factory('Code')->html('<i class="fa fa-pencil"></i>'))
						)
						->add(
							Core::factory('Core_Html_Entity_A')
								->id('delete_' . $this->smallImage['id'])
								->class('input-group-addon control-item')
								->onclick("res = confirm('" . Core::_('Admin_Form.msg_information_delete') . "'); if (res) { {$this->smallImage['delete_onclick']} } else {return false;}")
								->add(Admin_Form_Entity::factory('Code')->html('<i class="fa fa-trash"></i>'))
						);
				}

				// Настройки малого изображения
				if ($this->smallImage['show_params'])
				{
					$oSmallWatermark_Div = Core::factory('Core_Html_Entity_Div')
						->id("{$windowId}_watermark_{$this->smallImage['name']}")
						->style("display: none")
						->class('form-horizontal')
						->add(
							Core::factory('Core_Html_Entity_Div')
								->class('form-group')
								->add(
									Core::factory('Core_Html_Entity_Label')
										->class('col-xs-12 col-lg-8 control-label')
										->value(Core::_('Admin_Form.small_image_max_width'))
								)
								->add(
									Core::factory('Core_Html_Entity_Div')
										->class('col-xs-12 col-lg-4')
										->add(
											Core::factory('Core_Html_Entity_Input')
												->type('text')
												->class('form-control')
												->name('small_max_width_' . $this->smallImage['name'])
												->value($this->smallImage['max_width'])
										)
								)
								->add(
									Core::factory('Core_Html_Entity_Div')
										->class('clearfix')
								)
						)
						->add(
							Core::factory('Core_Html_Entity_Div')
								->class('form-group')
								->add(
									Core::factory('Core_Html_Entity_Label')
										->class('col-xs-12 col-lg-8 control-label')
										->value(Core::_('Admin_Form.small_image_max_height'))
									)
								->add(
									Core::factory('Core_Html_Entity_Div')
										->class('col-xs-12 col-lg-4')
										->add(
											Core::factory('Core_Html_Entity_Input')
												->type('text')
												->class('form-control')
												->name('small_max_height_' . $this->smallImage['name'])
												->value($this->smallImage['max_height'])
										)
								)
								->add(
									Core::factory('Core_Html_Entity_Div')
										->class('clearfix')
								)
						);

					// Создать малое изображение из большого
					if ($this->smallImage['create_small_image_from_large'])
					{
						$Core_Html_Entity_Checkbox = Core::factory('Core_Html_Entity_Input')
							->type('checkbox')
							->name("create_small_image_from_large_{$this->smallImage['name']}")
							->id("create_small_image_from_large_{$this->smallImage['name']}")
							->value(1);

						if ($this->smallImage['create_small_image_from_large_checked'])
						{
							$Core_Html_Entity_Checkbox
								->checked('checked');
						};

						$oSmallWatermark_Div
							->add(
								Core::factory('Core_Html_Entity_Div')
								->class('form-group col-xs-12')
								->add(
									Core::factory('Core_Html_Entity_Label')
										->class('checkbox-inline')
										->value(Core::_('Admin_Form.create_thumbnail'))
										->add($Core_Html_Entity_Checkbox)
										->add(
											Core::factory('Core_Html_Entity_Span')
												->class('text')
										)
								)
							)
							->add(
								Core::factory('Core_Html_Entity_Div')
									->class('clearfix')
							);
					}

					// Отображать Сохранять пропорции изображения
					if ($this->smallImage['preserve_aspect_ratio_checkbox'])
					{
						$Core_Html_Entity_Checkbox = Core::factory('Core_Html_Entity_Input')
							->type('checkbox')
							->name("small_preserve_aspect_ratio_{$this->smallImage['name']}")
							->id("small_preserve_aspect_ratio_{$this->smallImage['name']}")
							->value(1);

						if ($this->smallImage['preserve_aspect_ratio_checkbox_checked'])
						{
							$Core_Html_Entity_Checkbox
								->checked('checked');
						};

						$oSmallWatermark_Div
							->add(
								Core::factory('Core_Html_Entity_Div')
								->class('form-group col-xs-12')
								->add(
									Core::factory('Core_Html_Entity_Label')
										->class('checkbox-inline')
										->value(Core::_('Admin_Form.image_preserve_aspect_ratio'))
										->add($Core_Html_Entity_Checkbox)
										->add(
											Core::factory('Core_Html_Entity_Span')
												->class('text')
										)
								)
							)
							->add(
								Core::factory('Core_Html_Entity_Div')
									->class('clearfix')
							);
					}

					// Наложить водяной знак на изображение
					if ($this->smallImage['place_watermark_checkbox'] == 1)
					{
						$Core_Html_Entity_Checkbox = Core::factory('Core_Html_Entity_Input')
							->type('checkbox')
							->name("small_place_watermark_checkbox_{$this->smallImage['name']}")
							->id("small_place_watermark_checkbox_{$this->smallImage['name']}")
							->value(1);

						if ($this->smallImage['place_watermark_checkbox_checked'])
						{
							$Core_Html_Entity_Checkbox
								->checked('checked');
						};

						$oSmallWatermark_Div
							->add(
								Core::factory('Core_Html_Entity_Div')
								->class('form-group col-xs-12')
								->add(
									Core::factory('Core_Html_Entity_Label')
										->class('checkbox-inline')
										->value(Core::_('Admin_Form.place_watermark'))
										->add($Core_Html_Entity_Checkbox)
										->add(
											Core::factory('Core_Html_Entity_Span')
												->class('text')
										)
								)
							)
							->add(
								Core::factory('Core_Html_Entity_Div')
									->class('clearfix')
							);
					}

					if ($this->smallImage['show_description'])
					{
						$oLarge_Main_Block_Core_Html_Entity_Div
							->add(
								Core::factory('Core_Html_Entity_Div')
								->class('form-group col-xs-12 col-sm-6')
								->add(
									Core::factory('Core_Html_Entity_Span')
										->class('caption')
										->value(Core::_('Admin_Form.file_description'))
								)
								->add(
									Core::factory('Core_Html_Entity_Input')
										->type('text')
										->name("description_{$this->smallImage['name']}")
										->class('form-control description-small')
										->value($this->smallImage['description'])
								)
							);
					}

					$oSmall_Input_Group_Div
						->add(
							Core::factory('Core_Html_Entity_Span')
								->id('file_small_settings_' . $iAdmin_Form_Count)
								->class('input-group-addon control-item')
								->addAllowedProperty('data-title')
								->set('data-title', '<b>' . Core::_('Admin_Form.window_small_image') . '</b>')
								->add(
									Admin_Form_Entity::factory('Code')->html('<i class="fa fa-cog"></i>')
								)
						)
						->add($oSmallWatermark_Div);
				}

				// Быстрый просмотр малого изображения
				if ($this->smallImage['path'] != '')
				{
					if (Core_File::isValidExtension($this->smallImage['path'], array('jpg', 'jpeg', 'gif', 'png')))
					{
						$prefixRand = strpos($this->smallImage['path'], '?') === FALSE
							? '?'
							: '&';

						$oSmall_Input_Group_Div->add(Core::factory('Core_Html_Entity_Script')
							->value('$(function(){
								$("#' . $windowId . ' #file_preview_' . $this->smallImage['id'] . '").popover({
									content: \'<img src="' . $this->smallImage['path'] . $prefixRand . 'rnd=' . rand() . '" style="max-width:200px" />\',
									html: true,
									placement: \'top\',
									container: $(\'#file_small_' . $iAdmin_Form_Count . '\'),
									trigger: "hover"
								});
							});'
						));
					}
				}
			}
		}

		foreach ($this->_children as $oCore_Html_Entity)
		{
			$oLarge_Core_Html_Entity_Div->add($oCore_Html_Entity);
		}

		$oLarge_Core_Html_Entity_Div
			->add(
					Core::factory('Core_Html_Entity_Div')
						->style('clear: both')
				)
			->execute();
	}

	protected function _getIcon($originalName)
	{
		$ext = Core_File::getExtension($originalName);

		switch ($ext)
		{
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
			case 'bmp':
			case 'webp':
				$class = 'fa fa-file-image-o image-color';
			break;
			case 'pdf':
				$class = 'fa fa-file-pdf-o pdf-color';
			break;
			case 'xls':
			case 'xlsx':
			case 'csv':
				$class = 'fa fa-file-excel-o excel-color';
			break;
			case 'doc':
			case 'docx':
				$class = 'fa fa-file-word-o word-color';
			break;
			case 'txt':
			case 'rtf':
				$class = 'fa fa-file-text-o text-color';
			break;
			case 'zip':
			case 'gz':
			case 'rar':
			case 'tar':
				$class = 'fa fa-file-archive-o archive-color';
			break;
			default:
				$class = 'fa fa-file-o default-color';
		}

		return $class;
	}
}