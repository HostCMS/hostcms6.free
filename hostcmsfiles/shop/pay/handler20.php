<?php

/**
 * LiqPay
 */
class Shop_Payment_System_Handler20 extends Shop_Payment_System_Handler
{
	protected $_public_key = '';
	protected $_private_key = '';

	/**
	 * Международное название валюты из списка валют магазина
	 * @var string
	 */
	protected $_currency_name = 'RUB';

	/**
	 * Идентификатор валюты
	 * @var string
	 */
	protected $_currency_id = 1;

	public function __construct(Shop_Payment_System_Model $oShop_Payment_System_Model)
	{
		parent::__construct($oShop_Payment_System_Model);
		$oCurrency = Core_Entity::factory('Shop_Currency')->getByCode($this->_currency_name);
		!is_null($oCurrency) && $this->_currency_id = $oCurrency->id;
	}

	/**
	 * Метод, вызываемый в коде ТДС через Shop_Payment_System_Handler::checkAfterContent($oShop);
	 */
	public function checkPaymentAfterContent()
	{
		if (isset($_REQUEST['order_id']))
		{
			// Получаем ID заказа
			$aTmpExplode = explode('_', (Core_Array::getRequest('order_id')));
			if(count($aTmpExplode) == 3)
			{
				$order_id = $aTmpExplode[2];

				$oShop_Order = Core_Entity::factory('Shop_Order')->find($order_id);

				if (!is_null($oShop_Order->id))
				{
					// Вызов обработчика платежной системы
					Shop_Payment_System_Handler::factory($oShop_Order->Shop_Payment_System)
						->shopOrder($oShop_Order)
						->paymentProcessing();
				}
			}
		}
	}

	/**
	 * Метод, запускающий выполнение обработчика
	 * @return self
	 */
	public function execute()
	{
		parent::execute();

		$this->printNotification();

		return $this;
	}

	protected function _processOrder()
	{
		parent::_processOrder();

		// Установка XSL-шаблонов в соответствии с настройками в узле структуры
		$this->setXSLs();

		// Отправка писем клиенту и пользователю
		$this->send();

		return $this;
	}

	public function paymentProcessing()
	{
		$this->ProcessResult();
		return TRUE;
	}

	/*
	 * Обработка статуса оплаты
	 */
	function ProcessResult()
	{
		if($this->_shopOrder->paid)
		{
			return FALSE;
		}

		$public_key = $_POST['public_key'];
		$amount = $_POST['amount'];
		$currency = $_POST['currency'];
		$description = $_POST['description'];
		$order_id = $_POST['order_id'];
		$action = $_POST['action'];

		/*$status = $_POST['status'];

		$liqpay = new LiqPay($this->_public_key, $this->_private_key);
		$our_signature = $liqpay->cnb_signature(array(
			'amount'         => $amount,
			'currency'       => $currency,
			'description'    => $description,
			'order_id'       => $order_id,
			'type'           => $type
		));*/

		$status = $_POST['status'];

		// $our_signature = base64_encode(sha1($this->_private_key . $_POST['data'] . $this->_private_key , 1));

		$aParams = array(
			'amount'         => floatval($amount),
			'currency'       => strval($currency),
			'description'    => strval($description),
			'order_id'       => strval($order_id),
			'action'         => strval($action),
			'version'        => 3
		);

		$liqpay = new LiqPay($public_key, $private_key);
		$our_signature = $liqpay->cnb_signature($aParams);

		$lp_signature = $_POST['signature'];

		$status_t = array('success'=>'Успешный платеж','failure'=>'Неуспешный платеж','wait_secure'=>'Платеж на проверке','sandbox'=>'Тестовый платеж');
		$r_stat = $status_t[$status];

		if($lp_signature != '' && $our_signature == $lp_signature && $status == 'success')
		{
			$this->_shopOrder->system_information = sprintf("Заказ оплачен через LiqPay\n\nID платежа в системе LiqPay:\t{$_POST['transaction_id']}\nТелефон плательщика в международном формате:\t{$_POST['sender_phone']}\nСтатус платежа:\t{$r_stat}\n\n");

			$this->_shopOrder->paid();
			$this->setXSLs();
			$this->send();
		}
		else
		{
			$this->_shopOrder->system_information = sprintf("Заказ НЕ оплачен через LiqPay\n\nID платежа в системе LiqPay:\t{$_POST['transaction_id']}\nТелефон плательщика в международном формате:\t{$_POST['sender_phone']}\nСтатус платежа:\t{$r_stat}\n\n");
			$this->_shopOrder->save();
		}

		// ----------------
		ob_start();
		print_r($_POST);
		$xxx = ob_get_clean();

		$this->_shopOrder->system_information = $this->_shopOrder->system_information . $xxx;
		$this->_shopOrder->save();
		// ----------------

	}

	public function getInvoice()
	{
		return $this->getNotification();
	}

	public function getSumWithCoeff()
	{
		return Shop_Controller::instance()->round(($this->_currency_id > 0
		&& $this->_shopOrder->shop_currency_id > 0
		? Shop_Controller::instance()->getCurrencyCoefficientInShopCurrency(
		$this->_shopOrder->Shop_Currency,
		Core_Entity::factory('Shop_Currency', $this->_currency_id)
		)
		: 0) * $this->_shopOrder->getAmount());
	}

