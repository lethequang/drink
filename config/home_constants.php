<?php
defined('HOME_FILTER_PROVINCE_ID') OR define('HOME_FILTER_PROVINCE_ID', '79');
defined('HOME_BANNER_LIMIT') OR define('HOME_BANNER_LIMIT', 5);
defined('HOME_SEARCH_ROOM_LIMIT') OR define('HOME_SEARCH_ROOM_LIMIT', 10);
defined('HOME_ROOM_LIMIT') OR define('HOME_ROOM_LIMIT', 10);
defined('HOME_TESTI_LIMIT') OR define('HOME_TESTI_LIMIT', 3);
defined('HOME_FAVORITE_ROOM_LIMIT') OR define('HOME_FAVORITE_ROOM_LIMIT', 6);

/**
 * Image
 */
define('PUBLIC_PATH', public_path());
define('UPLOAD_PATH', PUBLIC_PATH . 'upload/');
define('UPLOAD_IMAGE_PATH', UPLOAD_PATH . 'images/');
define('UPLOAD_CAPTCHA_IMAGE_PATH', UPLOAD_IMAGE_PATH . 'captcha/');
define('UPLOAD_DISTRICT_IMAGE_PATH', UPLOAD_IMAGE_PATH . 'district/');

define('UPLOAD_URL', '/upload/');
define('UPLOAD_IMAGE_URL', UPLOAD_URL . 'images/');
define('UPLOAD_CAPTCHA_IMAGE_URL', UPLOAD_IMAGE_URL . 'captcha/');
define('UPLOAD_DISTRICT_IMAGE_URL', UPLOAD_IMAGE_URL . 'district/');
define('ICON_IMAGE_URL', '/public/home/images/icons/');
define('IMAGE_LENGTH', 1024*5);
define('IMAGE_WIDTH', 95);
define('IMAGE_HEIGHT', 95);
define('PASSWORD_MIN_LENGTH', 6);
define('PASSWORD_MAX_LENGTH', 32);
define('MAX_LENGTH_CONTENT', 300);

$room_categories = array(
	1 => 'Regular',
	2 => 'Premium',
	3 => 'Villa',
	3 => 'Home',
	3 => 'Hostel',
	3 => 'Basic',
);

define('ROOM_CATEGORIES', serialize($room_categories));

$amenities = array(
	array('field' => 'living_room'     , 'name' => 'Phòng Khách'   , 'icon' => ICON_IMAGE_URL.'living_room.png'),
	array('field' => 'kitchen'         , 'name' => 'Nhà Bếp'       , 'icon' => ICON_IMAGE_URL.'kitchen.png'),
	array('field' => 'bancon'          , 'name' => 'Ban Công'      , 'icon' => ICON_IMAGE_URL.'balcony.png'),
	array('field' => 'tivi'            , 'name' => 'Tivi'          , 'icon' => ICON_IMAGE_URL.'tv.png'),
	array('field' => 'safe_box'        , 'name' => 'Két Sắt'       , 'icon' => ICON_IMAGE_URL.'safe_box.png'),
	array('field' => 'fride'           , 'name' => 'Tủ Lạnh'       , 'icon' => ICON_IMAGE_URL.'fridge.png'),
	array('field' => 'microwave'       , 'name' => 'Lò Vi Sóng'    , 'icon' => ICON_IMAGE_URL.'microwave.png'),
	array('field' => 'air_condition'   , 'name' => 'Điều Hòa'      , 'icon' => ICON_IMAGE_URL.'aircondition.png'),
	array('field' => 'evevator'        , 'name' => 'Thang Máy'     , 'icon' => ICON_IMAGE_URL.'elevator.png'),
	array('field' => 'swimming_pool'   , 'name' => 'Hồ Bơi'        , 'icon' => ICON_IMAGE_URL.'pool.png'),
	array('field' => 'restaurant'      , 'name' => 'Nhà Hàng'      , 'icon' => ICON_IMAGE_URL.'restaurant.png'),
	array('field' => 'parking'         , 'name' => 'Bãi Xe'        , 'icon' => ICON_IMAGE_URL.'parking.png'),
	array('field' => 'wifi'            , 'name' => 'Wifi'          , 'icon' => ICON_IMAGE_URL.'wifi.png'),
	array('field' => 'tran_to_airport' , 'name' => 'Sân Bay'       , 'icon' => ICON_IMAGE_URL.'airplan.png'),
	array('field' => 'gym'             , 'name' => 'Phòng Gym'     , 'icon' => ICON_IMAGE_URL.'gym.png'),
	array('field' => 'smoking'         , 'name' => 'Hút Thuốc'     , 'icon' => ICON_IMAGE_URL.'cigarette.png'),
	array('field' => 'pet'             , 'name' => 'Nuôi Thú'      , 'icon' => ICON_IMAGE_URL.'pet.png'),
);
define('AMENITIES', serialize($amenities));
