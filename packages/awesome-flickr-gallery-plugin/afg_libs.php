<?php

define('BASE_URL', plugins_url() . '/' . basename(dirname(__FILE__)));
define('SITE_URL', site_url());
define('DEBUG', false);
define('VERSION', '3.5.6');

$afg_sort_order_map = array(
    'default' => 'Default',
    'flickr' => 'As per Flickr',
    'date_taken_cmp_newest' => 'By date taken (Newest first)',
    'date_taken_cmp_oldest' => 'By date taken (Oldest first)',
    'date_upload_cmp_newest' => 'By date uploaded (Newest first)',
    'date_upload_cmp_oldest' => 'By date uploaded (Oldest first)',
    'random' => 'Random',
);

$afg_slideshow_map = array(
    'default' => 'Default',
    'colorbox' => 'Colorbox',
    'swipebox' => 'Swipebox (Touch Enabled)',
    'disable' => 'No Slideshow',
    'flickr' => 'Link to Flickr Photo page',
    'none' => 'No Slideshow and No Link',
);

/* Map for photo titles displayed on the gallery. */
$size_heading_map = array(
    '_s' => '',
    '_t' => '0.9em',
    '_m' => '1em',
    'NULL' => '1.2em',
);

$afg_photo_source_map = array(
    'photostream' => 'Photostream',
    'gallery' => 'Gallery',
    'photoset' => 'Photoset',
    'group' => 'Group',
    'tags' => 'Tags',
    'popular' => 'My Popular Photos',
);

$afg_width_map = array(
    'default' => 'Default',
    'auto' => 'Automatic',
    '10' => '10 %',
    '20' => '20 %',
    '30' => '30 %',
    '40' => '40 %',
    '50' => '50 %',
    '60' => '60 %',
    '70' => '70 %',
    '80' => '80 %',
    '90' => '90 %',
);

$afg_photo_size_map = array(
    'default' => 'Default',
    '_s' => 'Square (Max 75px)',
    '_t' => 'Thumbnail (Max 100px)',
    '_m' => 'Small (Max 240px)',
    'NULL' => 'Medium (Max 500px)',
    'custom' => 'Custom',
);

$afg_on_off_map = array(
    'off' => 'Off  ',
    'on' => 'On  ',
    'default' => 'Default',
);

$afg_yes_no_map = array(
    'off' => 'Yes  ',
    'on' => 'No  ',
    'default' => 'Default',
);

$afg_descr_map = array(
    'off' => 'Off',
    'on' => 'On',
    'default' => 'Default',
);

$afg_columns_map = array(
    'default' => 'Default',
    '1' => '1  ',
    '2' => '2  ',
    '3' => '3  ',
    '4' => '4  ',
    '5' => '5  ',
    '6' => '6  ',
    '7' => '7  ',
    '8' => '8  ',
    '9' => '9  ',
    '10' => '10 ',
    '11' => '11 ',
    '12' => '12 ',
);

$afg_bg_color_map = array(
    'default' => 'Default',
    'Black' => 'Black',
    'White' => 'White',
    'Transparent' => 'Transparent',
);

$afg_text_color_map = array(
    'Black' => 'White',
    'White' => 'Black',
);

$afg_cache_refresh_interval_map = array(
	'6h' => '6 Hours',
	'12h' => '12 Hours',
	'1d' => '1 Day',
	'3d' => '3 Days',
	'1w' => '1 Week',
);

function afg_get_cache_refresh_interval_secs ($interval)
{
	if ($interval == '6h') {
		return 6 * 60 * 60;
	}
	else if ($interval == '12h') {
		return 12 * 60 * 60;
	}
	else if ($interval == '1d') {
		return 24 * 60 * 60;
	}
	else if ($interval == '3d') {
		return 3 * 24 * 60 * 60;
	}
	else if ($interval == '1w') {
		return 7 * 24 * 60 * 60;
	}
}