	public function getNotification()
	{
		$oSite_Alias = $this->_shopOrder->Shop->Site->getCurrentAlias();
		$sum = $this->getSumWithCoeff();

		if (is_null($oSite_Alias))
		{
			throw new Core_Exception('Site does not have default alias!');
		}

		$shop_path = $this->_shopOrder->Shop->Structure->getPath();
		$handler_url = 'http://' . $oSite_Alias->name . $shop_path . "cart/";

		// формируем форму оплаты
		$liqpay = new LiqPay($this->_public_key, $this->_private_key);
		echo $liqpay->cnb_form(array(
			/*'amount'      => $sum,
			'currency'    => $this->_currency_name,
			'description' => "Оплата заказа №{$this->_shopOrder->id}",
			'order_id'    => "order_id_{$this->_shopOrder->id}",
			'type'        => 'buy',
			//'sandbox'     => 1,
			'server_url'  => $handler_url*/

			'amount'         => floatval($sum),
			'currency'       => $this->_currency_name,
			'description'    => "Оплата заказа №{$this->_shopOrder->id}",
			'order_id'       => "order_id_{$this->_shopOrder->id}",
			'action'         => 'pay',
			'version'        => 3,
			'server_url'  => $handler_url
		));
	}
}

class LiqPay
{
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';
    const CURRENCY_UAH = 'UAH';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_RUR = 'RUR';

    private $_api_url = 'https://www.liqpay.ua/api/';
    private $_checkout_url = 'https://www.liqpay.ua/api/3/checkout';
    protected $_supportedCurrencies = array(
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_UAH,
        self::CURRENCY_RUB,
        self::CURRENCY_RUR,
    );
    private $_public_key;
    private $_private_key;
    private $_server_response_code = null;

    /**
     * Constructor.
     *
     * @param string $public_key
     * @param string $private_key
     *
     * @throws InvalidArgumentException
     */
    public function __construct($public_key, $private_key)
    {
        if (empty($public_key)) {
            throw new InvalidArgumentException('public_key is empty');
        }

        if (empty($private_key)) {
            throw new InvalidArgumentException('private_key is empty');
        }

        $this->_public_key = $public_key;
        $this->_private_key = $private_key;
    }

    /**
     * Call API
     *
     * @param string $path
     * @param array $params
     *
     * @return string
     */
    public function api($path, $params = array())
    {
        if (!isset($params['version'])) {
            throw new InvalidArgumentException('version is null');
        }
        $url         = $this->_api_url . $path;
        $public_key  = $this->_public_key;
        $private_key = $this->_private_key;
        $data        = base64_encode(json_encode(array_merge(compact('public_key'), $params)));
        $signature   = base64_encode(sha1($private_key.$data.$private_key, 1));
        $postfields  = http_build_query(array(
           'data'  => $data,
           'signature' => $signature
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $server_output = curl_exec($ch);
        $this->_server_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($server_output);
    }

    /**
     * Return last api response http code
     * @return string|null
     */
    public function get_response_code()
    {
        return $this->_server_response_code;
    }

    /**
     * cnb_form
     *
     * @param array $params
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function cnb_form($params)
    {
        $language = 'ru';
        if (isset($params['language']) && $params['language'] == 'en') {
            $language = 'en';
        }

        $params    = $this->cnb_params($params);
        $data      = base64_encode(json_encode($params));
        $signature = $this->cnb_signature($params);

        return sprintf('
            <form method="POST" action="%s" accept-charset="utf-8">
                %s
                %s
                <input type="image" src="//static.liqpay.ua/buttons/p1%s.radius.png" name="btn_text" />
            </form>
            ',
            $this->_checkout_url,
            sprintf('<input type="hidden" name="%s" value="%s" />', 'data', $data),
            sprintf('<input type="hidden" name="%s" value="%s" />', 'signature', $signature),
            $language
        );
    }

    /**
     * cnb_signature
     *
     * @param array $params
     *
     * @return string
     */
    public function cnb_signature($params)
    {
        $params      = $this->cnb_params($params);
        $private_key = $this->_private_key;

        $json      = base64_encode(json_encode($params));
        $signature = $this->str_to_sign($private_key . $json . $private_key);

        return $signature;
    }

    /**
     * cnb_params
     *
     * @param array $params
     *
     * @return array $params
     */
    private function cnb_params($params)
    {
        $params['public_key'] = $this->_public_key;

        if (!isset($params['version'])) {
            throw new InvalidArgumentException('version is null');
        }
        if (!isset($params['amount'])) {
            throw new InvalidArgumentException('amount is null');
        }
        if (!isset($params['currency'])) {
            throw new InvalidArgumentException('currency is null');
        }
        if (!in_array($params['currency'], $this->_supportedCurrencies)) {
            throw new InvalidArgumentException('currency is not supported');
        }
        if ($params['currency'] == self::CURRENCY_RUR) {
            $params['currency'] = self::CURRENCY_RUB;
        }
        if (!isset($params['description'])) {
            throw new InvalidArgumentException('description is null');
        }

        return $params;
    }

    /**
     * str_to_sign
     *
     * @param string $str
     *
     * @return string
     */
    public function str_to_sign($str)
    {
        $signature = base64_encode(sha1($str, 1));

        return $signature;
    }
}