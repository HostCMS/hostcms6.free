<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Shortcode List
 *
 * DO NOT EDIT THIS FILE BY HAND!
 * YOUR CHANGES WILL BE OVERWRITTEN!
 *
 * @package HostCMS 6\Shortcode
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2017 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */

class Shortcode_List
{
	static public function yandex_map($args, $body)
	{
		$args += array(
			'latlng' => '55.684758, 37.738521',
			'content' => '<strong>Маркер</strong> места',
			'color' => '#0095b6',
			'width' => '500px',
			'height' => '400px',
			'zoom' => 15,
		);
		
		ob_start();
		?>
		<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
		<script type="text/javascript">
			ymaps.ready(init);
		
			function init() {
				var myMap = new ymaps.Map("yandexMap", {
						center: [<?php echo htmlspecialchars($args['latlng'])?>],
						zoom: <?php echo intval($args['zoom'])?>
					}, {
						searchControlProvider: 'yandex#search'
					});
		
				myMap.geoObjects
					.add(new ymaps.Placemark([<?php echo htmlspecialchars($args['latlng'])?>], {
						balloonContent: "<?php echo $args['content']?>"
					}, {
						preset: 'islands#icon',
						iconColor: "<?php echo htmlspecialchars($args['color'])?>"
					}));
			}
		</script>
		
		<style>
			#yandexMap {
				width: <?php echo htmlspecialchars($args['width'])?>; height: <?php echo htmlspecialchars($args['height'])?>; padding: 0; margin: 0;
			}
		</style>
		
		<div id="yandexMap"></div>
		
		<?php
		return ob_get_clean();
	}

	static public function google_map($args, $body)
	{
		$args += array(
			'key' => 'AIzaSyADtuSUbqq2MNdQ3Q0_xBr5Fbdzkvv1XY4',
			'latlng' => '55.684758, 37.738521',
			'content' => 'Маркер места',
			'width' => '500px',
			'height' => '400px',
			'zoom' => 15,
		);
		
		ob_start();
		?>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars($args['key'])?>&callback=initMap"></script>
		<script type="text/javascript">
			function initMap() {
				var myLatlng = new google.maps.LatLng(<?php echo htmlspecialchars($args['latlng'])?>);
				var mapOptions = {
					zoom: <?php echo intval($args['zoom'])?>,
					center: myLatlng
				}
				var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
		
				var marker = new google.maps.Marker({
					position: myLatlng,
					title:"<?php echo htmlspecialchars($args['content'])?>"
				});
		
				// To add the marker to the map, call setMap();
				marker.setMap(map);
			}
		</script>
		
		<style>
			#googleMap {
				width: <?php echo htmlspecialchars($args['width'])?>; height: <?php echo htmlspecialchars($args['height'])?>; padding: 0; margin: 0;
			}
		</style>
		
		<div id="googleMap"></div>
		
		<?php
		return ob_get_clean();
	}

	static public function shop($args, $body)
	{
		$args += array(
			'xsl' => 'МагазинКаталогТоваровНаГлавнойСпецПред',
			'limit' => 3,
			'group' => FALSE,
		);
		
		ob_start();
		
		if (Core::moduleIsActive('shop'))
		{
			if (isset($args['id']) && $args['id'])
			{
				$Shop_Controller_Show = new Shop_Controller_Show(
					Core_Entity::factory('Shop', $args['id'])
				);
		
				$oXsl = Core_Entity::factory('Xsl')->getByName($args['xsl']);
		
				if ($oXsl)
				{
					$Shop_Controller_Show
						->xsl($oXsl)
						->groupsMode('none')
						->itemsForbiddenTags(array('text'))
						->group($args['group'])
						->limit($args['limit'])
						->show();
				}
				else
				{
					?>Ошибка, XSL не найден!<?php
				}
			}
			else
			{
				?>Ошибка, ID магазина не указан!<?php
			}
		}
		
		return ob_get_clean();
	}

	static public function informationsystem($args, $body)
	{
		$args += array(
			'xsl' => 'СписокНовостейНаГлавной',
			'limit' => 5,
			'group' => FALSE,
		);
				
		ob_start();
		
		if (Core::moduleIsActive('informationsystem'))
		{
			if (isset($args['id']) && $args['id'])
			{
				$Informationsystem_Controller_Show = new Informationsystem_Controller_Show(
					Core_Entity::factory('Informationsystem', $args['id'])
				);
		
				$oXsl = Core_Entity::factory('Xsl')->getByName($args['xsl']);
		
				if ($oXsl)
				{
					$Informationsystem_Controller_Show
						->xsl($oXsl)
						->groupsMode('none')
						->itemsForbiddenTags(array('text'))
						->group($args['group'])
						->limit($args['limit'])
						->show();
				}
				else
				{
					?>Ошибка, XSL не найден!<?php
				}
			}
			else
			{
				?>Ошибка, ID информационной системы не указан!<?php
			}
		}
		
		return ob_get_clean();
	}

	static public function document($args, $body)
	{
		ob_start();
		
		if (Core::moduleIsActive('document'))
		{
			if (isset($args['id']) && $args['id'])
			{
				Core_Entity::factory('Document', $args['id'])->execute();
			}
			else
			{
				?>Ошибка, ID документа не указан!<?php
			}
		}
		
		return ob_get_clean();
	}

	static public function donate($args, $body)
	{
		$args += array(
			'sum' => 100,
			'targets' => 'Благотворительность',
			'project-name' => 'Кошкин дом'
		);
		
		if (!isset($args['project-site']))
		{	
			$oSite = Core_Entity::factory('Site', CURRENT_SITE);
			
			$oSiteAlias = $oSite->getCurrentAlias();
			if ($oSiteAlias)
			{
				$args['project-site'] = 'http://' . $oSiteAlias->name;
			}
			else
			{
				return 'Ошибка, домен для сайта не указан!';
			}
		}
		
		if (!isset($args['account']))
		{
			return 'Ошибка, номер Яндекс.Кошелек не указан!';
		}
		
		ob_start();
		?>
		<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=<?php echo rawurlencode($args['account'])?>&quickpay=donate&payment-type-choice=on&mobile-payment-type-choice=on&default-sum=<?php echo rawurlencode($args['sum'])?>&targets=<?php echo rawurlencode($args['targets'])?>&project-name=<?php echo rawurlencode($args['project-name'])?>&project-site=<?php echo rawurlencode($args['project-site'])?>&button-text=01&mail=on&successURL=<?php echo rawurlencode($args['project-site'])?>" width="524" height="93"></iframe>
		
		<?php
			
		return ob_get_clean();
	}

	static public function pdf($args, $body)
	{
		$args += array(
			'width' => '100%',
			'height' => '700px',
		);
		
		ob_start();
		
		if (isset($args['url']))
		{
		?>
		<iframe src="http://docs.google.com/viewer?url=<?php echo rawurlencode($args['url'])?>&embedded=true" style="width:<?php echo htmlspecialchars($args['width'])?>; height:<?php echo htmlspecialchars($args['height'])?>;" 
		frameborder="0">Ваш браузер не поддерживает фреймы</iframe>
		<?php
		}
		
		return ob_get_clean();
	}

	static public function youtube($args, $body)
	{
		$args += array(
			'width' => '560',
			'height' => '315',
		);
		
		ob_start();
		if (isset($args['src']))
		{
		?>
		<iframe width="<?php echo htmlspecialchars($args['width'])?>" height="<?php echo htmlspecialchars($args['height'])?>" src="<?php echo htmlspecialchars($args['src'])?>" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
		<?php 
		}
		
		return ob_get_clean();
	}
}