<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Admin forms.
 *
 * @package HostCMS
 * @subpackage Skin
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2020 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Skin_Bootstrap_Admin_Form_Controller_List extends Admin_Form_Controller_View
{
	 /**
	 * Is showing filter necessary
	 * @var boolean
	 */
	protected $_showFilter = FALSE;

	protected function _isFilterNecessary()
	{
		$oAdmin_Form = $this->_Admin_Form_Controller->getAdminForm();

		// Is filter necessary
		$aAdmin_Form_Fields = $oAdmin_Form->Admin_Form_Fields->findAll();
		foreach ($aAdmin_Form_Fields as $oAdmin_Form_Field)
		{
			// Перекрытие параметров для данного поля
			$oAdmin_Form_Field_Changed = $oAdmin_Form_Field;

			$aDatasets = $this->_Admin_Form_Controller->getDatasets();

			foreach ($aDatasets as $datasetKey => $oTmpAdmin_Form_Dataset)
			{
				$oAdmin_Form_Field_Changed = $this->_Admin_Form_Controller->changeField($oTmpAdmin_Form_Dataset, $oAdmin_Form_Field_Changed);
			}

			if ($oAdmin_Form_Field_Changed->allow_filter || $oAdmin_Form_Field_Changed->view == 1)
			{
				$this->_showFilter = TRUE;
				break;
			}
		}

		return $this;
	}

	 /**
	 * Is showing ChangeViews necessary
	 * @var boolean
	 */
	protected $_showChangeViews = TRUE;

	protected function _topMenuBar()
	{
		?><div class="table-toolbar">
			<?php
			Core_Event::notify('Admin_Form_Controller.onBeforeShowMenu', $this->_Admin_Form_Controller);
			?>
			<?php $this->_Admin_Form_Controller->showFormMenus()?>
			<div class="table-toolbar-right pull-right">
				<?php $this->_pageSelector()?>
				<?php $this->_showChangeViews && $this->_Admin_Form_Controller->showChangeViews()?>
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}

	public function execute()
	{
		$oAdmin_Form_Controller = $this->_Admin_Form_Controller;

		$oAdmin_View = Admin_View::create($this->_Admin_Form_Controller->Admin_View)
			->pageTitle($oAdmin_Form_Controller->pageTitle)
			->module($oAdmin_Form_Controller->module);

		$aAdminFormControllerChildren = array();

		foreach ($oAdmin_Form_Controller->getChildren() as $oAdmin_Form_Entity)
		{
			if ($oAdmin_Form_Entity instanceof Skin_Bootstrap_Admin_Form_Entity_Breadcrumbs
				|| $oAdmin_Form_Entity instanceof Skin_Bootstrap_Admin_Form_Entity_Menus)
			{
				$oAdmin_View->addChild($oAdmin_Form_Entity);
			}
			else
			{
				$aAdminFormControllerChildren[] = $oAdmin_Form_Entity;
			}
		}

		$this->_isFilterNecessary();

		// При показе формы могут быть добавлены сообщения в message, поэтому message показывается уже после отработки формы
		ob_start();
		$this->_topMenuBar();
		foreach ($aAdminFormControllerChildren as $oAdmin_Form_Entity)
		{
			$oAdmin_Form_Entity->execute();
		}

		$this->_showContent();
		$this->_showFooter();
		$content = ob_get_clean();

		$oAdmin_View
			->content($content)
			->message($oAdmin_Form_Controller->getMessage())
			->show();

		$oAdmin_Form_Controller->applyEditable();

		$oAdmin_Form_Controller->showSettings();

		return $this;
	}

	/**
	 * Show items count selector
	 */
	protected function _pageSelector()
	{
		$oAdmin_Form_Controller = $this->_Admin_Form_Controller;

		$sCurrentValue = $oAdmin_Form_Controller->limit;

		$windowId = Core_Str::escapeJavascriptVariable($oAdmin_Form_Controller->getWindowId());
		$additionalParams = Core_Str::escapeJavascriptVariable(
			str_replace(array('"'), array('&quot;'), $oAdmin_Form_Controller->additionalParams)
		);
 		$path = Core_Str::escapeJavascriptVariable($oAdmin_Form_Controller->getPath());

		// TOP FILTER
		if ($this->_showFilter)
		{
			$oCore_Html_Entity_Span = Core::factory('Core_Html_Entity_Span')
				->class('btn btn-sm btn-default margin-right-10')
				->id('showTopFilterButton')
				->onclick('$.toggleFilter(); $.changeFilterStatus({ path: \'' . $path . '\', show: +$(".topFilter").is(":visible") })')
				->title(Core::_('Admin_Form.filter'))
				->add(
					Core::factory('Core_Html_Entity_I')->class('fa fa-filter no-margin')
				);

			$iFilters = count(Core_Array::get($oAdmin_Form_Controller->filterSettings, 'tabs', array()));

			if ($iFilters > 1)
			{
				$oCore_Html_Entity_Span->add(
					Core::factory('Core_Html_Entity_Span')
						->class('badge badge-orange')
						->value($iFilters - 1)
				);
			}

			$oCore_Html_Entity_Span->execute();
		}

		// CSV Export
		$oCore_Html_Entity_Span = Core::factory('Core_Html_Entity_A')
			->class('btn btn-sm btn-default margin-right-10')
			->id('showTopFilterButton')
			->href($oAdmin_Form_Controller->getAdminLoadHref($oAdmin_Form_Controller->getPath()) . '&hostcms[export]=csv')
			->title(Core::_('Admin_Form.export_csv'))
			->target('_blank')
			->add(
				Core::factory('Core_Html_Entity_I')->class('fa fa-upload no-margin')
			)
			->execute();

		$oAdmin_Form_Controller->pageSelector();
	}

	/**
	 * Show form footer
	 * @hostcms-event Admin_Form_Controller.onBeforeShowFooter
	 * @hostcms-event Admin_Form_Controller.onAfterShowFooter
	 */
	public function _showFooter()
	{
		$oAdmin_Form_Controller = $this->_Admin_Form_Controller;

		$sShowNavigation = $oAdmin_Form_Controller->getTotalCount() > $oAdmin_Form_Controller->limit;

		Core_Event::notify('Admin_Form_Controller.onBeforeShowFooter', $oAdmin_Form_Controller);

		?><div class="DTTTFooter">
			<div class="row">
				<div class="col-xs-12 <?php echo $sShowNavigation ? 'col-sm-6 col-md-8' : ''?>">
					<?php $this->bottomActions()?>
				</div>
				<?php
				if ($sShowNavigation)
				{
					?><div class="col-xs-12 col-sm-6 col-md-4">
						<?php $oAdmin_Form_Controller->pageNavigation()?>
					</div><?php
				}
				?>
			</div>
		</div>
		<script>
			$(function (){
				// Sticky actions
				$('.DTTTFooter').addClass('sticky-actions');

				$(document).on("scroll", function () {
					// to bottom
					if ($(window).scrollTop() + $(window).height() == $(document).height()) {
						$('.DTTTFooter').removeClass('sticky-actions');
					}

					// to top
					if ($(window).scrollTop() + $(window).height() < $(document).height()) {
						$('.DTTTFooter').addClass('sticky-actions');
					}
				});
			});
		</script>
		<?php

		Core_Event::notify('Admin_Form_Controller.onAfterShowFooter', $oAdmin_Form_Controller);

		return $this;
	}

	/**
	 * Show Form Content
	 *
	 * @hostcms-event Admin_Form_Controller.onBeforeGetAdminActionLoadHref
	 * @hostcms-event Admin_Form_Controller.onBeforeGetAdminActionLoadAjax
	 * @hostcms-event Admin_Form_Controller.onBeforeShowField
	 * @hostcms-event Admin_Form_Controller.onAfterShowField
	 */
	protected function _showContent()
	{
		$oAdmin_Form_Controller = $this->_Admin_Form_Controller;
		$oAdmin_Form = $oAdmin_Form_Controller->getAdminForm();

		$oAdmin_Language = $oAdmin_Form_Controller->getAdminLanguage();

		$aAdmin_Form_Fields = $oAdmin_Form->Admin_Form_Fields->findAll();
		if (empty($aAdmin_Form_Fields))
		{
			throw new Core_Exception('Admin form does not have fields.');
		}

		$windowId = $oAdmin_Form_Controller->getWindowId();

		//Core_Event::notify('Admin_Form_Controller.onBeforeShowContent', $this);
		$oUser = Core_Auth::getCurrentUser();

		if (is_null($oUser))
		{
			return FALSE;
		}

		if ($this->_showFilter)
		{
			$aHide = array();
			$path = Core_Str::escapeJavascriptVariable($oAdmin_Form_Controller->getPath());

			$aTabs = Core_Array::get($oAdmin_Form_Controller->getFilterSettings(), 'tabs', array());
			?>
			<div class="tabbable topFilter" style="display: none" id="top-filter-<?php echo $oAdmin_Form->id?>">
				<ul class="nav nav-tabs tabs-flat" id="filterTabs">
					<?php
					//print_r($aTabs);
					!isset($aTabs['main']) && $aTabs['main'] = array();

					foreach ($aTabs as $tabName => $aTab)
					{
						$tabName = strval($tabName);
						$bMain = $tabName === 'main';

						$bCurrent = $oAdmin_Form_Controller->filterId === $tabName
							|| $oAdmin_Form_Controller->filterId === '' && $bMain;

						?><li id="filter-li-<?php echo htmlspecialchars($tabName)?>" <?php echo $bCurrent ? ' class="active tab-orange"' : ''?> data-filter-id="<?php echo htmlspecialchars($tabName)?>">
							<a data-toggle="tab" href="#filter-<?php echo htmlspecialchars($tabName)?>">
								<?php echo htmlspecialchars(
									$bMain
										? Core::_('Admin_Form.filter')
										: $aTab['caption']
								)?>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
				<div class="tab-content tabs-flat">
					<?php
					$filterPrefix = 'topFilter_';
					foreach ($aTabs as $tabName => $aTab)
					{
						$tabName = strval($tabName);
						$bMain = $tabName === 'main';

						$bCurrent = $oAdmin_Form_Controller->filterId === $tabName
							|| $oAdmin_Form_Controller->filterId === '' && $bMain;

						?><div id="filter-<?php echo htmlspecialchars($tabName)?>" class="tab-pane<?php echo $bCurrent ? ' in active' : ''?>">
							<div id="horizontal-form">
								<form class="form-horizontal" role="form" action="<?php echo htmlspecialchars($oAdmin_Form_Controller->getPath())?>" data-filter-id="<?php echo htmlspecialchars($tabName)?>" method="POST">
									<?php
									// Top Filter
									foreach ($aAdmin_Form_Fields as $oAdmin_Form_Field)
									{
										// Перекрытие параметров для данного поля
										$oAdmin_Form_Field_Changed = $oAdmin_Form_Field;

										$aDatasets = $oAdmin_Form_Controller->getDatasets();
										foreach ($aDatasets as $datasetKey => $oTmpAdmin_Form_Dataset)
										{
											$oAdmin_Form_Field_Changed = $oAdmin_Form_Controller->changeField($oTmpAdmin_Form_Dataset, $oAdmin_Form_Field_Changed);
										}

										if ($oAdmin_Form_Field_Changed->allow_filter && $oAdmin_Form_Field_Changed->view != 2 || $oAdmin_Form_Field_Changed->view == 1)
										{
											$Admin_Word_Value = $oAdmin_Form_Field
												->Admin_Word
												->getWordByLanguage($oAdmin_Language->id);

											$fieldName = $Admin_Word_Value && strlen($Admin_Word_Value->name) > 0
												? $Admin_Word_Value->name
												: NULL;

											if (!is_null($fieldName))
											{
												$sFormGroupId = $tabName . '-field-' . $oAdmin_Form_Field_Changed->id;

												$bHide = isset($aTabs[$tabName]['fields'][$oAdmin_Form_Field_Changed->name]['show'])
													&& $aTabs[$tabName]['fields'][$oAdmin_Form_Field_Changed->name]['show'] == 0;

												$bHide && $aHide[] = '#' . $sFormGroupId;

												$sInputId = "id_{$filterPrefix}{$oAdmin_Form_Field_Changed->id}";
												?><div class="form-group" id="<?php echo htmlspecialchars($sFormGroupId)?>">
													<label for="<?php echo htmlspecialchars($sInputId)?>" class="col-sm-2 control-label no-padding-right">
														<?php echo htmlspecialchars($fieldName)?>
													</label>
													<div class="col-sm-10">
														<?php
														$oAdmin_Form_Controller->showFilterField($oAdmin_Form_Field_Changed, $filterPrefix, $tabName);
														?>
													</div>
												</div><?php
											}
										}
									}
									?>
									<div class="form-group text-align-right">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-default" onclick="mainFormLocker.unlock(); <?php echo $oAdmin_Form_Controller->getAdminLoadAjax($oAdmin_Form_Controller->getPath())?>"><?php echo Core::_('Admin_Form.button_to_filter')?></button>
											<div class="btn-group">
												<a class="btn btn-default dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-plus"></i>
												</a>
												<ul class="dropdown-menu dropdown-menu-right">
													<?php
													foreach ($aAdmin_Form_Fields as $oAdmin_Form_Field)
													{
														if ($oAdmin_Form_Field->allow_filter && $oAdmin_Form_Field->view != 2 || $oAdmin_Form_Field->view == 1)
														{
															$Admin_Word_Value = $oAdmin_Form_Field
																->Admin_Word
																->getWordByLanguage($oAdmin_Language->id);

															$fieldName = $Admin_Word_Value && strlen($Admin_Word_Value->name) > 0
																? $Admin_Word_Value->name
																: NULL;

															if (!is_null($fieldName))
															{
																$class = isset($aTabs[$tabName]['fields'][$oAdmin_Form_Field->name]['show'])
																	&& $aTabs[$tabName]['fields'][$oAdmin_Form_Field->name]['show'] == 0
																	? ''
																	: ' fa-check';

																?><li>
																	<a data-filter-field-id="<?php echo htmlspecialchars($tabName) . '-field-' . $oAdmin_Form_Field->id?>" onclick="$.changeFilterField({ path: '<?php echo $path?>', tab: '<?php echo htmlspecialchars($tabName)?>', field: '<?php echo Core_Str::escapeJavascriptVariable($oAdmin_Form_Field->name)?>', context: this })"><i class="dropdown-icon fa<?php echo $class?>"></i> <?php echo htmlspecialchars($fieldName)?></a>
																</li><?php
															}
														}
													}
													?>
												</ul>
											</div>

											<div class="btn-group">
												<a class="btn btn-default dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-gear"></i>
												</a>
												<ul class="dropdown-menu dropdown-menu-right">
													<li>
														<a href="javascript:void(0);" onclick="$.filterSaveAs('<?php echo Core::_('Admin_Form.filter_enter_title')?>', $(this), '<?php echo Core_Str::escapeJavascriptVariable(str_replace(array('"'), array('&quot;'), $oAdmin_Form_Controller->additionalParams))?>')"><?php echo Core::_('Admin_Form.saveAs')?></a>
														<?php if (!$bMain) {
														?>
														<a href="javascript:void(0);" onclick="$.filterSave($(this))"><?php echo Core::_('Admin_Form.save')?></a>
														<?php
														$sDelete = Core::_('Admin_Form.delete');
														?>
														<a href="javascript:void(0);" onclick="res = confirm('<?php echo htmlspecialchars(Core::_('Admin_Form.confirm_dialog', $sDelete))?>'); if (res) { $.filterDelete($(this)) } return res;"><?php echo $sDelete?></a>
														<?php
														}
														?>
													</li>
												</ul>
											</div>

											<a class="btn btn-default" title="<?php echo Core::_('Admin_Form.clear')?>" onclick="$.clearTopFilter('<?php echo Core_Str::escapeJavascriptVariable($windowId)?>')"><i class="fa fa-times-circle no-margin"></i></a>
										</div>
									</div>
								</form>
							</div>
						</div>
						<?php
					}

					if (count($aHide))
					{
						?><script>$('<?php echo implode(',', $aHide)?>').hide();</script><?php
					}
					?>
				</div>
			</div>
		<?php
		}

		$oSortingField = $oAdmin_Form_Controller->getSortingField();
		?>
		<div class="admin-table-wrap table-scrollable no-border">
			<table class="admin-table table table-hover table-striped" id="admin-table-<?php echo $oAdmin_Form->id?>">
				<thead>
				<tr>
					<?php
					// Ячейку над групповыми чекбоксами показываем только при наличии действий
					if ($oAdmin_Form->show_operations && $oAdmin_Form_Controller->showOperations)
					{
						?><th class="action-checkbox">&nbsp;</th><?php
					}

					$allow_filter = FALSE;
					foreach ($aAdmin_Form_Fields as $oAdmin_Form_Field)
					{
						// 0 - Столбец и фильтр, 2 - Столбец
						if ($oAdmin_Form_Field->view == 0 || $oAdmin_Form_Field->view == 2)
						{
							// There is at least one filter
							$oAdmin_Form_Field->allow_filter && $allow_filter = TRUE;

							// Перекрытие параметров для данного поля
							$oAdmin_Form_Field_Changed = $oAdmin_Form_Field;

							$aDatasets = $oAdmin_Form_Controller->getDatasets();
							foreach ($aDatasets as $datasetKey => $oTmpAdmin_Form_Dataset)
							{
								$oAdmin_Form_Field_Changed = $oAdmin_Form_Controller->changeField($oTmpAdmin_Form_Dataset, $oAdmin_Form_Field_Changed);
							}

							$width = htmlspecialchars($oAdmin_Form_Field_Changed->width);
							$class = htmlspecialchars($oAdmin_Form_Field_Changed->class);

							$Admin_Word_Value = $oAdmin_Form_Field->Admin_Word->getWordByLanguage($oAdmin_Language->id);

							$fieldName = $Admin_Word_Value && strlen($Admin_Word_Value->name) > 0
								? htmlspecialchars($Admin_Word_Value->name)
								: '&mdash;';

							$oAdmin_Form_Field_Changed->allow_sorting
								&& is_object($oSortingField)
								&& $oAdmin_Form_Field->id == $oSortingField->id
								&& $class .= ' highlight';

							$sSortingClass = $sSortingOnClick = '';

							if ($oAdmin_Form_Field_Changed->allow_sorting)
							{
								//$hrefDown = $oAdmin_Form_Controller->getAdminLoadHref($oAdmin_Form_Controller->getPath(), NULL, NULL, NULL, NULL, NULL, $oAdmin_Form_Field->id, 1);
								$onclickDown = $oAdmin_Form_Controller->getAdminLoadAjax($oAdmin_Form_Controller->getPath(), NULL, NULL, NULL, NULL, NULL, $oAdmin_Form_Field->id, 1);

								//$hrefUp = $oAdmin_Form_Controller->getAdminLoadHref($oAdmin_Form_Controller->getPath(), NULL, NULL, NULL, NULL, NULL, $oAdmin_Form_Field->id, 0);
								$onclickUp = $oAdmin_Form_Controller->getAdminLoadAjax($oAdmin_Form_Controller->getPath(), NULL, NULL, NULL, NULL, NULL, $oAdmin_Form_Field->id, 0);

								if ($oAdmin_Form_Field->id == $oAdmin_Form_Controller->sortingFieldId)
								{
									$class .= $oAdmin_Form_Controller->sortingDirection == 1
										? ' sorting_desc'
										: ' sorting_asc';

									$sSortingOnClick = $oAdmin_Form_Controller->sortingDirection == 1
										? $onclickUp
										: $onclickDown;
								}
								else
								{
									$class .= ' sorting';
									$sSortingOnClick = $onclickUp;
								}
							}
							?><th title="<?php echo $fieldName?>" class="<?php echo trim($class)?>" <?php echo !empty($width) ? "width=\"{$width}\"" : ''?> onclick="if (event.target != event.currentTarget) return false; <?php echo $sSortingOnClick?>"><?php
								if (strlen($oAdmin_Form_Field_Changed->ico))
								{
									echo '<i class="' . htmlspecialchars($oAdmin_Form_Field_Changed->ico) . '" title="' . $fieldName . '"></i>';
								}
								else
								{
									echo $fieldName;
								}
							?></th><?php
						}
					}

					// Доступные действия для пользователя
					$aAllowed_Admin_Form_Actions = $oAdmin_Form->Admin_Form_Actions->getAllowedActionsForUser($oUser);

					if ($oAdmin_Form->show_operations && $oAdmin_Form_Controller->showOperations
						|| $allow_filter && $this->_showFilter)
					{
							$iSingleActionCount = 0;

							foreach ($aAllowed_Admin_Form_Actions as $o_Admin_Form_Action)
							{
								$o_Admin_Form_Action->single && $iSingleActionCount++;
							}

						?><th class="filter-action-<?php echo $iSingleActionCount?>">&nbsp;</th><?php
					}
					?>
				</tr><?php
			?><tr class="admin_table_filter"><?php
			// Чекбокс "Выбрать все" показываем только при наличии действий
			if ($oAdmin_Form->show_operations && $oAdmin_Form_Controller->showOperations)
			{
				?><td class="action-checkbox"><label><input type="checkbox" name="admin_forms_all_check" id="id_admin_forms_all_check" onclick="$('#<?php echo $windowId?>').highlightAllRows(this.checked)" class="form-control"/><span class="text"></span></label></td><?php
			}

			// Main Filter
			foreach ($aAdmin_Form_Fields as $oAdmin_Form_Field)
			{
				// 0 - Столбец и фильтр, 2 - Столбец
				if ($oAdmin_Form_Field->view == 0 || $oAdmin_Form_Field->view == 2)
				{
					// Перекрытие параметров для данного поля
					$oAdmin_Form_Field_Changed = $oAdmin_Form_Field;

					$aDatasets = $oAdmin_Form_Controller->getDatasets();
					foreach ($aDatasets as $datasetKey => $oTmpAdmin_Form_Dataset)
					{
						$oAdmin_Form_Field_Changed = $oAdmin_Form_Controller->changeField($oTmpAdmin_Form_Dataset, $oAdmin_Form_Field_Changed);
					}

					$width = htmlspecialchars($oAdmin_Form_Field_Changed->width);
					$class = htmlspecialchars($oAdmin_Form_Field_Changed->class);

					// Подсвечивать
					$oAdmin_Form_Field_Changed->allow_sorting
						&& is_object($oSortingField)
						&& $oAdmin_Form_Field->id == $oSortingField->id
						&& $class .= ' highlight';

					?><td class="<?php echo trim($class)?>" <?php echo !empty($width) ? "width=\"{$width}\"" : ''?>><?php

					if ($oAdmin_Form_Field_Changed->allow_filter)
					{
						$filterPrefix = 'admin_form_filter_';
						$oAdmin_Form_Controller->showFilterField($oAdmin_Form_Field_Changed, $filterPrefix);
					}
					else
					{
						// Фильтр не разрешен.
						?><div style="color: #CEC3A3; text-align: center">&mdash;</div><?php
					}
					?></td><?php
				}
			}

			// Фильтр показываем если есть события или хотя бы у одного есть фильтр
			if ($oAdmin_Form->show_operations && $oAdmin_Form_Controller->showOperations
				|| $allow_filter && $this->_showFilter)
			{
				$onclick = $oAdmin_Form_Controller->getAdminLoadAjax($oAdmin_Form_Controller->getPath());

				?><td class="apply-button"><?php
					?>
					<div class="btn-group">
						<a class="btn btn-xs btn-palegreen" id="admin_forms_apply_button" title="<?php echo Core::_('Admin_Form.button_to_filter')?>" onclick="mainFormLocker.unlock(); <?php echo $onclick?>"><i class="fa fa-search"></i></a>
						<a title="<?php echo Core::_('Admin_Form.clear')?>" class="btn btn-xs btn-magenta" onclick="$.clearFilter('<?php echo $windowId?>')"><i class="fa fa-times-circle"></i></a>
					</div><?php
				?></td><?php
			}
			?></tr>
			</thead><?php

			// Устанавливаем ограничения на источники
			$oAdmin_Form_Controller->setDatasetConditions();

			$aDatasets = $oAdmin_Form_Controller->getDatasets();
			foreach ($aDatasets as $datasetKey => $oAdmin_Form_Dataset)
			{
				// Добавляем внешнюю замену по датасету
				$oAdmin_Form_Controller->AddExternalReplace('{dataset_key}', $datasetKey);

				$quotedDatasetKey = htmlspecialchars($datasetKey);
				$escapedDatasetKey = Core_Str::escapeJavascriptVariable($oAdmin_Form_Controller->jQueryEscape($datasetKey));

				$aDataFromDataset = $oAdmin_Form_Dataset->load();

				if (!empty($aDataFromDataset))
				{
					foreach ($aDataFromDataset as $oEntity)
					{
						try
						{
							$key_field_name = $oAdmin_Form->key_field;
							$entityKey = $oEntity->$key_field_name;

							// Экранируем ' в имени индексного поля, т.к. дальше это значение пойдет в JS
							$quotedEntityKey = htmlspecialchars($entityKey);
							$escapedEntityKey = Core_Str::escapeJavascriptVariable($oAdmin_Form_Controller->jQueryEscape(htmlspecialchars($entityKey)));

							/*$entityKey = str_replace(
								array("'", '%'),
								array("\'", '\\%'),
								$entityKey
							);*/
						}
						catch (Exception $e)
						{
							Core_Message::show('Caught exception: ' . $e->getMessage() . "\n", 'error');
							$entityKey = NULL;
						}

						?><tr id="row_<?php echo $quotedDatasetKey?>_<?php echo $quotedEntityKey?>">
						<?php
						// Чекбокс "Для элемента" показываем только при наличии действий
						if ($oAdmin_Form->show_operations && $oAdmin_Form_Controller->showOperations)
						{
							?><td class="action-checkbox">
								<label><input type="checkbox" id="check_<?php echo $quotedDatasetKey?>_<?php echo $quotedEntityKey?>" onclick="$('#<?php echo $windowId?>').setTopCheckbox(); $('#' + $.getWindowId('<?php echo $windowId?>') + ' #row_<?php echo $escapedDatasetKey?>_<?php echo $escapedEntityKey?>').toggleHighlight()" /><span class="text"></span></label><?php
							?></td><?php
						}

						foreach ($aAdmin_Form_Fields as $oAdmin_Form_Field)
						{
							// 0 - Столбец и фильтр, 2 - Столбец
							if ($oAdmin_Form_Field->view == 0 || $oAdmin_Form_Field->view == 2)
							{
								// Перекрытие параметров для данного поля
								$oAdmin_Form_Field_Changed = $oAdmin_Form_Controller->changeField($oAdmin_Form_Dataset, $oAdmin_Form_Field);

								// Параметры поля.
								$width = htmlspecialchars(trim($oAdmin_Form_Field_Changed->width));
								$class = htmlspecialchars($oAdmin_Form_Field_Changed->class);

								$oAdmin_Form_Field->allow_sorting
									&& is_object($oSortingField)
									&& $oAdmin_Form_Field->id == $oSortingField->id
									&& $class .= ' highlight';

								?><td class="<?php echo trim($class)?>" <?php echo !empty($width) ? "width=\"{$width}\"" : ''?>><?php

								$fieldName = $oAdmin_Form_Controller->getFieldName($oAdmin_Form_Field_Changed->name);

								// Badges
								$badgesMethodName = $fieldName . 'Badge';
								$bBadge = $oAdmin_Form_Controller->isCallable($oEntity, $badgesMethodName);

								if ($bBadge)
								{
									?><div style="position: relative"><?php
								}
								
								// Backends
								$aTmpFieldName = explode('.', $oAdmin_Form_Field_Changed->name);
								$backendName = (isset($aTmpFieldName[1]) ? $aTmpFieldName[1] : $aTmpFieldName[0]) . 'Backend';

								try
								{
									Core_Event::notify('Admin_Form_Controller.onBeforeShowField', $oAdmin_Form_Controller, array($oEntity, $oAdmin_Form_Field));

									if ($oAdmin_Form_Field_Changed->type != 10 && !$oAdmin_Form_Controller->isCallable($oEntity, $backendName))
									{
										if (isset($oEntity->$fieldName))
										{
											// значение свойства
											$value = htmlspecialchars($oEntity->$fieldName);
										}
										elseif ($oAdmin_Form_Controller->isCallable($oEntity, $fieldName))
										{
											// Выполним функцию обратного вызова
											$value = htmlspecialchars($oEntity->$fieldName($oAdmin_Form_Field_Changed, $oAdmin_Form_Controller));
										}
										else
										{
											$value = NULL;
										}

										$element_name = "apply_check_{$quotedDatasetKey}_{$quotedEntityKey}_fv_{$oAdmin_Form_Field_Changed->id}";

										$sCheckSelector = "check_{$escapedDatasetKey}_{$escapedEntityKey}";
										// Формат не экранируем, т.к. он может содержать теги
										$sFormat = $oAdmin_Form_Field_Changed->format;

										// Отображения элементов полей, в зависимости от их типа.
										switch ($oAdmin_Form_Field_Changed->type)
										{
											case 1: // Текст.
												if (!is_null($value))
												{
													?><span id="<?php echo $element_name?>"<?php echo $oAdmin_Form_Field_Changed->editable ? ' class="editable"' : ''?>><?php
													echo $oAdmin_Form_Controller->applyFormat($value, $sFormat)?></span><?php
												}
											break;
											case 2: // Поле ввода.
												if (!is_null($value))
												{
													?><input type="text" name="<?php echo $element_name?>" id="<?php echo $element_name?>" value="<?php echo $value?>" onchange="$.setCheckbox('<?php echo $windowId?>', '<?php echo $sCheckSelector?>'); $('#' + $.getWindowId('<?php echo $windowId?>') + ' #row_<?php echo $escapedDatasetKey?>_<?php echo $escapedEntityKey?>').toggleHighlight()" onkeydown="$.setCheckbox('<?php echo $windowId?>', '<?php echo $sCheckSelector?>'); $('#' + $.getWindowId('<?php echo $windowId?>') + ' #row_<?php echo $escapedDatasetKey?>_<?php echo $escapedEntityKey?>').toggleHighlight()" class="form-control input-xs" /><?php
												}
											break;
											case 3: // Checkbox.
												?><label><input type="checkbox" name="<?php echo $element_name?>" id="<?php echo $element_name?>" <?php echo intval($value) ? 'checked="checked"' : ''?> onclick="$.setCheckbox('<?php echo $windowId?>', '<?php echo $sCheckSelector?>'); $('#' + $.getWindowId('<?php echo $windowId?>') + ' #row_<?php echo $escapedDatasetKey?>_<?php echo $escapedEntityKey?>').toggleHighlight();" value="1" /><span class="text"></span></label><?php
											break;
											case 4: // Ссылка.
												$link = htmlspecialchars($oAdmin_Form_Field_Changed->link);
												$onclick = htmlspecialchars($oAdmin_Form_Field_Changed->onclick);

												//$link_text = trim($value);
												$link_text = $oAdmin_Form_Controller->applyFormat($value, $sFormat);

												$link = $oAdmin_Form_Controller->doReplaces($aAdmin_Form_Fields, $oEntity, $link);
												$onclick = $oAdmin_Form_Controller->doReplaces($aAdmin_Form_Fields, $oEntity, $onclick, 'onclick');

												if (mb_strlen($link_text))
												{
													?><a href="<?php echo $link?>" <?php echo (!empty($onclick)) ? "onclick=\"{$onclick}\"" : ''?>><?php echo $link_text?></a><?php
												}
												else
												{
													?>&nbsp;<?php
												}
											break;
											case 5: // Дата-время.
												if (!is_null($value))
												{
													$value = $value == '0000-00-00 00:00:00' || $value == ''
														? ''
														: Core_Date::sql2datetime($value);

													if ($oAdmin_Form_Field_Changed->editable)
													{
														$sCurrentLng = Core_I18n::instance()->getLng();

														?><div class="row">
															<div class="date col-xs-12">
																<input id="<?php echo $element_name?>" name="<?php echo $element_name?>" size="auto" type="text" value="<?php echo htmlspecialchars($value)?>" class="form-control input-sm" />
															</div>
														</div>
														<script type="text/javascript">
														(function($) {
															var el = $('#<?php echo $windowId?> #<?php echo $element_name?>');
															el.datetimepicker({
																locale: '<?php echo $sCurrentLng?>',
																format: '<?php echo Core::$mainConfig['dateTimePickerFormat']?>',
																useCurrent: false
															})
															.on('dp.change', function(){
																$.setCheckbox('<?php echo $windowId?>', '<?php echo $sCheckSelector?>');
															})
															.on('click', function(){
																$(this).trigger('focus')
															});
															el.closest('td').css('overflow','visible');
														})(jQuery);
														</script><?php
													}
													else
													{
														?><span id="<?php echo $element_name?>"><?php echo $oAdmin_Form_Controller->applyFormat($value, $sFormat)?></span><?php
													}

													/*?><span id="<?php echo $element_name?>"<?php echo $oAdmin_Form_Field_Changed->editable ? ' class="editable"' : ''?>><?php echo $oAdmin_Form_Controller->applyFormat($value, $sFormat)?></span><?php*/
												}
											break;
											case 6: // Дата.
												if (!is_null($value))
												{
													$value = $value == '0000-00-00 00:00:00' || $value == ''
														? ''
														: Core_Date::sql2date($value);

													if ($oAdmin_Form_Field_Changed->editable)
													{
														$sCurrentLng = Core_I18n::instance()->getLng();

														?><div class="row">
															<div class="date col-xs-12">
																<input id="<?php echo $element_name?>" name="<?php echo $element_name?>" size="auto" type="text" value="<?php echo htmlspecialchars($value)?>" class="form-control input-sm" />
															</div>
														</div>
														<script type="text/javascript">
														(function($) {
															var el = $('#<?php echo $windowId?> #<?php echo $element_name?>');
															el.datetimepicker({
																locale: '<?php echo $sCurrentLng?>',
																format: '<?php echo Core::$mainConfig['datePickerFormat']?>',
																useCurrent: false
															})
															.on('dp.change', function(){
																$.setCheckbox('<?php echo $windowId?>', '<?php echo $sCheckSelector?>');
															})
															.on('click', function(){
																$(this).trigger('focus')
															});
															el.closest('td').css('overflow','visible');
														})(jQuery);
														</script><?php
													}
													else
													{
														?><span id="<?php echo $element_name?>"><?php echo $oAdmin_Form_Controller->applyFormat($value, $sFormat)?></span><?php
													}

													/*?><span id="<?php echo $element_name?>"<?php echo $oAdmin_Form_Field_Changed->editable ? ' class="editable"' : ''?>><?php
													echo $oAdmin_Form_Controller->applyFormat($value, $sFormat)?></span><?php*/
												}
											break;
											case 7: // Картинка-ссылка.
												$link = $oAdmin_Form_Field_Changed->link;
												$onclick = $oAdmin_Form_Field_Changed->onclick;

												$link = $oAdmin_Form_Controller->doReplaces($aAdmin_Form_Fields, $oEntity, $link);
												$onclick = $oAdmin_Form_Controller->doReplaces($aAdmin_Form_Fields, $oEntity, $onclick, 'onclick');

												// ALT-ы к картинкам
												// TITLE-ы к картинкам
												$alt_array = $title_array = $value_array = $ico_array = array();

												/*
												Разделяем варианты значений на строки, т.к. они приходят к нам в виде:
												0 = /images/off.gif
												1 = /images/on.gif
												*/
												$aImageExplode = explode("\n", $oAdmin_Form_Field_Changed->image);

												foreach ($aImageExplode as $str_value)
												{
													// Каждую строку разделяем по равно
													$str_explode = explode('=', $str_value);

													if (count($str_explode) > 1)
													{
														$mIndex = trim($str_explode[0]);
														// сохраняем в массив варинаты значений и ссылки для них
														$value_array[$mIndex] = trim($str_explode[1]);

														// Если указано альтернативное значение для картинки - добавим его в alt и title
														if (isset($str_explode[2])
															&& trim($value) == $mIndex)
														{
															$sTmp = trim($str_explode[2]);

															$lngAltName = 'Admin_Form.' . $sTmp;
															if (Core_I18n::instance()->check($lngAltName))
															{
																$sTmp = Core::_($lngAltName);
															}

															$alt_array[$mIndex] = $title_array[$mIndex] = $sTmp;
														}

														// ICO
														isset($str_explode[3])
															&& $ico_array[$mIndex] = $str_explode[3];
													}
												}

												// Получаем заголовок столбца на случай, если для IMG не было указано alt-а или title
												$Admin_Word_Value = $oAdmin_Form_Field->Admin_Word->getWordByLanguage(
													$oAdmin_Language->id
												);

												$fieldCaption = $Admin_Word_Value
													? htmlspecialchars($Admin_Word_Value->name)
													: "&mdash;";

												if (empty($alt_array[$value]))
												{
													$alt_array[$value] = $fieldCaption;
												}

												if (empty($title_array[$value]))
												{
													$title_array[$value] = $fieldCaption;
												}

												if (isset($value_array[$value]))
												{
													$src = $value_array[$value];
												}
												elseif (isset($value_array['']))
												{
													$src = $value_array[''];
												}
												else
												{
													$src = NULL;
												}

												if (isset($ico_array[$value]))
												{
													$ico = $ico_array[$value];
												}
												elseif (isset($ico_array['']))
												{
													$ico = $ico_array[''];
												}
												else
												{
													$ico = NULL;
												}

												// Отображаем картинку ссылкой
												if (!empty($link) && !is_null($src))
												{
													?><a href="<?php echo $link?>" onclick="$('#' + $.getWindowId('<?php echo $windowId?>') + ' #row_<?php echo $escapedDatasetKey?>_<?php echo $escapedEntityKey?>').toggleHighlight();<?php echo $onclick?>"><?php
												}

												// Отображаем картинку без ссылки
												if (!is_null($ico))
												{
													?><i class="<?php echo htmlspecialchars($ico)?>" title="<?php echo htmlspecialchars(Core_Array::get($title_array, $value))?>"></i><?php
												}
												elseif (!is_null($src))
												{
													?><img src="<?php echo htmlspecialchars($src)?>" alt="<?php echo htmlspecialchars(Core_Array::get($alt_array, $value))?>" title="<?php echo htmlspecialchars(Core_Array::get($title_array, $value))?>" /><?php
												}
												/*elseif (!empty($link) && !isset($value_array[$value]))
												{
													// Картинки для такого значения не найдено, но есть ссылка
													?><a href="<?php echo $link?>" onclick="$('#' + $.getWindowId('<?php echo $windowId?>') + ' #row_<?php echo $escapedDatasetKey?>_<?php echo $escapedEntityKey?>').toggleHighlight();<?php echo $onclick?> ">&mdash;</a><?php
												}*/
												else
												{
													// Картинки для такого значения не найдено
													?>&mdash;<?php
												}

												if (!empty($link) && !is_null($src))
												{
													?></a><?php
												}

											break;
											case 8: // Выпадающий список
												/*
												Разделяем варианты значений на строки, т.к. они приходят к нам в виде:
												0 = /images/off.gif
												1 = /images/on.gif
												*/
												?><select name="<?php echo $element_name?>" id="<?php echo $element_name?>" onchange="$.setCheckbox('<?php echo $windowId?>', '<?php echo $sCheckSelector?>')"><?php

												if (is_array($oAdmin_Form_Field_Changed->list))
												{
													$aValue = $oAdmin_Form_Field_Changed->list;
												}
												else
												{
													$aValue = array();

													$aListExplode = explode("\n", $oAdmin_Form_Field_Changed->list);
													foreach ($aListExplode as $str_value)
													{
														// Каждую строку разделяем по равно
														$str_explode = explode('=', $str_value);

														if (count($str_explode) > 1 /* && $str_explode[1] != '…'*/)
														{
															// сохраняем в массив варинаты значений и ссылки для них
															$aValue[trim($str_explode[0])] = trim($str_explode[1]);
														}
													}
												}

												foreach ($aValue as $optionValue => $optionName)
												{
													$selected = $value == $optionValue
														? ' selected = "selected" '
														: '';

													?><option value="<?php echo htmlspecialchars($optionValue)?>"<?php echo $selected?>><?php echo htmlspecialchars($optionName)?></option><?php
												}
												?>
												</select>
												<?php
											break;
											case 9: // Текст "AS IS"
												if (mb_strlen($value) != 0)
												{
													echo html_entity_decode($value, ENT_COMPAT, 'UTF-8');
												}
												else
												{
													?>&nbsp;<?php
												}
											break;
											default: // Тип не определен.
												?>&nbsp;<?php
											break;
										}
									}
									// Вычисляемое поле с помощью функции обратного вызова
									else
									{
										if ($oAdmin_Form_Controller->isCallable($oEntity, $backendName))
										{
											echo $oEntity->$backendName($oAdmin_Form_Field_Changed, $oAdmin_Form_Controller);
										}
										elseif ($oAdmin_Form_Controller->isCallable($oEntity, $fieldName))
										{
											echo $oEntity->$fieldName($oAdmin_Form_Field_Changed, $oAdmin_Form_Controller);
										}
										elseif (property_exists($oEntity, $fieldName))
										{
											echo $oEntity->$fieldName;
										}
									}
									Core_Event::notify('Admin_Form_Controller.onAfterShowField', $oAdmin_Form_Controller, array($oEntity, $oAdmin_Form_Field));
								}
								catch (Exception $e)
								{
									Core_Message::show('Caught exception: ' . $e->getMessage() . "\n", 'error');
								}

								// Badges
								//$badgesMethodName = $fieldName . 'Badge';
								//if ($oAdmin_Form_Controller->isCallable($oEntity, $badgesMethodName))
								if ($bBadge)
								{
									// Выполним функцию обратного вызова
									$oEntity->$badgesMethodName($oAdmin_Form_Field, $oAdmin_Form_Controller);
									?></div><?php
								}
								?></td><?php
							}
						}

						// Действия для строки в правом столбце
						if ($oAdmin_Form->show_operations && $oAdmin_Form_Controller->showOperations
							/*|| $allow_filter && $this->_showFilter*/)
						{
							$sContents = '';

							$oCore_Html_Entity_Ul = Core::factory('Core_Html_Entity_Ul')
								->class('dropdown-menu pull-right');

							?><td><?php

							$sActionsFullView = $sActionsShortView = '';

							$iActionsCount = 0;

							// Подмена массива действий через событие
							Core_Event::notify('Admin_Form_Controller.onBeforeShowActions', $oAdmin_Form_Controller, array($datasetKey, $oEntity, $aAllowed_Admin_Form_Actions));
							$aActions = Core_Event::getLastReturn();

							!is_array($aActions)
								&& $aActions = $aAllowed_Admin_Form_Actions;

							foreach ($aActions as $key => $o_Admin_Form_Action)
							{
								// Отображаем действие, только если разрешено.
								if (!$o_Admin_Form_Action->single)
								{
									continue;
								}

								// Проверяем, привязано ли действие к определенному dataset'у.
								if ($o_Admin_Form_Action->dataset != -1
									&& $o_Admin_Form_Action->dataset != $datasetKey)
								{
									continue;
								}

								// Если у модели есть метод checkBackendAccess(), то проверяем права на это действие, совершаемое текущим пользователем
								if (method_exists($oEntity, 'checkBackendAccess')
									&& !$oEntity->checkBackendAccess($o_Admin_Form_Action->name, $oUser))
								{
									continue;
								}

								$iActionsCount++;

								$Admin_Word_Value = $o_Admin_Form_Action->Admin_Word->getWordByLanguage($oAdmin_Language->id);

								$name = $Admin_Word_Value && strlen($Admin_Word_Value->name) > 0
									? htmlspecialchars($Admin_Word_Value->name)
									: '';

								Core_Event::notify('Admin_Form_Controller.onBeforeGetAdminActionLoadHref', $oAdmin_Form_Controller, array($o_Admin_Form_Action, $escapedDatasetKey, $escapedEntityKey));

								$mReturn = Core_Event::getLastReturn();
								$href = is_null($mReturn)
									? $oAdmin_Form_Controller->getAdminActionLoadHref($oAdmin_Form_Controller->getPath(), $o_Admin_Form_Action->name, NULL, $escapedDatasetKey, $escapedEntityKey)
									: $mReturn;

								Core_Event::notify('Admin_Form_Controller.onBeforeGetAdminActionLoadAjax', $oAdmin_Form_Controller, array($o_Admin_Form_Action, $escapedDatasetKey, $escapedEntityKey));

								$mReturn = Core_Event::getLastReturn();
								$onclick = is_null($mReturn)
									? $oAdmin_Form_Controller->getAdminActionLoadAjax($oAdmin_Form_Controller->getPath(), $o_Admin_Form_Action->name, NULL, $datasetKey, $entityKey)
									: $mReturn;

								// Добавляем установку метки для чекбокса и строки + добавлем уведомление, если необходимо
								if ($o_Admin_Form_Action->confirm)
								{
									$onclick = "res = confirm('" .
										htmlspecialchars(Core::_('Admin_Form.confirm_dialog', $name)) .
										"'); if (!res) { $('#{$windowId} #row_{$escapedDatasetKey}_{$escapedEntityKey}').toggleHighlight(); } else {{$onclick}} return res;";
								}

								$sActionsFullView .= '<a class="btn btn-xs btn-' . htmlspecialchars($o_Admin_Form_Action->color) .' " title="' . $name . '" href="' . $href . '" onclick="mainFormLocker.unlock(); ' . $onclick .'"><i class="' . htmlspecialchars($o_Admin_Form_Action->icon) . '"></i></a>';

								$sActionsShortView .= '<li><a title="' . $name . '" href="' . htmlspecialchars($href) . '" onclick="mainFormLocker.unlock(); ' . $onclick .'"><i class="' . htmlspecialchars($o_Admin_Form_Action->icon) . ' btn-sm btn-' . htmlspecialchars($o_Admin_Form_Action->color) . '"></i>' . $name . '</a></li>';
							}

							if ($iActionsCount)
							{
							?><div class="btn-group <?php echo $iActionsCount > 1 ? 'visible-md visible-lg' : ''?>">
								<?php echo $sActionsFullView?>
							</div><?php

								if ($iActionsCount > 1)
								{
								?>
								<div class="visible-xs visible-sm">
									<div class="btn-group">
											<button class="btn btn-palegreen btn-xs dropdown-toggle" data-toggle="dropdown" >
											<i class="fa fa-bars"></i>
										</button>
										<ul class="dropdown-menu actions-dropdown-menu dropdown-menu-right" role="menu">
										<?php echo $sActionsShortView?>
										</ul>
									</div>
								</div><?php
								}
							}
							?></td><?php
						}
						?></tr><?php
					}
				}
			}
			?>
			</table>
		</div>
		<?php

		if (Core_Array::get($oAdmin_Form_Controller->filterSettings, 'show'))
		{
			?><script>$.toggleFilter();</script><?php
		}

		//Core_Event::notify('Admin_Form_Controller.onAfterShowContent', $oAdmin_Form_Controller);

		return $this;
	}

	/**
	 * Show action panel in administration center
	 * @return self
	 */
	public function bottomActions()
	{
		$oAdmin_Form_Controller = $this->_Admin_Form_Controller;
		$oAdmin_Form = $oAdmin_Form_Controller->getAdminForm();

		$oAdmin_Language = $oAdmin_Form_Controller->getAdminLanguage();

		// Строка с действиями
		//if ($this->_showBottomActions)
		//{
			$windowId = $oAdmin_Form_Controller->getWindowId();

			// Текущий пользователь
			$oUser = Core_Auth::getCurrentUser();

			if (is_null($oUser))
			{
				return FALSE;
			}

			// Доступные действия для пользователя
			$aAllowed_Admin_Form_Actions = $oAdmin_Form->Admin_Form_Actions->getAllowedActionsForUser($oUser);

			// Групповые операции
			if ($oAdmin_Form->show_group_operations && !empty($aAllowed_Admin_Form_Actions))
			{
				?><div class="dataTables_actions"><?php
				$sActionsFullView = $sActionsShortView = '';

				$iGroupCount = 0;

				foreach ($aAllowed_Admin_Form_Actions as $o_Admin_Form_Action)
				{
					if ($o_Admin_Form_Action->group)
					{
						$iGroupCount++;

						$Admin_Word_Value = $o_Admin_Form_Action->Admin_Word->getWordByLanguage($oAdmin_Language->id);

						$text = $Admin_Word_Value && strlen($Admin_Word_Value->name) > 0
							? $Admin_Word_Value->name
							: '';

						$href = $oAdmin_Form_Controller->getAdminLoadHref($oAdmin_Form_Controller->getPath(), $o_Admin_Form_Action->name);
						$onclick = $oAdmin_Form_Controller->getAdminLoadAjax($oAdmin_Form_Controller->getPath(), $o_Admin_Form_Action->name);

						// Нужно подтверждение для действия
						if ($o_Admin_Form_Action->confirm)
						{
							$onclick = "res = confirm('" . Core::_('Admin_Form.confirm_dialog', htmlspecialchars($text)) . "'); if (res) { {$onclick} } else {return false}";

							$link_class = 'admin_form_action_alert_link';
						}
						else
						{
							$link_class = 'admin_form_action_link';
						}

						// ниже по тексту alt-ы и title-ы не выводятся, т.к. они дублируются текстовыми
						// надписями и при отключении картинок текст дублируется
						/* alt="<?php echo htmlspecialchars($text)?>"*/

						$sActionsFullView .= '<li><a title="' . htmlspecialchars($text) . '" href="' . $href . '" onclick="mainFormLocker.unlock(); ' . $onclick .'"><i class="' . htmlspecialchars($o_Admin_Form_Action->icon) . ' btn-sm btn-' . htmlspecialchars($o_Admin_Form_Action->color) . '"></i>' . htmlspecialchars($text) . '</a></li>';

						$sActionsShortView .= '<a href="' . htmlspecialchars($href) . '" onclick="mainFormLocker.unlock(); ' . $onclick . '" class="btn-labeled btn btn-'. htmlspecialchars($o_Admin_Form_Action->color) . '" ><i class="btn-label ' . htmlspecialchars($o_Admin_Form_Action->icon) . '"></i>' . htmlspecialchars($text) . '</a>';
					}
				}

				if ($iGroupCount > 1)
				{
					?><div class="visible-sm visible-xs">
						<div class="btn-group dropup">
							<a class="btn btn-palegreen dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bars icon-separator"></i>
								<?php echo Core::_('Admin_Form.actions')?>
							</a>
							<ul class="dropdown-menu">
							<?php echo $sActionsFullView?>
							</ul>
						</div>
					</div><?php
				}
				?><div <?php echo $iGroupCount > 1 ? 'class="hidden-sm hidden-xs"' : ''?>>
					<?php echo $sActionsShortView?>
				</div>
			</div>
			<?php
			}
		//}

		return $this;
	}

}