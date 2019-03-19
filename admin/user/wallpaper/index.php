<?php
/**
 * Administration center users.
 *
 * @package HostCMS
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2019 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
require_once('../../../bootstrap.php');

Core_Auth::authorization($sModule = 'user');

// Код формы
$iAdmin_Form_Id = 203;
$sAdminFormAction = '/admin/user/wallpaper/index.php';
$oAdmin_Form = Core_Entity::factory('Admin_Form', $iAdmin_Form_Id);

// Контроллер формы
$oAdmin_Form_Controller = Admin_Form_Controller::create($oAdmin_Form);
$oAdmin_Form_Controller
	->module(Core_Module::factory($sModule))
	->setUp()
	->path($sAdminFormAction)
	->title(Core::_('User_Wallpaper.title'))
	->pageTitle(Core::_('User_Wallpaper.title'));

// Меню формы
$oAdmin_Form_Entity_Menus = Admin_Form_Entity::factory('Menus');

// Элементы меню
$oAdmin_Form_Entity_Menus->add(
	Admin_Form_Entity::factory('Menu')
		->name(Core::_('Admin_Form.add'))
		->icon('fa fa-plus')
		->href(
			$oAdmin_Form_Controller->getAdminActionLoadHref($oAdmin_Form_Controller->getPath(), 'edit', NULL, 0, 0)
		)
		->onclick(
			$oAdmin_Form_Controller->getAdminActionLoadAjax($oAdmin_Form_Controller->getPath(), 'edit', NULL, 0, 0)
		)
);

// Добавляем все меню контроллеру
$oAdmin_Form_Controller->addEntity($oAdmin_Form_Entity_Menus);

// Элементы строки навигации
$oAdmin_Form_Entity_Breadcrumbs = Admin_Form_Entity::factory('Breadcrumbs');

// Элементы строки навигации
$oAdmin_Form_Entity_Breadcrumbs->add(
	Admin_Form_Entity::factory('Breadcrumb')
		->name(Core::_('User.ua_show_users_title'))
		->href(
			$oAdmin_Form_Controller->getAdminLoadHref('/admin/user/index.php', NULL, NULL, '')
		)
		->onclick(
			$oAdmin_Form_Controller->getAdminLoadAjax('/admin/user/index.php', NULL, NULL, '')
	)
)
->add(
	Admin_Form_Entity::factory('Breadcrumb')
		->name(Core::_('User_Wallpaper.title'))
		->href(
			$oAdmin_Form_Controller->getAdminLoadHref($oAdmin_Form_Controller->getPath())
		)
		->onclick(
			$oAdmin_Form_Controller->getAdminLoadAjax($oAdmin_Form_Controller->getPath())
	)
);

// Добавляем все хлебные крошки контроллеру
$oAdmin_Form_Controller->addEntity($oAdmin_Form_Entity_Breadcrumbs);

// Действие редактирования
$oAdmin_Form_Action = Core_Entity::factory('Admin_Form', $iAdmin_Form_Id)
	->Admin_Form_Actions
	->getByName('edit');

if ($oAdmin_Form_Action && $oAdmin_Form_Controller->getAction() == 'edit')
{
	$oUser_Wallpaper_Controller_Edit = Admin_Form_Action_Controller::factory(
		'User_Wallpaper_Controller_Edit', $oAdmin_Form_Action
	);

	$oUser_Wallpaper_Controller_Edit->addEntity($oAdmin_Form_Entity_Breadcrumbs);

	// Добавляем типовой контроллер редактирования контроллеру формы
	$oAdmin_Form_Controller->addAction($oUser_Wallpaper_Controller_Edit);
}

// Действие "Применить"
$oAdminFormActionApply = Core_Entity::factory('Admin_Form', $iAdmin_Form_Id)
	->Admin_Form_Actions
	->getByName('apply');

if ($oAdminFormActionApply && $oAdmin_Form_Controller->getAction() == 'apply')
{
	$oUserWallpaperControllerApply = Admin_Form_Action_Controller::factory(
		'Admin_Form_Action_Controller_Type_Apply', $oAdminFormActionApply
	);

	// Добавляем типовой контроллер редактирования контроллеру формы
	$oAdmin_Form_Controller->addAction($oUserWallpaperControllerApply);
}

// Действие "Удалить файл изображения"
$oAdminFormActionDeleteImageFile = Core_Entity::factory('Admin_Form', $iAdmin_Form_Id)
	->Admin_Form_Actions
	->getByName('deleteImageFile');

if ($oAdminFormActionDeleteImageFile && $oAdmin_Form_Controller->getAction() == 'deleteImageFile')
{
	$oUserWallpaperControllerDeleteImageFile = Admin_Form_Action_Controller::factory(
		'Admin_Form_Action_Controller_Type_Delete_File', $oAdminFormActionDeleteImageFile
	);

	$oUserWallpaperControllerDeleteImageFile
		->methodName('deleteImageFile')
		->divId(array('preview_large_image', 'delete_large_image'));

	// Добавляем контроллер редактирования контроллеру формы
	$oAdmin_Form_Controller->addAction($oUserWallpaperControllerDeleteImageFile);
}

// Источник данных 0
$oAdmin_Form_Dataset = new Admin_Form_Dataset_Entity(
	Core_Entity::factory('User_Wallpaper')
);

// Добавляем источник данных контроллеру формы
$oAdmin_Form_Controller->addDataset($oAdmin_Form_Dataset);

// Показ формы
$oAdmin_Form_Controller->execute();
