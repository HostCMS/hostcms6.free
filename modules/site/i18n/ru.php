<?php
/**
 * Sites.
 *
 * @package HostCMS
 * @subpackage Site
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2020 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
return array(
	'model_name' => 'Сайты',
	'name' => 'Название сайта',
	'active' => '<acronym title="Статус сайта. Неактивные сайты не отображаются посетителям">Активность</acronym>',
	'sorting' => 'Порядок сортировки',
	'locale' => '<acronym title="Локаль для сайта. Например «ru_RU.utf8»">Локаль</acronym>',
	'coding' => '<acronym title="Кодировка сайта, например, UTF-8">Кодировка</acronym>',
	'timezone' => '<acronym title="Часовой пояс, в которой находится сайт. Устанавливается при отличии часового пояса сайта от часового пояса хостинга">Часовой пояс</acronym>',
	'max_size_load_image' => 'Максимальный размер малого изображения',
	'max_size_load_image_big' => 'Максимальный размер большого изображения',
	'admin_email' => '<acronym title="Электронный адрес администратора сайта">E-mail</acronym>',
	'send_attendance_report' => '<acronym title="При выборе данного параметра на электронный ящик администратора сайта ежедневно будет приходить письмо, содержащее статистику посещаемости сайта">Отправлять ежедневный отчет о посещаемости</acronym>',
	'files_chmod' => '<acronym title="Права доступа к файлам после их создания, например 0644">Права доступа к файлам</acronym>',
	'chmod' => '<acronym title="Права доступа к директориям после их создания, например 0755">Права доступа к директориям</acronym>',
	'date_format' => '<acronym title="Формат даты. Например «d.m.Y.»">Формат даты</acronym>',
	'date_time_format' => '<acronym title="Формат даты и времени. Например «d.m.Y H:i:s.»">Формат даты и времени</acronym>',
	'error' => '<acronym title="Режим вывода ошибок. Например «E_ERROR» или «E_ALL»">Режим вывода ошибок</acronym>',
	'error404' => '<acronym title="Страница, отображаемая при возникновении 404 ошибки (страница не найдена), если страница не указана - при возникновении 404 ошибки производится редирект на главную страницу">Страница для &quot;Ошибка 404&quot; (страница не найдена)</acronym>',
	'error403' => '<acronym title="Страница, отображаемая при попытке доступа к разделу сайта пользователем, не имеющим права доступа">Страница для &quot;Ошибка 403&quot; (доступ запрещен)</acronym>',
	'robots' => '<acronym title="Содержимое файла robots.txt для данного сайта">robots.txt</acronym>',
	'key' => '<acronym title="Лицензионные ключи для сайта">Лицензионный ключ</acronym>',
	'closed' => '<acronym title="Страница, отображаемая если сайт отключен администратором">Страница, отображаемая при отключении сайта</acronym>',
	'safe_email' => '<acronym title="Параметр, определяющий защищать e-mail на страницах сайта от спам-ботов или нет">Защищать e-mail на страницах сайта</acronym>',
	'html_cache_use' => 'Кэшировать страницы сайта в статичные файлы',
	'html_cache_with' => 'Включать страницы в кэш',
	'html_cache_without' => 'Не включать страницы в кэш',
	'css_left' => '<acronym title="Пользовательский стиль элементов, выносимых слева за границу набора, если не указан, стиль прописывается явно">CSS-стиль для левого оптического выравнивания</acronym>',
	'css_right' => '<acronym title="Пользовательский стиль элементов, выносимых справа за границу набора, если не указан, стиль прописывается явно">CSS-стиль для правого оптического выравнивания</acronym>',
	'html_cache_clear_probability' => '<acronym title="Определяет вероятность, с которой будет происходить очистка кэша в статичных файлах для текущего сайта. Например, при указании числа 10000 очистка кэша будет происходить раз в 10000 обращений к сайту. Если указано 0, то автоматическая очистка кэша в статичных файлах не будет использоваться">Число, определяющее вероятность очистки кэша.</acronym>',
	'uploaddir' => '<acronym title="Относительный путь к директории для хранения загруженных файлов. Путь должен заканчиваться символом /. Например, upload/">Директория для хранения загруженных файлов</acronym>',
	'nesting_level' => '<acronym title="Число уровней вложенности директорий (минимум 1) для хранения файлов сущностей системы (основных и дополнительных свойств типа \'Файл\' информационных элементов, основных и дополнительных свойств типа \'Файл\' информационных групп, дополнительных свойств типа \'Файл\' узлов структуры и т.д.)">Уровень вложенности</acronym>',
	'id' => 'Идентификатор',
	'site_add_site_form_title' => 'Добавление информации о сайте',
	'site_edit_site_form_title' => 'Редактирование информации о сайте "%s"',
	'site_chmod' => 'Права доступа',
	'site_dates' => 'Форматы',
	'site_errors' => 'Ошибки',
	'site_robots_txt' => 'robots.txt',
	'site_licence' => 'Ключи',
	'site_cache_options' => ' Кэширование',
	'edit_success' => 'Сайт успешно добавлен!',
	'edit_error' => 'Ошибка! Сайт не добавлен!',
	'markDeleted_success' => 'Сайт успешно удален!',
	'markDeleted_error' => 'Ошибка удаления сайта!',
	'changeStatus_success' => 'Активность успешно изменена!',
	'changeStatus_error' => 'Ошибка изменения активности!',
	'apply_success' => 'Информация успешно изменена!',
	'apply_error' => 'Ошибка изменения информации!',
	'notes' => 'Заметки',
	'menu' => 'Сайты',
	'save_notes' => 'Сохранить',
	'site_show_site_title_list' => 'Список сайтов',
	'site_show_site_title' => 'Сайт',
	'site_link_add' => 'Добавить',
	'copy_success' => 'Информация о сайте успешно скопирована',
	'copy_error' => 'Ошибка копирования информации о сайте',
	'ico_files_uploaded' => '<acronym title="ICO-файл для сайта">Favicon</acronym>',
	'default' => 'По умолчанию',

	'menu2_caption' => 'Настройки',
	'menu2_sub_caption' => 'Регистрационные данные',

	'accountinfo_title' => 'Редактирование регистрационных данных',
	'accountinfo_login' => 'Логин пользователя в личном кабинете на сайте www.hostcms.ru',
	'accountinfo_contract_number' => 'Номер лицензии',
	'accountinfo_pin_code' => 'PIN-код',
	'accountInfo_success' => 'Регистрационные данные успешно изменены.',

	'delete_success' => 'Элемент удален!',
	'undelete_success' => 'Элемент восстановлен!',

	'add_site_with_template' => 'Добавить с шаблоном дизайна',
	'choose_site_template' => 'Выбор макета сайта',
	'choose_color_scheme' => 'Выбор цветовой схемы',
	'template_settings' => 'Настройки макета',
	'delete_current_site' => 'Запрещено удаление сайта пользователем, который принадлежит удаляемому сайту!',
	'delete_last_site' => 'Запрещено удаление последнего сайта!',
	'delete_site_all_superusers_belongs' => 'Невозможно удалить сайт,так как все суперпользователи принадлежат ему!',

	'lng' => 'Язык сайта',
	'lng_default' => 'ru',
	'error_email' => '<acronym title="Технический e-mail (ошибки и т.д.)">Технический e-mail</acronym>',
	'https' => 'HTTPS',
	'set_https' => 'Установить HTTPS',
);