function afg_get_sets_groups_galleries (&$photosets_map, &$groups_map, &$galleries_map, $user_id) {
    global $pf;

    $rsp_obj = $pf->photosets_getList($user_id);
    if (!$pf->error_code) {
        foreach($rsp_obj['photoset'] as $photoset) {
            $photosets_map[$photoset['id']] = $photoset['title']['_content'];
        }
    }

    $rsp_obj = $pf->galleries_getList($user_id);
    if (!$pf->error_code) {
        foreach($rsp_obj['galleries']['gallery'] as $gallery) {
            $galleries_map[$gallery['id']] = $gallery['title']['_content'];
        }
    }

    if (get_option('afg_flickr_token')) {
        $rsp_obj = $pf->groups_pools_getGroups();
        if (!$pf->error_code) {
            foreach($rsp_obj['group'] as $group) {
                $groups_map[$group['nsid']] = $group['name'];
            }
        }
    }
    else {
        $rsp_obj = $pf->people_getPublicGroups($user_id);
        if (!$pf->error_code) {
            foreach($rsp_obj as $group) {
                $groups_map[$group['nsid']] = $group['name'];
            }
        }
    }

    asort($photosets_map);
    asort($groups_map);
    asort($galleries_map);
}

function afg_get_cur_url() {
    $isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
    $port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
    $port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
    $url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["HTTP_HOST"].$port.$_SERVER["REQUEST_URI"];
    return $url;
}

function create_afgFlickr_obj() {
    global $pf;
    unset($_SESSION['afgFlickr_auth_token']);
    $pf = new afgFlickr(get_option('afg_api_key'), get_option('afg_api_secret')? get_option('afg_api_secret'): NULL);
    $pf->setToken(get_option('afg_flickr_token'));
}

function afg_error($error_msg) {
    return "<h3>Flickr Gallery Error - $error_msg</h3>";
}

function date_taken_cmp_newest($a, $b) {
    return $a['datetaken'] < $b['datetaken'];
}

function date_taken_cmp_oldest($a, $b) {
    return $a['datetaken'] > $b['datetaken'];
}

function date_upload_cmp_newest($a, $b) {
    return $a['dateupload'] < $b['dateupload'];
}

function date_upload_cmp_oldest($a, $b) {
    return $a['dateupload'] > $b['dateupload'];
}

function afg_fb_like_box() {
    return "";
}

function afg_share_box() {
    return "";
}

function afg_gplus_box() {
    return "";
}

function delete_afg_caches() {
    $galleries = get_option('afg_galleries');
    foreach($galleries as $id => $ginfo) {
        delete_transient('afg_id_'. $id);
    }
}
function afg_get_photo_url($farm, $server, $pid, $secret, $size) {
    if ($size == 'NULL') {
        $size = '';
    }
    return "https://farm$farm.static.flickr.com/$server/{$pid}_$secret$size.jpg";
}

function afg_get_photo_page_url($pid, $uid) {
    return "https://www.flickr.com/photos/$uid/$pid";
}

function afg_generate_version_line() {
    return "";
}

function afg_generate_flickr_settings_table($photosets, $galleries, $groups) {
    global $afg_photo_source_map;
    $photosets = afg_generate_options($photosets, '', False);
    $galleries = afg_generate_options($galleries, '', False);
    $groups = afg_generate_options($groups, '', False);
    return "
    <h3>Flickr Settings</h3>
    <table class='widefat afg-settings-box'>
        <tr>
            <th class='afg-label'></th>
            <th class='afg-input'></th>
            <th class='afg-help-bubble'></th>
        </tr>
        <tr>
        <td>Gallery Source</td>
        <td><select name='afg_photo_source_type' id='afg_photo_source_type' onchange='getPhotoSourceType()' >" . afg_generate_options($afg_photo_source_map, 'photostream', False) . "
        </select></td>
        </tr>
        <tr>
        <td id='afg_photo_source_label'></td>
        <td><select style='display:none' name='afg_photosets_box' id='afg_photosets_box'>$photosets
        </select>
        <select style='display:none' name='afg_galleries_box' id='afg_galleries_box'>$galleries
        </select>
        <select style='display:none' name='afg_groups_box' id='afg_groups_box'>$groups
        </select>
        <textarea rows='3' cols='30' name='afg_tags' id='afg_tags' style='display:none'></textarea>
        </td>
        <td id='afg_source_help' class='afg-help-bubble' style='display:none'>Enter tags separated by comma. For example: <b>tag1, tag2, tag3, tag4</b><br />Photos matching any of the given tags will be displayed.</td>
        </tr>
    </table>";
}

