<?php
/**
 * Online shop.
 *
 * @package HostCMS
 * @subpackage Shop
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2017 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
return array(
	'model_name' => 'Товары магазина',
	'links_items' => "Товар",
	'links_items_add' => "Добавить",
	'name' => "<acronym title=\"Название товара\">Название</acronym>",
	'type' => "<acronym title=\"Выбор типа товара (обычный или электронный)\">Тип товара</acronym>",
	'marking' => "<acronym title=\"Артикул товара\">Артикул</acronym>",
	'vendorcode' => "<acronym title=\"Код товара (указывается код производителя), размещается в элементе 'vendorCode' при экспорте в Яндекс.Маркет\">Код товара от производителя</acronym>",
	'description' => "<acronym title=\"Краткое описание товара\">Описание</acronym>",
	'text' => "<acronym title=\"Детальное описание товара\">Текст</acronym>",
	'image_large' => "<acronym title=\"Изображение товара\">Изображение товара</acronym>",
	'image_small' => "<acronym title=\"Малое изображение товара\">Малое изображение товара</acronym>",
	'weight' => "<acronym title=\"Вес товара\">Вес</acronym>",

	'price_header' => "Цены",
	'price' => "<acronym title=\"Основная цена товара\">Основная</acronym>",
	'active' => "<acronym title=\"Активный товар доступен для заказа и публикуется в каталоге\">Товар активен</acronym>",
	'siteuser_group_id' => '<acronym title="Группа, имеющая права доступа к товару">Группа доступа</acronym>',
	'sorting' => "<acronym title=\"Порядок сортировки товара\">Порядок сортировки</acronym>",
	'path' => "<acronym title=\"Путь, например item_30312\">Путь</acronym>",
	'seo_title' => "<acronym title=\"Значение мета-тега title для страницы с товаром\">Заголовок (title)</acronym>",
	'seo_description' => "<acronym title=\"Значение мета-тега description для страницы с товаром\">Описание (description)</acronym>",
	'seo_keywords' => "<acronym title=\"Значение мета-тега keywords для страницы с товаром\">Ключевые слова (keywords)</acronym>",
	'indexing' => "<acronym title=\"Разрешает индексацию товара встроенной поисковой системой\">Индексировать товар</acronym>",
	'yandex_market' => '<acronym title="Экспортировать товар в систему Яндекс.Маркет">Экспортировать в Яндекс.Маркет</acronym>',
	'yandex_market_bid' => '<acronym title="Основная расценка для системы Яндекс.Маркет (указывается в центах)">Яндекс.Маркет - основная расценка</acronym>',
	'yandex_market_cid' => '<acronym title="Расценка для карточек моделей системы Яндекс.Маркет (указывается в центах)">Яндекс.Маркет - расценка для карточек моделей</acronym>',
	'yandex_market_sales_notes' => '<acronym title="Тег &lt;sales_notes&gt;, экспортируемый в Яндекс.Маркет">Отличие товара от других (значение тега &lt;sales_notes&gt;)</acronym>',
	'datetime' => '<acronym title="Дата добавления товара">Дата</acronym>',
	'guid' => '<acronym title="Идентификатор товара для формата CommerceML, например ID00029527">Идентификатор товара CommerceML</acronym>',
	'start_datetime' => '<acronym title="Дата публикации товара">Дата публикации</acronym>',
	'end_datetime' => '<acronym title="Дата завершения публикации товара">Дата завершения публикации</acronym>',
	'showed' => '<acronym title="Количество показов товара">Счетчик показов</acronym>',
	'id' => 'Идентификатор',
	'tab_description' => 'Описание',
	'tab_export' => 'Экспорт/Импорт',
	'tab_seo' => 'SEO',
	'tab_tags' => 'Метки',
	'tab_special_prices' => 'Специальные цены',
	'tab_prop' => "Дополнительные свойства",
	'shop_group_id' => '<acronym title="Группа, которой принадлежит товар">Группа</acronym>',
	'item_type_selection_group_buttons_name_simple' => "Обычный товар",
	'item_type_selection_group_buttons_name_electronic' => "Электронный товар",
	'item_type_selection_group_buttons_name_divisible' => "Делимый товар",
	'shop_item_catalog_modification_flag' => "Модификация для товара",
	'shop_seller_id' => "<acronym title=\"Продавец товара\">Продавец</acronym>",
	'shop_producer_id' => "<acronym title=\"Производитель товара\">Производитель</acronym>",
	'shop_tax_id' => '<acronym title="Налог на товар">Налог</acronym>',
	'shop_measure_id' => "<acronym title=\"Единица измерения\">Единица измерения</acronym>",
	'property_prefix' => '<acronym title="Префикс свойства">Префикс</acronym>',
	'property_filter' => '<acronym title="Способ отображения свойства в фильтре">Способ отображения свойства в фильтре</acronym>',

	'properties_show_kind_none' => 'Не отображать',
	'properties_show_kind_text' => 'Поле ввода',
	'properties_show_kind_list' => 'Список - списком',
	'properties_show_kind_radio' => 'Список - переключателями',
	'properties_show_kind_checkbox' => 'Список - флажками',
	'properties_show_kind_checkbox_one' => 'Флажок',
	'properties_show_kind_from_to' => 'От.. до..',
	'properties_show_kind_listbox' => 'Список - список с множественным выбором',

	'warehouse_header' => "Количество товара на складах",
	'property_header' => "Дополнительные свойства",
	'yandex_market_header' => "Экспорт в Яндекс.Маркет",
	//'warehouse_item_count' => "Количество товара на складе \"%s\"",
	'siteuser_group_id' => '<acronym title="Группа, имеющая права доступа к товару">Группа доступа</acronym>',
	'shop_users_group_parrent' => 'Как у родителя',
	'siteuser_id' => '<acronym title="Идентификатор пользователя сайта, добавившего товар">Код пользователя</acronym>',
	'exec_typograph_for_text' => '<acronym title="Применить типографирование к тексту">Типографировать текст</acronym>',
	'use_trailing_punctuation_for_text' => '<acronym title="Оптическое выравнивание текста перемещает символы пунктуации за границу набора">Оптическое выравнивание</acronym>',
	'shop_id' => 'Идентификатор магазина',
	'form_edit_add_shop_special_prices_from' => '<acronym title="Минимальное количество товара, которое нужно купить за один раз, чтобы задействовать цену">Количество товара от</acronym>',
	'form_edit_add_shop_special_prices_to' => '<acronym title="Максимальное количество товара, которое нужно купить за один раз, чтобы задействовать цену">Количество товара до</acronym>',
	'form_edit_add_shop_special_pricess_price' => '<acronym title="Цена за единицу товара, купленного в определенном количестве">Цена</acronym>',
	'form_edit_add_shop_special_pricess_percent' => '<acronym title="Процент от базовой цены. Например для скидки 15% процент от базовой цены будет 85">% от цены</acronym>',
	'or' => 'или',
	'more' => 'Еще …',
	'items_catalog_image' => "<acronym title=\"Изображение товара\">Изображение товара</acronym>",
	'items_catalog_image_small' => "<acronym title=\"Малое изображение товара\">Малое изображение товара</acronym>",
	'items_catalog_tags' => "<acronym title=\"Метки (теги) товара, разделяются запятой, например кухня, бытовая техника, холодильник, Indesit\">Метки (теги)</acronym>",
	'type_tag' => 'Введите тэг ...',
	'items_catalog_add_form_title' => "Добавление информации о товаре",
	'items_catalog_edit_form_title' => "Редактирование информации о товаре",
	'changeActive_success' => "Информация успешно изменена",
	'apply_success' => "Информация успешно изменена",
	'adminChangeAssociated_success' => "Информация успешно изменена",
	'adminSetAssociated_success' => "Информация успешно изменена",
	'adminUnsetAssociated_success' => "Информация успешно изменена",
	'markDeleted_success' => "Информация о товаре успешно удалена!",
	'shortcut_success' => "Ярлык товара успешно добавлен",
	'edit_success' => "Товар успешно добавлен!",
	'copy_success' => "Товар успешно скопирован!",
	'shops_add_form_link_properties' => "Свойства товара",
	'show_list_of_properties_title' => "Список свойств товара интернет-магазина \"%s\"",
	'tab_properties' => "Дополнительные свойства",
	'items_catalog_add_form_comment_link' => 'Отзывы',
	'properties_item_for_groups_link' => 'Свойства товаров для группы',
	'properties_item_for_groups_root_title' => 'Свойства товара, доступные для текущей группы товаров',
	'change_prices_for_shop_group' => 'Изменение цен',
	'import_price_list_link' => "Импорт товаров",
	'export_shop' => "Экспорт товаров",
	'shops_link_orders' => "Заказы",
	'shops_add_form_link_orders' => "Оформленные заказы",
	'show_delivery_on' => "Доставка",
	'show_type_of_delivery_link' => "Типы доставки",
	'show_sds_link' => "Справочники",
	'show_prices_title' => "Цены",
	'system_of_pays' => "Платежные системы",
	'show_producers_link' => "Производители",
	'show_sellers_link' => 'Продавцы',
	'main_menu_warehouses_list' => "Склады",
	'show_reports_title' => 'Отчеты',
	'show_sales_order_link' => 'По продажам',
	'show_brands_order_link' => 'По производителям',
	'shop_menu_title' => "Скидки",
	'show_discount_link' => "Скидки на товары",
	'order_discount_show_title' => 'Скидки от суммы заказа',
	'coupon_group_link' => 'Купоны на скидку',
	'bonus_link' => 'Бонусы',
	'affiliate_menu_title' => 'Партнерские программы',
	'add_item_shortcut_shop_groups_id' => "<acronym title=\"Группа, в которой размещается ярлык товара\">Родительская группа</acronym>",
	'add_shop_item_shortcut_title' => "Ярлык для %s",
	'shortcut_creation_window_caption' => "Создание ярлыка",
	'show_item_comment_title' => "Список отзывов о товаре \"%s\"",
	'show_comments_title' => 'Отзывы к товару "%s"',
	'show_tying_products_title' => "Сопутствующие товары товара \"%s\"",
	'item_modification_title' => 'Модификации товара "%s"',
	'item_modification_add_item' => 'Добавить',
	'show_groups_modification' => 'Модификация',
	'import_price_list_file_type1' => "CSV-файл",
	'import_price_list_file_type1_items' => "CSV-файл товары",
	'import_price_list_file_type1_orders' => "CSV-файл заказы",
	'import_price_list_file_type2' => "CommerceML",
	'export_file_type' => "<acronym title=\"Тип выгружаемого файла\">Выберите тип файла</acronym>",
	'import_price_list_file' => "<acronym title=\"Выберите файл с компьютера\">Выберите файл с компьютера</acronym>",
	'alternative_file_pointer_form_import' => "<acronym title=\"Задайте относительный путь к файлу от директории системы, например, tmp/myfile.csv\">или укажите путь к файлу на сервере</acronym>",
	'import_price_list_name_field_f' => "<acronym title=\"Флаг, указывающий на то, содержит ли первая строка имена полей\">Первая строка содержит имена полей</acronym>",
	'import_price_list_separator1' => "Запятая",
	'import_price_list_separator2' => "Точка с запятой",
	'import_price_list_separator3' => "Табуляция",
	'import_price_list_separator4' => 'Другой',
	'import_price_list_separator' => "<acronym title=\"Разделитель для столбцов\">Разделитель</acronym>",
	'import_price_list_stop' => "<acronym title=\"Ограничитель для полей\">Ограничитель</acronym>",
	'import_price_list_stop1' => "Кавычки",
	'import_price_list_stop2' => 'Другой',
	'delete_success' => 'Элемент удален!',
	'undelete_success' => 'Элемент восстановлен!',
	'price_list_encoding' => "Кодировка",
	'input_file_encoding0' => 'Windows-1251',
	'input_file_encoding1' => 'UTF-8',
	'import_price_list_parent_group' => "<acronym title=\"Вы можете выгружать товары из указанного каталога, включая все подкаталоги\">Родительская группа для выгрузки товаров</acronym>",
	'import_price_list_producer' => "<acronym title=\"Вы можете выгружать товары указанного производителя\">Производитель товаров</acronym>",
	'import_price_list_images_path' => "<acronym title=\"Путь для внешних файлов, например /upload_images/\">Путь для внешних файлов</acronym>",
	'import_price_list_action_items' => "<acronym title=\"Действие для существующих товаров\">Действие для существующих товаров</acronym>",
	'import_price_action_items0' => "Удалить существующие товары во всех группах",
	'import_price_action_items1' => "Обновить существующие товары",
	'import_price_action_items2' => "Оставить без изменений",
	'import_price_list_action_delete_image' => "<acronym title=\"Установка данного флага позволяет удалять изображения для элементов товара, если эти изображения не переданы или пусты\">Удалять изображения для товаров при обновлении</acronym>",
	'search_event_indexation_import' => "Использовать событийную индексацию при вставке групп товаров и товаров",
	'import_price_list_max_time' => "<acronym title=\"Максимальное время выполнения (в секундах)\">Максимальное время выполнения</acronym>",
	'import_price_list_max_count' => "<acronym title=\"Максимальное количество импортируемых за шаг товаров\">Максимальное кол-во импортируемых за шаг</acronym>",
	'import_price_list_button_load' => "Загрузить",
	'move_success' => 'Товары перенесены',
	'root_folder' => 'Корневая группа',
	'import_small_images' => "Малое изображение для ",
	'count_insert_item' => 'Загружено товаров',
	'count_update_item' => 'Обновлено товаров',
	'create_catalog' => 'Создано разделов каталога',
	'update_catalog' => 'Обновлено разделов каталога',
	'msg_download_price' => "Следующий этап загрузки прайс-листа произойдет через 1 секунду",
	'msg_download_price_complete' => "Импорт завершен!",
	'export_price_list_file_type2' => "CommerceML v. 1.xx",
	'export_price_list_file_type3_import' => "CommerceML v. 2.0x (import.xml)",
	'export_price_list_file_type3_offers' => "CommerceML v. 2.0x (offers.xml)",
	'multiply_price_to_digit' => 'Цену умножить на ',
	'add_price_to_digit' => 'Цену увеличить на ',
	'select_price_form' => '<acronym title="Укажите вариант изменения">Вариант изменения: </acronym>',
	'select_discount_type' => '<acronym title="Выберите скидку, для установки к выбранной группе товаров">Установить скидку</acronym>',
	'flag_delete_discount' => '<acronym title="При установке данного флажка будет производиться удаление скидки для товара, если она была установлена">Удалить выбранную скидку</acronym>',
	'select_bonus_type' => '<acronym title="Выберите бонус, для установки к выбранной группе товаров">Установить бонус</acronym>',
	'flag_delete_bonus' => '<acronym title="При установке данного флажка будет производиться удаление бонуса для товара, если он был установлен">Удалить выбранный бонус</acronym>',
	'flag_include_modifications' => '<acronym title="При установке данного флажка в список товаров добавятся их модификации">Учитывать модификации</acronym>',
	'flag_include_spec_prices' => '<acronym title="При установке данного флажка цена будет применена к специальным ценам товара и модификаций">Применить к специальным ценам</acronym>',
	'select_parent_group' => '<acronym title="Выберите группу товаров, начиная с которой следует произвести изменение цен">Родительская группа</acronym>',
	'form_sales_order_select_grouping' => '<acronym title="Указывает период группировки заказов в отчете">Группировать:</acronym>',
	'form_sales_order_grouping_monthly' => 'ежемесячно',
	'form_sales_order_grouping_weekly' => 'еженедельно',
	'form_sales_order_grouping_daily' => 'ежедневно',
	'form_sales_order_show_list_items' => '<acronym title="Выводит список товаров из каждого заказа">Выводить товары из заказа</acronym>',
	'form_sales_order_begin_date' => '<acronym title="Начальная дата отчетного периода">Начальная дата</acronym>',
	'form_sales_order_end_date' => '<acronym title="Конечная дата отчетного периода">Конечная дата</acronym>',
	'form_sales_order_show_paid_items' => '<acronym title="Выводит список товаров только оплаченных заказов">Только оплаченные</acronym>',
	'form_sales_order_sallers' => '<acronym title="Ограничение заказаных товаров по продавцу">Продавец:</acronym>',
	'form_sales_order_sop' => '<acronym title="Ограничение заказаных товаров по платежной системе">Платежная система:</acronym>',
	'form_sales_order_status' => '<acronym title="Ограничение заказаных товаров по статусу заказа">Статус заказа:</acronym>',
	'sales_report_title' => "Отчет о продажах магазина %s за период %s - %s",
	'sales_report_brands_title' => "Отчет по производителям о продажах магазина %s за период %s - %s",
	'form_sales_order_count_orders' => 'Заказов',
	'form_sales_order_count_items' => 'Кол-во товара',
	'form_sales_order_total_summ' => 'Сумма заказа',
	'form_sales_order_status_of_pay' => 'Статус оплаты',
	'form_sales_order_order_status' => 'Статус заказа',
	'form_sales_order_month_january' => 'Январь',
	'form_sales_order_month_february' => 'Февраль',
	'form_sales_order_month_march' => 'Март',
	'form_sales_order_month_april' => 'Апрель',
	'form_sales_order_month_may' => 'Май',
	'form_sales_order_month_june' => 'Июнь',
	'form_sales_order_month_july' => 'Июль',
	'form_sales_order_month_august' => 'Август',
	'form_sales_order_month_september' => 'Сентябрь',
	'form_sales_order_month_october' => 'Октябрь',
	'form_sales_order_month_november' => 'Ноябрь',
	'form_sales_order_month_december' => 'Декабрь',
	'form_sales_order_week' => ' неделя,<br />',
	'form_sales_order_empty_orders' => 'За указанный период оплаченные заказы отсутствуют.',
	'form_sales_order_orders_number' => 'Заказ № <b>%s</b> от <b>%s</b>',
	'form_sales_order_date_of_paid' => ', оплачен <b>%s</b>',
	'form_sales_order_status_of_pay_yes' => 'Оплачен',
	'form_sales_order_status_of_pay_no' => 'Не оплачен',
	'export_external_properties_allow_items' => "Экспортировать дополнительные свойства товаров",
	'export_external_properties_allow_groups' => "Экспортировать дополнительные свойства групп",
	'export_modifications_allow' => "Экспортировать модификации",
	'export_shortcuts_allow' => "Экспортировать ярлыки",
	'export_orders_allow' => "Экспортировать заказы",
	'load_parent_group' => '--- Корневая ---',
	'accepted_prices' => 'Обновление информации о ценах для товаров прошло успешно!',
	'error_URL_shop_item' => 'В группе уже существует товар с таким названием в URL!',
	'error_URL_isset_group' => 'В группе существует подгруппа с URL, совпадающим с названием товара в URL!',
	'warehouse_import_field' => "Склад \"%s\"",
	'userprice_import_field' => "Цена \"%s\"",
	'error_property_guid' => "Не обнаружен GUID свойства!",
	'error_shop_id' => "Идентификатор магазина не указан!",
	'error_parent_directory' => "Родительская директория не указана!",
	'error_save_without_name' => "Не могу сохранить товар без названия!",
	'create_modification' => "Создать модификации",
	'create_modification_title' => "Создание модификаций из товара",
	'create_modification_property_enable' => "Использовать свойство \"%s\" {P%s}",
	'create_modification_price' => "<acronym title=\"Цена модификаций\">Цена</acronym>",
	'create_modification_mark' => "<acronym title=\"Шаблон для генерации артикулов модификаций\">Артикул, {N} &mdash; порядковый номер</acronym>",
	'create_modification_name' => "<acronym title=\"Шаблон для генерации названий модификаций\">Название, возможна подстановка к названию значений свойств. Например, \"%s, цвет {P17}\" даст результат \"%s, цвет Синий\"</acronym>",
	'create_modification_copy_main_properties' => "<acronym title=\"Копировать основные изображения, текст, описание товара\">Копировать основные атрибуты товара</acronym>",
	'create_modification_copy_seo' => "<acronym title=\"Копировать значения SEO-полей\">Копировать значения SEO-полей</acronym>",
	'create_modification_copy_export_import' => "<acronym title=\"Копировать параметры экспорта/импорта товара\">Копировать параметры экспорта/импорта товара</acronym>",
	'create_modification_copy_prices_to_item' => "<acronym title=\"Копировать дополнительные цены товара\">Копировать дополнительные цены товара</acronym>",
	'create_modification_copy_specials_prices_to_item' => "<acronym title=\"Копировать специальные цены товара\">Копировать специальные цены товара</acronym>",
	'create_modification_copy_tying_products' => "<acronym title=\"Копировать сопутствующие товары\">Копировать сопутствующие товары</acronym>",
	'create_modification_copy_external_property' => "<acronym title=\"Копировать значения остальных дополнительных свойств товара\">Копировать дополнительные свойства товара</acronym>",
	'create_modification_copy_tags' => "<acronym title=\"Копировать метки (теги) товара\">Копировать метки (теги) товара</acronym>",
	'generateModifications_success' => 'Модификации созданы успешно',
	'file_does_not_specified' => 'Файл не указан',
	'prices_add_form_recalculate' => "<acronym title=\"При выборе этого параметра будет произведен пересчет цены для всех товаров магазина, для которых она установлена\">Пересчитать установленные цены</acronym>",
	'prices_add_form_apply_for_all' => "<acronym title=\"При выборе этого параметра добавляемая цена будет применена ко всем товарам магазина\">Установить для всех товаров</acronym>",
	'catalog_marking' => "Артикул",
	'item_cards' => "Ценники",
	'item_cards_print' => "Печать ценников",
	'item_cards_print_parent_group' => "<acronym title=\"Вы можете генерировать ценники для товаров из указанного каталога, включая все подкаталоги\">Родительская группа для генерации ценников</acronym>",
	'item_cards_print_fio' => "<acronym title=\"ФИО ответственного лица\">ФИО ответственного лица</acronym>",
	'item_cards_print_date' => "<acronym title=\"Дата\">Дата</acronym>",
	'item_cards_print_height' => "<acronym title=\"Высота элемента в миллиметрах\">Высота, мм.</acronym>",
	'item_cards_print_width' => "<acronym title=\"Ширина элемента в миллиметрах\">Ширина, мм.</acronym>",
	'item_cards_print_font' => "<acronym title=\"Размер шрифта\">Размер шрифта</acronym>",
	'item_cards_desription' => "Наименование",
	'item_cards_price' => "Цена",
	'item_cards_sign' => "Подпись ответственного лица",
	'manufacturer_warranty' => '<acronym title="Товар имеет официальную гарантию производителя">Гарантия производителя</acronym>',
	'country_of_origin' => '<acronym title="Страна, в которой товар был произведён">Страна производства</acronym>',
	'apply_price_for_modification' => "<acronym title=\"Применяет основную цену и валюту товара для модификаций\">Применить основную цену для модификаций</acronym>",
	'item_length'=>'Длина',
	'item_width'=>'Ширина',
	'item_height'=>'Высота',
	'apply_purchase_discount' => 'Учитывать для скидки от суммы заказа',
	'delivery' => 'Доставка',
	'pickup' => 'Самовывоз',
	'store' => 'В розничном магазине',
	'adult' => 'Для взрослых',
	'show_in_group'=>'Показывать свойство в группе',
	'show_in_item'=>'Показывать свойство в товаре',
	'add_value'=>'Добавить отсутствующие значения свойства по умолчанию у товаров',
	'start_order_date'=>'Начальная дата',
	'stop_order_date' => 'Конечная дата',
	'empty_shop' => 'Вы уверены, что хотите полностью очистить магазин?',
	'root' => 'Корень магазина',
	'shortcut_group_tags' => "<acronym title=\"Группы в которых располагаются ярлыки текущего товара\">Дополнительные группы</acronym>",
	'select_group' => 'Выберите группу',
	'apply_discount_items_title' => 'Добавление скидок и бонусов',
	'discount_select_caption' => 'Список скидок',
	'bonus_select_caption' => 'Список бонусов',
	'apply_discount_success' => 'Информация добавлена успешно!',
	'shop_item_associated_unset' => 'Информация успешно изменена',
	'print_forms' => 'Печатные формы',
	'show_all_warehouses' => 'Показать все склады',
	'sales_order_show_producers_limit' => 'Количество производителей на графике',
	'reset' => 'Исходный вид',
	'legend' => 'Легенда',
);
