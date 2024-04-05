<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 27/01/2024
 * Time: 14:15
 */

namespace Bear8421\Bear\Services\FunnyNews\Data\Config;

use Bear8421\Bear\Services\FunnyNews\FunnyNews;
use Bear8421\Bear\Services\Traits\Response;

class ConfigBuilder extends FunnyNews
{
	use Response;

	public function buildSchema($prefix = ''): ConfigBuilder
	{
		$config = array();
		$config['seo_robots'] = '';
		$config['site_description'] = '';
		$config['site_email'] = '';
		$config['site_fax'] = '';
		$config['site_images'] = '';
		$config['default_image_src'] = '';
		$config['default_image_src_for_search'] = '';
		$config['site_keywords'] = '';
		$config['site_name'] = '';
		$config['site_phone'] = '';
		$config['site_slogan'] = '';
		$config['site_slogan_footer'] = '';
		$config['site_title'] = '';
		$config['web_author'] = '';
		$config['company_name'] = '';
		$config['contact_company_address_1'] = '';
		$config['contact_company_address_2'] = '';
		$config['dc.created'] = '';
		$config['email'] = '';
		$config['enterprise'] = '';
		$config['facebook_profile'] = [
			'app_id' => '',
			'admins' => '',
			'locale' => '',
		];
		$config['googleplus_profile'] = [
			'profile_author' => '',
		];
		$config['headquarters'] = '';
		$config['hotline'] = '';
		$config['opensearch'] = [
			'OutputEncoding' => '',
			'InputEncoding' => '',
			'AdultContent' => '',
			'Language' => '',
			'vi-vn' => '',
			'ShortName' => '',
			'LongName' => '',
			'Description' => '',
			'Tags' => '',
			'Query' => '',
			'Developer' => '',
			'Attribution' => '',
			'SyndicationRight' => '',
			'Contact' => '',
			'Domain' => '',
		];
		$config['phone_number'] = '';
		$config['responsible_person'] = '';
		$config['seo_geo_tagging'] = [
			'placename' => 'Ha Noi, Viet Nam',
			'region' => 'VN-HN',
			'position' => '21.0054387,105.8038863',
			'ICBM' => '21.0054387,105.8038863',
		];
		$config['seo_revisit-after'] = '';
		$config['social_profile_json'] = [
			'phone' => '',
			'fax' => '',
			'email' => '',
			'facebook' => '',
			'googleplus' => '',
			'twitter' => '',
			'medium' => '',
			'instagram' => '',
			'youtube' => '',
		];
		$this->response = array(
			'prefix' => $prefix,
			'config' => $config
		);
		return $this;
	}
}
