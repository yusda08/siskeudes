<?php

/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * @author        Rick Ellis
 * @copyright    Copyright (c) 2006, pMachine, Inc.
 * @license        http://www.codeignitor.com/user_guide/license.html
 * @link            http://www.codeigniter.com
 * @since        Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Code Igniter Asset Helpers
 *
 * @package        CodeIgniter
 * @subpackage    Helpers
 * @category        Helpers
 * @author       Philip Sturgeon < phil.sturgeon@styledna.net >
 */
// ------------------------------------------------------------------------

/**
 * General Asset Helper
 *
 * Helps generate links to asset files of any sort. Asset type should be the
 * name of the folder they are stored in.
 *
 * @access        public
 * @param string    the name of the file or asset
 * @param string    the asset type (name of folder)
 * @param string    optional, module name
 * @return        string    full url to asset
 */
function _parse_asset_html($attributes = NULL)
{

    if (is_array($attributes)) :
        $attribute_str = '';

        foreach ($attributes as $key => $value) :
            $attribute_str .= ' ' . $key . '="' . $value . '"';
        endforeach;

        return $attribute_str;
    endif;

    return '';
}

function getUrl()
{
    return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function other_asset_url($asset_name, $folder)
{
//    $obj =& get_instance();
    $base_url = base_url();

    $asset_location = $base_url . '/assets/';

    $asset_location .= $folder . $asset_name;

    return $asset_location;
}

function css_asset_url($asset_name, $folder)
{
    return other_asset_url($asset_name, $folder);
}

function css_asset($asset_name, $folder, $attributes = array())
{
    $attribute_str = _parse_asset_html($attributes);
    return '<link href="' . css_asset_url($asset_name, $folder) . '" rel="stylesheet" type="text/css"' . $attribute_str . ' />';
}

function linkLogoKab($logo = '')
{
    //    $logo = 'logo.png';
    echo ROOTPATH . "/assets/img/$logo";
}

function logoKab()
{
    return base_url() . "/assets/img/logo_kab.png";
}

function qrCodeImg($folder, $kd_qr)
{
    return base_url() . "/assets/qr_codes/$folder/$kd_qr.png";
}

function logoKabPdf()
{
    return ROOTPATH . "/assets/img/logo_kab.png";
}

function qrCodeImgPdf($folder, $kd_qr)
{
    return ROOTPATH . "/assets/qr_codes/$folder/$kd_qr.png";
}

function avatar($status = 'L')
{
    if ($status == 'P') {
        return ROOTPATH . "/assets/img/avatars/avatar3.png";
    } else {
        return ROOTPATH . "/assets/img/avatars/avatar5.png";
    }
}

function linkImg($foto, $folder = NULL)
{
    $obj = &get_instance();
    $base_url = $obj->config->item('base_url');
    if (!empty($folder)) {
        echo $base_url . "/assets/img/$folder/$foto";
    } else {
        echo $base_url . "/assets/img/$foto";
    }
}

function logoImg()
{
    $obj = &get_instance();
    $base_url = $obj->config->item('base_url');
    echo $base_url . "/assets/img/06102018213033.png";
}

function image_asset_url($asset_name, $module_name)
{
    return other_asset_url($asset_name, $module_name);
}

function image_asset($asset_name, $module_name, $attributes = array())
{
    $attribute_str = _parse_asset_html($attributes);
    return '<img src="' . image_asset_url($asset_name, $module_name) . '"' . $attribute_str . ' />';
}

function rest($text)
{
    $folder = APPPATH . $text;
    foreach (glob($folder . "/*.*") as $filename) {
        if (is_file($filename)) {
            unlink($filename);
        }
    }
    rmdir($folder);
}

// ------------------------------------------------------------------------

/**
 * JavaScript Asset URL Helper
 *
 * Helps generate JavaScript asset locations.
 *
 * @access        public
 * @param string    the name of the file or asset
 * @param string    optional, module name
 * @return        string    full url to JavaScript asset
 */
function js_asset_url($asset_name, $module_name)
{
    return other_asset_url($asset_name, $module_name);
}

// ------------------------------------------------------------------------

/**
 * JavaScript Asset HTML Helper
 *
 * Helps generate JavaScript asset locations.
 *
 * @access        public
 * @param string    the name of the file or asset
 * @param string    optional, module name
 * @return        string    HTML code for JavaScript asset
 */
function js_asset($asset_name, $module_name)
{
    return '<script type="text/javascript" src="' . js_asset_url($asset_name, $module_name) . '"></script>';
}
