<?php

// define globals
define( 'UPWPCART_PLUGIN_DOMAIN', 'upcart' );
define( 'UPWPCART_SETTINGS_PAGE', UPWPCART_PLUGIN_DOMAIN . '-settings' );
define( 'UPWPCART_SETTING_META', UPWPCART_PLUGIN_DOMAIN . 'setting_meta' );

require_once __DIR__ . '/settings.php';
require_once __DIR__ . '/settings-page.php';
require_once __DIR__ . '/settings-sections.php';
require_once __DIR__ . '/settings-fields.php';

