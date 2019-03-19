<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Shop_Price_Entry_Model
 *
 * @package HostCMS
 * @subpackage Shop
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2019 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Shop_Price_Entry_Model extends Core_Entity
{
	/**
	 * Disable markDeleted()
	 * @var mixed
	 */
	protected $_marksDeleted = NULL;

	/**
	 * Belongs to relations
	 * @var array
	 */
	protected $_belongsTo = array(
		'shop_price' => array(),
		'shop_item' => array()
	);

	/**
	 * Column consist item's name
	 * @var string
	 */
	protected $_nameColumn = 'datetime';

	/**
	 * Constructor.
	 * @param int $id entity ID
	 */
	public function __construct($id = NULL)
	{
		parent::__construct($id);

		if (is_null($id) && !$this->loaded())
		{
			$this->_preloadValues['datetime'] = Core_Date::timestamp2sql(time());
		}
	}

	/*
	 * Get document id
	 * @param $document_id document ID
	 * @param $type document type
	 * @return int
	 */
	protected function _getDocumentId($document_id, $type)
	{
		$offset = $document_id << 4;
		return $offset | $type;
	}

	/*
	 * Set uniq document ID
	 * @param $document_id document ID
	 * @param $type document type
	 * @return self
	 */
	public function setDocument($document_id, $type)
	{
		$this->document_id = $this->_getDocumentId($document_id, $type);
		return $this;
	}

	/*
	 * Get entries by document id
	 * @param $document_id document ID
	 * @param $type document type
	 * @param $bCache cache
	 * @return array
	 */
	public function getByDocument($document_id, $type, $bCache = FALSE)
	{
		return $this->getAllBydocument_id($this->_getDocumentId($document_id, $type), $bCache);
	}

	/*
	 * Get document type
	 * @return int|NULL
	 */
	public function getDocumentType()
	{
		$return = NULL;

		if ($this->document_id)
		{
			$offset = $this->document_id >> 4;
			$return = $this->document_id % $offset;
		}

		return $return;
	}
}