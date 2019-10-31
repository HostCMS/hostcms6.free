<?php
/**
 * Information systems.
 *
 * @package HostCMS
 * @subpackage Informationsystem
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2019 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
return array(
	'model_name' => 'Information items',
	'show_information_groups_title' => 'Information system "%s"',
	'information_system_top_menu_items' => 'Information item',
	'show_information_groups_link2' => 'Add',
	'show_information_groups_link3' => 'Properties',
	'show_all_comments_top_menu' => 'Comments',
	'show_comments_link_show_all_comments' => 'All comments',

	'information_items_add_form_title' => 'Add information item',
	'information_items_edit_form_title' => 'Edit information item',

	'markDeleted' => 'Delete information item',

	'id' => 'ID',
	'informationsystem_id' => 'Informationsystem id',
	'shortcut_id' => "Parent item's id",

	'name' => 'Name of information item',
	'informationsystem_group_id' => 'Group',
	'datetime' => 'Date',
	'start_datetime' => 'Publishing date',
	'end_datetime' => 'Completion date of publishing',
	'description' => 'Description of information item',
	'exec_typograph_description' => 'Use prepress service to description',
	'use_trailing_punctuation' => '<acronym title="Optical text alignment function moves punctuation characters beyond the typing borders">Optical alignment</acronym>',

	'active' => 'Active',
	'sorting' => 'Sort',
	'ip' => 'IP',
	'showed' => 'Displaying rate',
	'siteuser_id' => 'User code',
	'image_large' => 'Large picture',
	'image_small' => 'Small picture',
	'path' => 'Name of item in URL',
	'maillist' => '<acronym title="Information system item can be added as a subscribe issue">Place in subscription</acronym>',
	'maillist_default_value' => '-- Not send --',

	'siteuser_group_id' => 'Access group',

	'indexing' => 'Index',
	'text' => 'Text',

	'exec_typograph_for_text' => 'Use prepress service to text',
	'use_trailing_punctuation_for_text' => '<acronym title="Optical text alignment function moves punctuation characters beyond the typing borders">Optical alignment</acronym>',

	'tab_1' => 'Description',
	'tab_2' => 'SEO',
	'tab_3' => 'Tags',
	'tab_4' => 'Additional properties',

	'seo_title' => 'Title',
	'seo_description' => 'Description',
	'seo_keywords' => 'Keywords',
	'tags' => '<acronym title="Labels (tags) of information item divided by comma, e.g. processors, AMD, Athlon64">Labels (tags)</acronym>',
	'type_tag' => 'Type tag ...',

	'error_information_group_URL_item' => 'Group already contains information item with this name in URL!',
	'error_information_group_URL_item_URL' => 'Group contains subgroup with URL coinciding with the item name in URL!',

	'edit_success' => 'Information item modified successfully!',
	'apply_success' => 'Information modified successfully.',
	'copy_success' => 'Information item copied successfully!',

	'changeActive_success' => 'Status changed successfully!',
	'changeIndexation_success' => 'Information item modified successfully.',
	'move_items_groups_title' => 'Transfer of groups and items',
	'move_items_groups_information_groups_id' => 'Parent group',

	'add_information_item_shortcut_title' => 'Create shortcut',
	'add_item_shortcut_information_groups_id' => 'Parent group',
	'shortcut_success' => 'Shortcut creat successfully.',
	'markDeleted_success' => 'Information item deleted successfully.',
	'markDeleted_error' => 'Information item has not been deleted!',

	'move_success' => 'Information items have been transferred.',

	'show_comments_title' => 'Comments to information item "%s"',
	'show_information_propertys_title' => 'Additional properties of information system items "%s"',
	'delete_success' => 'Item deleted successfully!',
	'undelete_success' => 'Item restored successfully!',
	'root' => 'Root dir',
	'shortcut_group_tags' => "<acronym title=\"Another groups with shortcuts\">Additional groups</acronym>",
	'select_group' => 'Select a group',
	'export' => 'Export',
	'export_list_separator' => "<acronym title=\"Columns separation character\">Separation character</acronym>",
	'export_list_separator1' => "Comma",
	'export_list_separator2' => "Semicolon",
	'export_encoding' => "Encoding",
	'input_file_encoding0' => 'Windows-1251',
	'input_file_encoding1' => 'UTF-8',
	'export_parent_group' => "Parent group",
	'export_external_properties_allow_items' => "Export additional properties of information system items",
	'export_external_properties_allow_groups' => "Export additional properties of groups",
	'tab_export' => 'Export/Import',
	'guid' => '<acronym title="Item identifier, e.g. ID00029527">GUID</acronym>',
	'import_small_images' => "Small image for %s",
	'import_file_description' => "Description for %s",
	'import' => "Import",
	'import_list_file' => "Choose file to upload",
	'alternative_file_pointer_form_import' => "<acronym title=\"Set file path on server, e.g., tmp/myfile.csv\">or set file path on server</acronym>",
	'import_list_name_field_f' => "First line contains field names",
	'import_separator' => "<acronym title=\"Columns separation character\">Separation character</acronym>",
	'import_separator1' => "Comma",
	'import_separator2' => "Semicolon",
	'import_separator3' => "Tab",
	'import_separator4' => 'Other',
	'import_stop' => "Mark",
	'import_stop1' => "Quotations",
	'import_stop2' => 'Other',
	'import_encoding' => "Encoding",
	'import_parent_group' => "Parent group",
	'import_images_path' => "<acronym title=\"Path for external files, e.g. /upload_images/\">Path for external files</acronym>",
	'import_action_items' => "<acronym title=\"Action for existing items\">Action for existing items</acronym>",
	'import_action_items0' => "Delete existing items in all groups",
	'import_action_items1' => "Update existing items",
	'import_action_items2' => "Nothing",
	'import_action_delete_image' => "<acronym title=\"Activation of this checkbox enables you to delete images for items in case these images are empty or have not been transferred\">Delete images when updating</acronym>",
	'search_event_indexation_import' => "Use event-based indexing groups and items",
	'import_max_time' => "<acronym title=\"Maximum execution time (in seconds)\">Maximum execution time</acronym>",
	'import_max_count' => "Import per step",
	'import_button_load' => "Upload",
	'root_folder' => 'Root folder',
	'count_insert_item' => 'Items uploaded',
	'count_update_item' => 'Items updated',
	'create_catalog' => 'Catalogue sections created',
	'update_catalog' => 'Catalogue sections updated',
	'msg_download_complete' => "Import has finished!",
	'information_items_copy_form_title' => 'Copy item',
	'add_value'=>'Add the default property values ​​for the items with unset values',
);