function afg_generate_gallery_settings_table() {
    global $afg_photo_size_map, $afg_on_off_map, $afg_descr_map,
        $afg_columns_map, $afg_bg_color_map, $afg_photo_source_map,
        $afg_width_map, $afg_yes_no_map, $afg_sort_order_map, $afg_slideshow_map;

    if (get_option('afg_photo_size') == 'custom')
        $photo_size = '(Custom - ' . get_option('afg_custom_size') . 'px' . ((get_option('afg_custom_size_square') == 'true')? ' - Square)': ')');
    else
        $photo_size = $afg_photo_size_map[get_option('afg_photo_size')];

    return "
        <h3>Gallery Settings</h3>
        <table class='widefat fixed afg-settings-box'>
            <tr>
                <th class='afg-label'></th>
                <th class='afg-input'></th>
                <th class='afg-help-bubble'></th>
            </tr>
        <tr>
        <td>Max Photos Per Page</td>
        <td><div  style='display:inline; margin-right:10px'><input type='checkbox' name='afg_per_page_check' id='afg_per_page_check' onclick='showHidePerPage()' value='default' checked=''> Default </input></div><div  class='afg-small-input' style='display:inline-block'><input name='afg_per_page' disabled='true' id='afg_per_page' type='text' maxlength='3' onblur='verifyBlank()' value='10'/></div>
        </td>
        </tr>

        <tr>
        <td>Sort order of Photos</td>
        <td><select name='afg_sort_order' id='afg_sort_order'>"
        . afg_generate_options($afg_sort_order_map, 'default', True, $afg_sort_order_map[get_option('afg_sort_order')]) . "
    </select></td>
            <td class='afg-help'>Set the sort order of the photos as per your liking and forget about how photos are arranged on Flickr.</td>
            </tr>

        <tr>
        <td>Size of Photos</td>
        <td><select name='afg_photo_size' id='afg_photo_size' onchange='customPhotoSize()'>
            " . afg_generate_options($afg_photo_size_map, 'default', True, $photo_size) . "
        </select></td>
        </tr>

        <tr id='afg_custom_size_block' style='display:none'>
        <td>Custom Width</td>
        <td><input type='text' maxlength='3' name='afg_custom_size' id='afg_custom_size' onblur='verifyCustomSizeBlank()' value='100'>* (in px)
        &nbsp;Square? <input type='checkbox' id='afg_custom_size_square' name='afg_custom_size_square' value='true'>
        </td>
        <td class='afg-help'>Fill in the exact width for the photos (min 50, max 500).  Height of the photos will be adjusted
        accordingly to maintain aspect ratio of the photo. Enable <b>Square</b> to crop
        the photo to a square aspect ratio.<br />Warning: Custom photo sizes may not work with your webhost, please use built-in sizes, it's more reliable and faster too.</td>
        </tr>

        <tr>
        <td>Photo Titles</td>
        <td><select name='afg_captions' id='afg_captions'>
            " . afg_generate_options($afg_on_off_map, 'default', True, $afg_on_off_map[get_option('afg_captions')]) . "
        </select></td>
        <td class='afg-help'>Photo Title setting applies only to Thumbnail (and above) size photos.</td>
        </tr>

        <tr>
        <td>Photo Descriptions</td>
        <td><select name='afg_descr' id='afg_descr'>
            " . afg_generate_options($afg_descr_map, 'default', True, $afg_descr_map[get_option('afg_descr')]) . "
        </select></td>
        <td class='afg-help'>Photo Description setting applies only to Small and Medium size photos.</td>
        </tr>

        <tr>
        <td>Number of Columns</td>
        <td><select name='afg_columns' id='afg_columns'>
            " . afg_generate_options($afg_columns_map, 'default', True, $afg_columns_map[get_option('afg_columns')]) . "
        </select></td>
        </tr>

        <tr>
        <td>Slideshow Behavior</td>
        <td><select name='afg_slideshow_option' id='afg_slideshow_option'>
        " . afg_generate_options($afg_slideshow_map, 'default', True, $afg_slideshow_map[get_option('afg_slideshow_option')]) . "
    </select></td>
            </tr>

        <tr>
        <td>Background Color</td>
        <td><select name='afg_bg_color' id='afg_bg_color'>
            " . afg_generate_options($afg_bg_color_map, 'default', True, $afg_bg_color_map[get_option('afg_bg_color')]) . "
        </select></td>
        </tr>

        <tr>
        <td>Gallery Width</td>
        <td><select name='afg_width' id='afg_width'>
        " . afg_generate_options($afg_width_map, 'default', True, $afg_width_map[get_option('afg_width')]) . "
        </select></td>
        <td class='afg-help'>Width of the Gallery is relative to the width of the page where Gallery is being generated.  <i>Automatic</i> is 100% of page width.</td>
        </tr>

        <tr>
        <td>Disable Pagination?</td>
        <td><select name='afg_pagination' id='afg_pagination'>
        " . afg_generate_options($afg_yes_no_map, 'default', True, $afg_yes_no_map[get_option('afg_pagination')]) . "
        </select></td>
        <td class='afg-help'>Useful when displaying gallery in a sidebar widget where you want only few recent photos.</td>
        </tr>
    </table>";
}

function afg_generate_options($params, $selection, $show_default=False, $default_value=0) {
    $str = '';
    foreach($params as $key => $value) {
        if ($key == 'default' && !$show_default)
            continue;

        if ($selection == $key) {
            if ($selection == 'default') $value .= ' - ' . $default_value;
            $str .= "<option value=" . $key . " selected='selected'>" . $value . "</option>";
        }
        else
            $str .= "<option value=" . $key . ">" . $value . "</option>";
    }
    return $str;
}

function afg_filter($param) {
    if ($param == 'default') return "";
    else return $param;
}

function afg_box($title, $message) {
     return "
        <table class='widefat fixed afg-side-box'>
        <h3>$title</h3>
        <tr><td>$message</td></tr>
        </table>
        ";
}

function afg_usage_box($code) {
    return "<table class='fixed widefat afg-side-box'>
        <h3>Usage Instructions</h3>
        <tr><td>Just insert $code in any of the posts or page to display your Flickr gallery.</td></tr>
        </table>";
}

function get_afg_option($gallery, $var) {
    if (isset($gallery[$var]) && $gallery[$var]) return $gallery[$var];
    else return get_option('afg_' . $var);
}

function afg_donate_box() {
    return "";
}

function afg_reference_box() {
    $message = "Max Photos Per Page - <b>" . get_option('afg_per_page') . "</b>";
    $size = get_option('afg_photo_size');
    if ($size == '_s') $size = 'Square';
    else if ($size == '_t') $size = 'Thumbnail';
    else if ($size == '_m') $size = 'Small';
    else if ($size == 'NULL') $size = 'Medium';
    $message .= "<br />Size of Photos - <b>" . $size . "</b>";
    $message .= "<br />Photo Titles - <b>" . get_option('afg_captions') . "</b>";
    $message .= "<br />Photo Descriptions - <b>" . get_option('afg_descr') . "</b>";
    $message .= "<br />No of Columns - <b>" . get_option('afg_columns') . "</b>";
    $message .= "<br />Background Color - <b>" . get_option('afg_bg_color') . "</b>";
    $message .= "<br />Gallery Width - <b>" . ((get_option('afg_width') == 'auto')?"Automatic":get_option('afg_width') . "%") . "</b>";
    $message .= "<br />Pagination - <b>" . get_option('afg_pagination') . "</b>";
    $message .= "<br />Credit Note - <b>" . get_option('afg_credit_note') . "</b>";
    return afg_box('Default Settings for Reference', $message);
}

?>
