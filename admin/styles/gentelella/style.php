<?php
/**
 *
 * MyBB: MyGentelella - Admin CP
 *
 * Filename: style.php
 *
 * Style Author: Chack1172
 *
 * C Site: http://www.chack1172.altervista.org/
 *
 * MyBB Version: 1.8.x
 *
 * Style Version: 1.2
 * 
 */

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

class Page extends DefaultPage
{
    static $tid = 1;
    
    function output_header($title="")
	{
		global $mybb, $admin_session, $lang, $plugins, $run_module;

        $page = "page_{$run_module}_{$this->active_action}";
        
		$args = array(
			'this' => &$this,
			'title' => &$title,
		);

		$plugins->run_hooks("admin_page_output_header", $args);

		if(!$title)
			$title = $lang->mybb_admin_panel;

		$rtl = "";
		if($lang->settings['rtl'] == 1)
			$rtl = " dir=\"rtl\"";
        
        if(empty($mybb->user['avatar']))
            $mybb->user['avatar'] = $mybb->settings['useravatar'];
        
        if (strpos($mybb->user['avatar'], 'http') === false)
			$avatar = "../".$mybb->user['avatar'];
		else
			$avatar = $mybb->user['avatar'];
        
        if($mybb->user['avatar'] && my_substr($mybb->user['avatar'], 0, 7) !== 'http://' && my_substr($mybb->user['avatar'], 0, 8) !== 'https://')
            $avatar = "../{$mybb->user['avatar']}";
        
        if(!$mybb->user['avatar'])
            $avatar = "../".$mybb->settings['useravatar'];
        
		echo "<!DOCTYPE html>\n";
		echo "<html>\n";
		echo "<head>\n";
		echo "	<title>".$title."</title>\n";
        echo "  <meta charset=\"UTF-8\">\n";
        echo "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
		echo "	<meta name=\"author\" content=\"MyBB Group\">\n";
		echo "	<meta name=\"copyright\" content=\"Copyright ".COPY_YEAR." MyBB Group.\">\n";
        echo "  <link rel=\"stylesheet\" href=\"styles/".$this->style."/bootstrap.min.css?ver=1.2\" type=\"text/css\">\n";
        echo "  <link rel=\"stylesheet\" href=\"styles/".$this->style."/font-awesome/css/all.min.css?ver=1.2\" type=\"text/css\">\n";
        echo "  <link rel=\"stylesheet\" href=\"styles/".$this->style."/iCheck/skins/flat/green.css?ver=1.2\" type=\"text/css\">\n";
		echo "	<link rel=\"stylesheet\" href=\"styles/".$this->style."/main.css?ver=1.2\" type=\"text/css\">\n";

		// Load stylesheet for this module if it has one
		if(file_exists(MYBB_ADMIN_DIR."styles/{$this->style}/{$this->active_module}.css"))
		{
			echo "	<link rel=\"stylesheet\" href=\"styles/{$this->style}/{$this->active_module}.css?ver=1.2\" type=\"text/css\" />\n";
		}

		echo "	<script type=\"text/javascript\" src=\"../jscripts/jquery.js\"></script>\n";
		echo "	<script type=\"text/javascript\" src=\"../jscripts/jquery.plugins.min.js\"></script>\n";
		echo "	<script type=\"text/javascript\" src=\"../jscripts/general.js?ver={$mybb->version_code}\"></script>\n";
		echo "	<script type=\"text/javascript\" src=\"./jscripts/admincp.js\"></script>\n";
		echo "	<script type=\"text/javascript\" src=\"./jscripts/tabs.js\"></script>\n";

		echo "	<link rel=\"stylesheet\" href=\"jscripts/jqueryui/css/redmond/jquery-ui.min.css\" />\n";
		echo "	<link rel=\"stylesheet\" href=\"jscripts/jqueryui/css/redmond/jquery-ui.structure.min.css\" />\n";
		echo "	<link rel=\"stylesheet\" href=\"jscripts/jqueryui/css/redmond/jquery-ui.theme.min.css\" />\n";
		echo "	<script src=\"jscripts/jqueryui/js/jquery-ui.min.js?ver=1804\"></script>\n";

		// Stop JS elements showing while page is loading (JS supported browsers only)
		echo "  <style type=\"text/css\">.popup_button { display: none; } </style>\n";
		echo "  <script type=\"text/javascript\">\n".
				"//<![CDATA[\n".
				"	document.write('<style type=\"text/css\">.popup_button { display: inline; } .popup_menu { display: none; }<\/style>');\n".
                "//]]>\n".
                "</script>\n";

		echo "	<script type=\"text/javascript\">
//<![CDATA[
var loading_text = '{$lang->loading_text}';
var cookieDomain = '{$mybb->settings['cookiedomain']}';
var cookiePath = '{$mybb->settings['cookiepath']}';
var cookiePrefix = '{$mybb->settings['cookieprefix']}';
var cookieSecureFlag = '{$mybb->settings['cookiesecureflag']}';
var imagepath = '../images';

lang.unknown_error = \"{$lang->unknown_error}\";
lang.saved = \"{$lang->saved}\";
//]]>
</script>\n";
		echo $this->extra_header;
		echo "</head>\n";
		echo "<body class=\"nav-md\">\n";
		echo "  <div class=\"container body\">\n";
        echo "    <div class=\"main_container\" id=\"{$page}\">\n";
        echo "      <div class=\"col-md-3 left_col\">\n";
        echo "        <div class=\"left_col scroll-view\">\n";
        echo "          <div class=\"navbar nav_title\">\n";
        echo "            <a href=\"index.php\" class=\"site_title\"><i class=\"far fa-comments\"></i> <span>MyBB Admin CP</span></a>\n";
        echo "          </div>\n";
        echo "          <div class=\"clearfix\"></div>\n";
        echo "          <div class=\"profile\">\n";
        echo "            <div class=\"profile_pic\">\n";
        echo "              <img class=\"img-circle profile_img\" src=\"{$avatar}\" alt=\"...\">\n";
        echo "            </div>\n";
        echo "            <div class=\"profile_info\">\n";
        echo "              <h2>{$mybb->user['username']}</h2>\n";
        echo "            </div>\n";
        echo "          </div>\n";
        echo "          <div class=\"clearfix\"></div>\n";
        echo "          <div id=\"sidebar-menu\" class=\"main_menu_side hidden-print main_menu\">\n";
        echo $this->_build_menu();
        echo "          </div>\n";
        echo "        </div>\n";
        echo "      </div>\n";
		echo "      <div class=\"top_nav\">\n";
		echo "        <div class=\"nav_menu\">\n";
		echo "          <nav role=\"navigation\">\n";
        echo "            <div class=\"nav toggle\">\n";
        echo "              <a id=\"menu_toggle\"><i class=\"fas fa-bars\"></i></a>\n";
        echo "            </div>\n";
		echo "            <ul class=\"nav navbar-nav navbar-right\">\n";
		echo "              <li>\n";
		echo "                <a href=\"#\" class=\"user-profile dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">\n";
		echo "                  <img src=\"{$avatar}\" alt=\"\">\n";
        echo "                  {$mybb->user['username']}\n";
        echo "                  <span class=\" fas fa-angle-down\"></span>\n";
        echo "                </a>\n";
        echo "                <ul class=\"dropdown-menu dropdown-usermenu pull-right\">\n";
        echo "                  <li><a href=\"{$mybb->settings['bburl']}\">{$lang->view_board}</a></li>\n";
        echo "                  <li><a href=\"index.php?action=logout&amp;my_post_key={$mybb->post_code}\" class=\"logout\"><i class=\"fas fa-sign-out-alt pull-right\"></i> {$lang->logout}</a></li>\n";
        echo "                </ul>\n";
		echo "              </li>\n";
		echo "            </ul>\n";
		echo "          </nav>\n";
		echo "        </div>\n";
		echo "      </div>\n";
        echo "      <div class=\"clearfix\"></div>\n";
		echo "      <div class=\"right_col\" role=\"main\">\n";
        echo "        <ol class=\"breadcrumb\">\n";
		echo $this->_generate_breadcrumb();
		echo "        </ol>\n";
		
		if(isset($admin_session['data']['flash_message']) && $admin_session['data']['flash_message'])
		{
			$message = $admin_session['data']['flash_message']['message'];
			$type = $admin_session['data']['flash_message']['type'];
            switch($type) {
                case 'success':
                    $alert = "alert-success";
                    break;
                case 'error':
                    $alert = "alert-error";
                    break;
                default:
                    $alert = "alert-info";
            }
			echo "    <div id=\"flash_message\" class=\"alert {$alert} alert-dismissible fade in\" role=\"alert\">\n";
            echo "      <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span></button>";
			echo "      {$message}\n";
			echo "    </div>\n";
			update_admin_session('flash_message', '');
		}

		if(!empty($this->extra_messages) && is_array($this->extra_messages))
		{
			foreach($this->extra_messages as $message)
			{
                switch($message['type']) {
                    case 'success':
                        $alert = "alert-success";
                        break;
                    case 'error':
                        $alert = "alert-error";
                }
				switch($message['type'])
				{
					case 'success':
					case 'error':
                        echo "    <div id=\"flash_message\" class=\"alert {$alert} alert-dismissible fade in\" role=\"alert\">\n";
                        echo "      <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span></button>";
                        echo "      {$message['message']}\n";
                        echo "    </div>\n";
						break;
					default:
						$this->output_error($message['message']);
						break;
				}
			}
		}

		if($this->show_post_verify_error == true)
			$this->output_error($lang->invalid_post_verify_key);
	}
    
    function output_footer($quit=true)
	{
		global $mybb, $maintimer, $db, $lang, $plugins;

		$args = array(
			'this' => &$this,
			'quit' => &$quit,
		);

		$plugins->run_hooks("admin_page_output_footer", $args);

		$memory_usage = get_friendly_size(get_memory_usage());

		$totaltime = format_time_duration($maintimer->stop());
		$querycount = $db->query_count;

		if(my_strpos(getenv("REQUEST_URI"), "?"))
			$debuglink = htmlspecialchars_uni(getenv("REQUEST_URI")) . "&amp;debug=1#footer";
		else
			$debuglink = htmlspecialchars_uni(getenv("REQUEST_URI")) . "?debug=1#footer";
        
        echo "        <div class=\"clearfix\"></div>";
        echo "        <footer>\n";
        echo "          <div class=\"pull-right\">\n";
        echo "            " . $lang->sprintf($lang->generated_in, $totaltime, $debuglink, $querycount, $memory_usage);
        echo "            <br>";
        echo "            Powered By <a href=\"http://www.mybb.com/\" target=\"_blank\">MyBB</a>, &copy; 2002-".COPY_YEAR." <a href=\"http://www.mybb.com/\" target=\"_blank\">MyBB Group</a>.";
        echo "            <br>";
        echo "            Theme Powered By <a href=\"http://www.chack1172.altervista.org\">chack1172</a>. Based On Gentelella - Bootstrap Admin Template by <a href=\"https://colorlib.com\">Colorlib</a>";
        echo "          </div>\n";
        echo "          <div class=\"clearfix\"></div>\n";
        echo "        </footer>\n";
		if($mybb->debug_mode)
			echo $db->explain;
        echo "      </div>\n";
		echo "    </div>\n";
		echo "  </div>\n";
		echo "  <script type=\"text/javascript\" src=\"styles/".$this->style."/bootstrap.min.js\"></script>\n";
        echo "  <script type=\"text/javascript\" src=\"styles/".$this->style."/iCheck/icheck.min.js\"></script>";
		echo "  <script type=\"text/javascript\" src=\"styles/".$this->style."/general.js\"></script>\n";
		echo "</body>\n";
		echo "</html>\n";

		if($quit != false)
			exit;
	}
    
    function output_success($message)
	{
		echo "<div id=\"flash_message\" class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">\n";
        echo "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span></button>\n";
        echo "  {$message}\n";
        echo "</div>\n";
	}

	/**
	 * Output an alert/warning message.
	 *
	 * @param string $message The message to output.
	 * @param string $id The ID of the alert/warning (optional)
	 */
	function output_alert($message, $id="")
	{
		if($id)
			$id = " id=\"{$id}\"";
		echo "<div id=\"flash_message\" class=\"alert alert-warning alert-dismissible fade in\" role=\"alert\"{$id}>\n";
        echo "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span></button>\n";
        echo "  {$message}\n";
        echo "</div>\n";
	}

	/**
	 * Output an inline message.
	 *
	 * @param string $message The message to output.
	 */
	function output_inline_message($message)
	{
		echo "<div id=\"flash_message\" class=\"alert alert-info alert-dismissible fade in\" role=\"alert\">";
        echo "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span></button>\n";
        echo "  {$message}\n";
        echo "</div>\n";
	}

	/**
	 * Output a single error message.
	 *
	 * @param string $error The message to output.
	 */
	function output_error($error)
	{
		echo "<div id=\"flash_message\" class=\"alert alert-error alert-dismissible fade in\" role=\"alert\">\n";
        echo "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span></button>\n";
		echo "  {$error}\n";
		echo "</div>\n";
	}

	/**
	 * Output one or more inline error messages.
	 *
	 * @param array $errors Array of error messages to output.
	 */
	function output_inline_error($errors)
	{
		global $lang;

		if(!is_array($errors))
			$errors = array($errors);
		echo "<div id=\"flash_message\" class=\"alert alert-error alert-dismissible fade in\" role=\"alert\">\n";
        echo "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">×</span></button>\n";
		echo "  <strong>{$lang->encountered_errors}</strong>\n";
		echo "  <ul>\n";
		foreach($errors as $error)
		{
			echo "    <li>{$error}</li>\n";
		}
		echo "  </ul>\n";
		echo "</div>\n";
	}
    
    function _build_menu()
	{
        global $sidebar;
		if(!is_array($this->_menu))
			return false;
        
		$build_menu = '<div id="menu" class="menu_section">';
        $build_menu .= '    <ul class="nav side-menu">';
		ksort($this->_menu);
		foreach($this->_menu as $items)
		{
			foreach($items as $menu_item)
			{
				$menu_item['link'] = htmlspecialchars_uni($menu_item['link']);
                
                $sub_menu = $menu_item['submenu'];
                $sub_menu_title = $menu_item['title'];
                
                if ($sub_menu) {
                    $build_menu .= $this->_build_submenu($sub_menu_title, $sub_menu, $menu_item['id'], $this->active_module);
                }
                
                $build_menu .= $sidebar;
			}
		}
        $build_menu .= '        '.$this->sidebar;
        
        $build_menu .= '    </ul>';
		$build_menu .= '</div>';

		return $build_menu;
	}
    
    function _build_submenu($title, $items=[], $item="", $mod="")
    {
		if (is_array($items)) {
			$sidebar = new sideBarItem($title);
			$sidebar->add_menu_items($items, $this->active_action, $item);
			return $sidebar->get_markup($item, $mod);
        }
        return '';
	}
    
    function _generate_breadcrumb()
	{
		if(!is_array($this->_breadcrumb_trail))
			return false;
		$trail = "";
		foreach($this->_breadcrumb_trail as $key => $crumb)
		{
			if(isset($this->_breadcrumb_trail[$key+1]))
				$trail .= "          <li><a href=\"".$crumb['url']."\">".$crumb['name']."</a></li>\n";
			else
				$trail .= "          <li class=\"active\">".$crumb['name']."</li>\n";
		}
		return $trail;
	}
    
    function output_nav_tabs($tabs=array(), $active='')
	{
		global $plugins;
		$tabs = $plugins->run_hooks("admin_page_output_nav_tabs_start", $tabs);
		echo "        <ul class=\"nav nav-tabs\">\n";
		foreach($tabs as $id => $tab)
		{
			$class = '';
			if($id == $active)
				$class = ' active';
			$target = '';
			if(isset($tab['link_target']))
				$target = " target=\"{$tab['link_target']}\"";
            
			if(!isset($tab['link']))
				$tab['link'] = '';
			echo "          <li class=\"{$class}\"><a href=\"{$tab['link']}\"{$target}>{$tab['title']}</a></li>\n";
			$target = '';
		}
		echo "        </ul>\n";
		$arguments = array('tabs' => $tabs, 'active' => $active);
		$plugins->run_hooks("admin_page_output_nav_tabs_end", $arguments);
	}
    
    function output_tab_control($tabs=array(), $observe_onload=true, $id="tabs")
	{
		global $plugins;
		echo "<ul class=\"nav tabs nav-tabs\" role=\"tablist\" id=\"{$id}\">\n";
		$tab_count = count($tabs);
		$done = 1;
		foreach($tabs as $anchor => $title)
		{
			$class = "";
            $expanded = "false";
			if($tab_count == $done)
				$class .= " last";
			if($done == 1) {
				$class .= "active first";
                $expanded = "true";
            }
			++$done;
			echo "<li class=\"{$class}\" role=\"presentation\"><a href=\"#tab_{$anchor}\" role=\"tab\" data-toggle=\"tab\" aria-expanded=\"{$expanded}\">{$title}</a></li>\n";
		}
		echo "</ul>\n";
	}
    
    function output_confirm_action($url, $message="", $title="")
	{
		global $lang, $plugins;

		if(!$message)
			$message = $lang->confirm_action;
		$this->output_header($title);
		$form = new Form($url, 'post');

        echo "<div class=\"row\">\n";
        echo "  <div class=\"col-md-12 col-sm-12 col-xs-12\">\n";
        echo "    <div class=\"x_panel\">\n";
        echo "      <div class=\"x_content\">";
		echo "        <p>{$message}</p>\n";
        echo "        <p>";
		echo $form->generate_submit_button($lang->yes, array('class' => 'button_yes'));
		echo $form->generate_submit_button($lang->no, array("name" => "no", 'class' => 'button_no btn-danger'));
		echo "        </p>\n";
		echo "      </div>\n";
		echo "    </div>\n";
		echo "  </div>\n";
		echo "</div>\n";

		$form->end();
		$this->output_footer();
	}
    
    function show_login($message="", $class="success")
	{
		global $plugins, $lang, $cp_style, $mybb, $config;

		$args = array(
			'this' => &$this,
			'message' => &$message,
			'class' => &$class
		);

		$plugins->run_hooks('admin_page_show_login_start', $args);

		$copy_year = COPY_YEAR;
        
        $_SERVER['PHP_SELF'] = htmlspecialchars_uni($_SERVER['PHP_SELF']);
        
        // Make query string nice and pretty so that user can go to his/her preferred destination
		$query_string = '';
		if($_SERVER['QUERY_STRING'])
		{
			$query_string = '?'.preg_replace('#adminsid=(.{32})#i', '', $_SERVER['QUERY_STRING']);
			$query_string = preg_replace('#my_post_key=(.{32})#i', '', $query_string);
			$query_string = str_replace('action=logout', '', $query_string);
			$query_string = preg_replace('#&+#', '&', $query_string);
			$query_string = str_replace('?&', '?', $query_string);
			$query_string = htmlspecialchars_uni($query_string);
		}
        
		$login_page .= <<<EOF
<!DOCTYPE html>
<html>
<head profile="http://gmpg.org/xfn/1">
<title>{$lang->mybb_admin_login}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="MyBB Group" />
<meta name="copyright" content="Copyright {$copy_year} MyBB Group.">
<link rel="stylesheet" href="./styles/{$cp_style}/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="./styles/{$cp_style}/login.css" type="text/css">
<link rel="stylesheet" href="./styles/{$cp_style}/font-awesome/css/all.min.css" type="text/css">
</head>
<body class="login">
<div class="login_wrapper">
	<div class="animate form login_form">
        <section class="login_content">
            <form method="post" action="{$_SERVER['PHP_SELF']}{$query_string}">
                <input type="hidden" name="do" value="login">
                <a href="../index.php"><h1><i class="fas fa-cog"></i> Admin CP Login</h2></a>
EOF;
		if($message)
			$login_page .= "<p id=\"message\" class=\"{$class}\"><span class=\"text\">{$message}</span></p>";
		switch($mybb->settings['username_method'])
		{
			case 0:
				$lang_username = $lang->username;
				break;
			case 1:
				$lang_username = $lang->username1;
				break;
			case 2:
				$lang_username = $lang->username2;
				break;
			default:
				$lang_username = $lang->username;
				break;
		}
        $lang_username = str_replace(':', '', $lang_username);
        $lang->password = str_replace(':', '', $lang->password);
        
		// Secret PIN
        $secret_pin = '';
		if(isset($config['secret_pin']) && $config['secret_pin'] != '') {
			$lang->secret_pin = str_replace(':', '', $lang->secret_pin);
            $secret_pin = "<div><input type=\"password\" name=\"pin\" id=\"pin\" class=\"form-control\" placeholder=\"{$lang->secret_pin}\"></div>";
        }

		$login_page .= <<<EOF
                <div><input type="text" name="username" id="username" class="form-control initial_focus" placeholder="{$lang_username}"></div>
                <div><input type="password" name="password" id="password" class="form-control" placeholder="{$lang->password}"></div>
                {$secret_pin}
                <div>
                    <input type="submit" class="btn btn-default" value="{$lang->login}" />
                    <a href="../member.php?action=lostpw" class="reset_pass"><i class="far fa-lightbulb"></i> {$lang->lost_password}</a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    <br>
                    <h1>
                        <i class="fas fa-paw"></i>
                        MyGentelella Alela!
                    </h1>
                    <p>Powered By <a href="https://www.mybb.com/" target="_blank">MyBB</a>, &copy; 2002-{$copy_year} <a href="https://www.mybb.com/" target="_blank">MyBB Group</a>.<br/>Theme By <a href="http://www.chack1172.altervista.org/?language=english">chack1172</a>. Based On Gentelella - Bootstrap Admin Template by <a href=\"https://colorlib.com\">Colorlib</p>
                </div>
            </form>
        </section>
	</div>
</div>
</body>
</html>
EOF;

		$args = array(
			'this' => &$this,
			'login_page' => &$login_page
		);

		$plugins->run_hooks('admin_page_show_login_end', $args);

		echo $login_page;
		exit;
	}
    
    function show_2fa()
	{
		global $lang, $cp_style, $mybb;
        // Make query string nice and pretty so that user can go to his/her preferred destination
		$query_string = '';
		if($_SERVER['QUERY_STRING'])
		{
			$query_string = '?'.preg_replace('#adminsid=(.{32})#i', '', $_SERVER['QUERY_STRING']);
			$query_string = preg_replace('#my_post_key=(.{32})#i', '', $query_string);
			$query_string = str_replace('action=logout', '', $query_string);
			$query_string = preg_replace('#&+#', '&', $query_string);
			$query_string = str_replace('?&', '?', $query_string);
			$query_string = htmlspecialchars_uni($query_string);
		}
        
		$mybb2fa_page = <<<EOF
<!DOCTYPE html>
<html>
<head profile="http://gmpg.org/xfn/1">
<title>{$lang->my2fa}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="MyBB Group" />
<meta name="copyright" content="Copyright {$copy_year} MyBB Group." />
<link rel="stylesheet" href="./styles/{$cp_style}/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="./styles/{$cp_style}/login.css" type="text/css">
<link rel="stylesheet" href="./styles/{$cp_style}/font-awesome/css/all.min.css" type="text/css">
</head>
<body class="login">
<div class="login_wrapper">
	<div class="animate form login_form">
        <section class="login_content">
            <form method="post" action="index.php{$query_string}">
                <input type="hidden" name="do" value="do_2fa" />
                <a href="../index.php"><h1><i class="fas fa-cog"></i> Admin CP 2FA</h2></a>
                <p>{$lang->my2fa_code}</p>
                <div><input type="text" name="code" id="code" class="form-control initial_focus"></div>
                <div><input type="submit" class="btn btn-default" value="{$lang->login}"></div>
                <div class="clearfix"></div>
                <div class="separator">
                    <br>
                    <h1>
                        <i class="fas fa-paw"></i>
                        MyGentelella Alela!
                    </h1>
                    <p>Powered By <a href="https://www.mybb.com/" target="_blank">MyBB</a>, &copy; 2002-{$copy_year} <a href="https://www.mybb.com/" target="_blank">MyBB Group</a>.<br/>Theme By <a href="http://www.chack1172.altervista.org/?language=english">chack1172</a>. Based On Gentelella - Bootstrap Admin Template by <a href=\"https://colorlib.com\">Colorlib</p>
            </form>
        </section>
	</div>
</div>
</body>
</html>
EOF;
		echo $mybb2fa_page;
		exit;
	}
}

class SidebarItem extends DefaultSidebarItem
{
    private $_title = '';
	private $_contents = '';
    
    function __construct($title="")
	{
		$this->_title = $title;
	}
    
    function set_contents($html)
	{
		$this->_contents = $html;
	}
    
    function add_menu_items($items, $active, $module='')
	{
		$this->_contents = '';
		foreach ($items as $item) {
			if($module != '' && !check_admin_permissions(array('module' => $module, 'action' => $item['id']), false))
				continue;

			$class = '';
			if ($item['id'] == $active) {
				$class = ' class="current-page"';
            }
            
			$item['link'] = htmlspecialchars_uni($item['link']);
			$this->_contents .= "        <li{$class}><a href=\"{$item['link']}\">{$item['title']}</a></li>\n";
		}
	}
    
	function get_markup($active='active', $mod='mod')
	{
        $style = $class = '';
        if ($active != $mod) {
            $style = ' style="display: none"';
        } else {
            $class = ' class="active"';
        }
        
        $markup = <<<EOT
<li{$class}>
    <a>
        {$this->_title}
        <span class="fas fa-chevron-down"></span>
    </a>
    <ul class="nav child_menu"{$style}>
        {$this->_contents}
    </ul>
</li>
EOT;
        
        return $markup;
	}
}

class PopupMenu extends DefaultPopupMenu
{
}

class Table extends DefaultTable
{
    private $_cells = array();
	private $_rows = array();
	private $_headers = array();
    
    function construct_cell($data, $extra=array())
	{
		$this->_cells[] = array("data" => $data, "extra" => $extra);
	}
    
	function num_rows()
	{
		return count($this->_rows);
	}
    
    function construct_header($data, $extra=array())
	{
		$this->_headers[] = array("data" => $data, "extra" => $extra);
	}

    
    function construct_row($extra = array())
	{
		$i = 1;
		$cells = '';
		// We construct individual cells here
		foreach($this->_cells as $key => $cell)
		{
			$cells .= "\t\t\t<td";
			
			if(!isset($cell['extra']['class']))
				$cell['extra']['class'] = '';

			if($key == 0)
				$cell['extra']['class'] .= " first";
			elseif(!isset($this->_cells[$key+1]))
				$cell['extra']['class'] .= " last";
            
			if($i == 2) {
				$cell['extra']['class'] .= " alt_col";
				$i = 0;
			}
			$i++;
			if($cell['extra']['class'])
				$cells .= " class=\"".trim($cell['extra']['class'])."\"";
			if(isset($cell['extra']['style']))
				$cells .= " style=\"".$cell['extra']['style']."\"";
			if(isset($cell['extra']['id']))
				$cells .= " id=\"".$cell['extra']['id']."\"";
			if(isset($cell['extra']['colspan']) && $cell['extra']['colspan'] > 1)
				$cells .= " colspan=\"".$cell['extra']['colspan']."\"";
			if(isset($cell['extra']['rowspan']) && $cell['extra']['rowspan'] > 1)
				$cells .= " rowspan=\"".$cell['extra']['rowspan']."\"";
			if(isset($cell['extra']['width']))
				$cells .= " width=\"".$cell['extra']['width']."\"";
			$cells .= ">";
			$cells .= $cell['data'];
			$cells .= "</td>\n";
		}
		$data['cells'] = $cells;
		$data['extra'] = $extra;
		$this->_rows[] = $data;

		$this->_cells = array();
	}
    
    function construct_html($heading="", $border=1, $class=null, $table_id="")
	{
		$table = "<div class=\"row\">\n";
        $table .= "  <div class=\"col-md-12 col-sm-12 col-xs-12\">\n";
        $table .= "    <div class=\"x_panel\">\n";
		if($border == 1) {
			if($heading != "") {
				$table .= "      <div class=\"x_title\">\n";
                $table .= "        <h2>{$heading}</h2>\n";
                $table .= "        <div class=\"clearfix\"></div>\n";
                $table .= "      </div>\n";
            }
        }
        $table .= "      <div class=\"x_content table-responsive\">\n";
		$table .= "        <table width=\"100%\"";
		if(!is_null($class))
			if(!$class)
				$class = "general";
        $tid = Page::$tid;
        $table .= " class=\"table ".$class." table_{$tid}\"";
        Page::$tid = $tid + 1;
		if($table_id != "")
            $table .= " id=\"".$table_id."\"";
		$table .= " cellspacing=\"0\">\n";
		if($this->_headers)
		{
			$table .= "          <thead>\n";
			$table .= "            <tr>\n";
			foreach($this->_headers as $key => $data)
			{
				$table .= "              <th";
				if($key == 0)
					$data['extra']['class'] .= " first";
				elseif(!isset($this->_headers[$key+1]))
					$data['extra']['class'] .= " last";
				if(isset($data['extra']['class']))
					$table .= " class=\"".$data['extra']['class']."\"";
				if(isset($data['extra']['style']))
					$table .= " style=\"".$data['extra']['style']."\"";
				if(isset($data['extra']['width']))
					$table .= " width=\"".$data['extra']['width']."\"";
				if(isset($data['extra']['colspan']) && $data['extra']['colspan'] > 1)
					$table .= " colspan=\"".$data['extra']['colspan']."\"";
				$table .= ">".$data['data']."</th>\n";
			}
			$table .= "            </tr>\n";
			$table .= "          </thead>\n";
		}
		$table .= "          <tbody>\n";
		$i = 1;
        foreach($this->_rows as $key => $table_row)
        {
            $table .= "            <tr";
            if(isset($table_row['extra']['id']))
                $table .= " id=\"{$table_row['extra']['id']}\"";

            if(!isset($table_row['extra']['class']))
                $table_row['extra']['class'] = '';

            if($key == 0)
                $table_row['extra']['class'] .= " first";
            else if(!isset($this->_rows[$key+1]))
                $table_row['extra']['class'] .= " last";
            if($i == 2 && !isset($table_row['extra']['no_alt_row']))
            {
                $table_row['extra']['class'] .= " alt_row";
                $i = 0;
            }
            $i++;
            if($table_row['extra']['class'])
                $table .= " class=\"".trim($table_row['extra']['class'])."\"";
            $table .= ">\n";
            $table .= $table_row['cells'];
            $table .= "            </tr>\n";
        }
		$table .= "          </tbody>\n";
		$table .= "        </table>\n";
        $table .= "        <div class=\"clearfix\"></div>\n";
        $table .= "      </div>\n";
        $table .= "    </div>\n";
        $table .= "  </div>\n";
        $table .= "</div>\n";
		// Clean up
		$this->_cells = $this->_rows = $this->_headers = array();
        
		return $table;
	}
}

class Form extends DefaultForm
{
    public $i=0;
    function generate_text_box($name, $value="", $options=array())
	{
		$input = "<input type=\"text\" name=\"".$name."\" value=\"".htmlspecialchars_uni($value)."\"";
		if(isset($options['class']))
			$input .= " class=\"text_input form-control ".$options['class']."\"";
		else
			$input .= " class=\"text_input form-control\"";
		if(isset($options['style']))
			$input .= " style=\"".$options['style']."\"";
		if(isset($options['id']))
			$input .= " id=\"".$options['id']."\"";
        else {
            $this->i++;
            $input .= " id=\"input_{$this->i}\"";
        }
		$input .= ">";
		return $input;
	}
    
    function generate_numeric_field($name, $value=0, $options=array())
	{
		if(is_numeric($value))
			$value = (float)$value;
		else
			$value = '';

		$input = "<input type=\"number\" name=\"{$name}\" value=\"{$value}\"";
		if(isset($options['min']))
			$input .= " min=\"".$options['min']."\"";
		if(isset($options['max']))
			$input .= " max=\"".$options['max']."\"";
		if(isset($options['step']))
			$input .= " step=\"".$options['step']."\"";
		if(isset($options['class']))
			$input .= " class=\"text_input form-control ".$options['class']."\"";
		else
			$input .= " class=\"text_input form-control\"";
		if(isset($options['style']))
			$input .= " style=\"".$options['style']."\"";
		if(isset($options['id']))
			$input .= " id=\"".$options['id']."\"";
        else {
            $this->i++;
            $input .= " id=\"input_{$this->i}\"";
        }
		$input .= " />";
		return $input;
	}
    
    function generate_password_box($name, $value="", $options=array())
	{
		$input = "<input type=\"password\" name=\"".$name."\" value=\"".htmlspecialchars_uni($value)."\"";
		if(isset($options['class']))
			$input .= " class=\"text_input form-control ".$options['class']."\"";
		else
			$input .= " class=\"text_input form-control\"";
		if(isset($options['id']))
			$input .= " id=\"".$options['id']."\"";
        else {
            $this->i++;
            $input .= " id=\"input_{$this->i}\"";
        }
		if(isset($options['autocomplete']))
			$input .= " autocomplete=\"".$options['autocomplete']."\"";
		$input .= " />";
		return $input;
	}
    
    function generate_file_upload_box($name, $options=array())
	{
		$input = "<input type=\"file\" name=\"{$name}\" id=\"i_{$name}\" class=\"sr-only inputfile\">\n";
        $input .= "<label for=\"i_{$name}\"";
        if(isset($options['class']))
			$class = $options['class'];
        $input .= " class=\"btn btn-primary {$class}\"";
		if(isset($options['style']))
			$input .= " style=\"".$options['style']."\"";
        $input .= "><i class=\"fas fa-upload\"></i></label>\n";
		return $input;

	}
    
    function generate_text_area($name, $value="", $options=array())
	{
		$textarea = "<textarea";
		if(!empty($name))
			$textarea .= " name=\"{$name}\"";
		if(isset($options['class']))
			$class = $options['class'];
        $textarea .= " class=\"form-control {$class}\"";
		if(isset($options['id']))
			$textarea .= " id=\"{$options['id']}\"";
        else {
            $this->i++;
            $textarea .= " id=\"input_{$this->i}\"";
        }
		if(isset($options['style']))
			$textarea .= " style=\"{$options['style']}\"";
		if(isset($options['disabled']) && $options['disabled'] !== false)
			$textarea .= " disabled=\"disabled\"";
		if(isset($options['readonly']) && $options['readonly'] !== false)
			$textarea .= " readonly=\"readonly\"";
		if(isset($options['maxlength']))
			$textarea .= " maxlength=\"{$options['maxlength']}\"";
		if(!isset($options['rows']))
			$options['rows'] = 5;
		if(!isset($options['cols']))
			$options['cols'] = 45;
		$textarea .= " rows=\"{$options['rows']}\" cols=\"{$options['cols']}\">";
		$textarea .= htmlspecialchars_uni($value);
		$textarea .= "</textarea>\n";
		return $textarea;
	}
    
    function generate_radio_button($name, $value="", $label="", $options=array())
	{
        $input = "  <input type=\"radio\" name=\"{$name}\" value=\"".htmlspecialchars_uni($value)."\"";
		if(isset($options['class']))
			$input .= " class=\"radio_input flat ".$options['class']."\"";
		else
			$input .= " class=\"radio_input flat\"";
		if(isset($options['id']))
			$input .= " id=\"".$options['id']."\"";
        else {
            $this->i++;
            $input .= " id=\"input_{$this->i}\"";
        }
		if(isset($options['checked']) && $options['checked'] != 0)
			$input .= " checked=\"checked\"";
		$input .= " />\n";
        $input .= "<label";
		if(isset($options['id']))
			$input .= " for=\"{$options['id']}\"";
        else
            $input .= " for=\"input_{$this->i}\"";
		if(isset($options['class']))
			$input .= " class=\"label_{$options['class']}\"";
		$input .= ">\n";
		if($label != "")
			$input .= $label;
		$input .= "</label>\n";
		return $input;
	}
    
    function generate_check_box($name, $value="", $label="", $options=array())
	{
        $input = "<input type=\"checkbox\" name=\"{$name}\" value=\"".htmlspecialchars_uni($value)."\"";
		if(isset($options['class']))
			$input .= " class=\"checkbox_input flat ".$options['class']."\"";
		else
			$input .= " class=\"checkbox_input flat\"";
		if(isset($options['id']))
			$input .= " id=\"".$options['id']."\"";
        else {
            $this->i++;
            $input .= " id=\"input_{$this->i}\"";
        }
		if(isset($options['checked']) && ($options['checked'] === true || $options['checked'] == 1))
			$input .= " checked=\"checked\"";
		if(isset($options['onclick']))
			$input .= " onclick=\"{$options['onclick']}\"";
		$input .= " /> ";
		$input .= "<label";
		if(isset($options['id']))
			$input .= " for=\"{$options['id']}\"";
        else
            $input .= " for=\"input_{$this->i}\"";
		if(isset($options['class']))
			$input .= " class=\"label_{$options['class']}\"";
		$input .= ">\n";
		if($label != "")
			$input .= $label;
		$input .= "</label>";
		return $input;
	}
    
    function generate_select_box($name, $option_list=array(), $selected=array(), $options=array())
	{
		if(!isset($options['multiple']))
			$select = "<select name=\"{$name}\"";
		else
		{
			$select = "<select name=\"{$name}\" multiple=\"multiple\"";
			if(!isset($options['size']))
				$options['size'] = count($option_list);
		}
		if(isset($options['class']))
			$class = $options['class'];
        $select .= " class=\"form-control {$class}\"";
		if(isset($options['id']))
			$select .= " id=\"{$options['id']}\"";
        else {
            $this->i++;
            $select .= " id=\"input_{$this->i}\"";
        }
		if(isset($options['size']))
			$select .= " size=\"{$options['size']}\"";
		$select .= ">\n";
		foreach($option_list as $value => $option)
		{
			$select_add = '';
			if((!is_array($selected) || !empty($selected)) && ((string)$value == (string)$selected || (is_array($selected) && in_array((string)$value, $selected))))
			{
				$select_add = " selected=\"selected\"";
			}
			$select .= "<option value=\"{$value}\"{$select_add}>{$option}</option>\n";
		}
		$select .= "</select>\n";
		return $select;
	}
    
    function generate_forum_select($name, $selected, $options=array(), $is_first=1)
	{
		global $fselectcache, $forum_cache, $selectoptions;

		if(!$selectoptions)
			$selectoptions = '';

		if(!isset($options['depth']))
			$options['depth'] = 0;

		$options['depth'] = (int)$options['depth'];

		if(!isset($options['pid']))
			$options['pid'] = 0;

		$pid = (int)$options['pid'];

		if(!is_array($fselectcache))
		{
			if(!is_array($forum_cache))
				$forum_cache = cache_forums();

			foreach($forum_cache as $fid => $forum)
				$fselectcache[$forum['pid']][$forum['disporder']][$forum['fid']] = $forum;
		}

		if($options['main_option'] && $is_first)
		{
			$select_add = '';
			if($selected == -1)
				$select_add = " selected=\"selected\"";

			$selectoptions .= "<option value=\"-1\"{$select_add}>{$options['main_option']}</option>\n";
		}

		if(isset($fselectcache[$pid]))
		{
			foreach($fselectcache[$pid] as $main)
			{
				foreach($main as $forum)
				{
					if($forum['fid'] != "0" && $forum['linkto'] == '')
					{
						$select_add = '';
						if(!empty($selected) && ($forum['fid'] == $selected || (is_array($selected) && in_array($forum['fid'], $selected))))
							$select_add = " selected=\"selected\"";

						$sep = '';
						if(isset($options['depth']))
							$sep = str_repeat("&nbsp;", $options['depth']);

						$style = "";
						if($forum['active'] == 0)
							$style = " style=\"font-style: italic;\"";

						$selectoptions .= "<option value=\"{$forum['fid']}\"{$style}{$select_add}>".$sep.htmlspecialchars_uni(strip_tags($forum['name']))."</option>\n";

						if($forum_cache[$forum['fid']])
						{
							$options['depth'] += 5;
							$options['pid'] = $forum['fid'];
							$this->generate_forum_select($forum['fid'], $selected, $options, 0);
							$options['depth'] -= 5;
						}
					}
				}
			}
		}

		if($is_first == 1)
		{
			if(!isset($options['multiple']))
				$select = "<select name=\"{$name}\"";
			else
				$select = "<select name=\"{$name}\" multiple=\"multiple\"";
			if(isset($options['class']))
				$select = $options['class'];
            $select .= " class=\"form-control {$class}\"";
			if(isset($options['id']))
				$select .= " id=\"{$options['id']}\"";
            else {
                $this->i++;
                $select .= " id=\"input_{$this->i}\"";
            }
			if(isset($options['size']))
				$select .= " size=\"{$options['size']}\"";
			$select .= ">\n".$selectoptions."</select>\n";
			$selectoptions = '';
			return $select;
		}
	}
    
    function generate_group_select($name, $selected=array(), $options=array())
	{
		global $cache;

		$select = "<select name=\"{$name}\"";

		if(isset($options['multiple']))
			$select .= " multiple=\"multiple\"";

		if(isset($options['class']))
			$class = $options['class'];
        $select .= " class=\"form-control {$class}\"";

		if(isset($options['id']))
			$select .= " id=\"{$options['id']}\"";
        else {
            $this->i++;
            $select .= " id=\"input_{$this->i}\"";
        }

		if(isset($options['size']))
			$select .= " size=\"{$options['size']}\"";

		$select .= ">\n";

		$groups_cache = $cache->read('usergroups');
		
		if(!is_array($selected))
			$selected = array($selected);
			
		foreach($groups_cache as $group)
		{
			$selected_add = "";
			
			
			if(in_array($group['gid'], $selected))
				$selected_add = " selected=\"selected\"";

			$select .= "<option value=\"{$group['gid']}\"{$selected_add}>".htmlspecialchars_uni($group['title'])."</option>";
		}

		$select .= "</select>";

		return $select;
	}
    
    function generate_submit_button($value, $options=array())
	{
		$input = "<input type=\"submit\" value=\"".htmlspecialchars_uni($value)."\"";

		if(isset($options['class']))
			$input .= " class=\"btn btn-success ".$options['class']."\"";
		else
			$input .= " class=\"btn btn-success\"";
		if(isset($options['id']))
			$input .= " id=\"".$options['id']."\"";
		if(isset($options['name']))
			$input .= " name=\"".$options['name']."\"";
		if(isset($options['disabled']))
			$input .= " disabled=\"disabled\"";
		if(isset($options['onclick']))
			$input .= " onclick=\"".str_replace('"', '\"', $options['onclick'])."\"";
		$input .= " />";
		return $input;
	}
    
    function generate_reset_button($value, $options=array())
	{
		$input = "<input type=\"reset\" value=\"".htmlspecialchars_uni($value)."\"";

		if(isset($options['class']))
			$input .= " class=\"btn btn-primary ".$options['class']."\"";
		else
			$input .= " class=\"btn btn-primary\"";
		if(isset($options['id']))
			$input .= " id=\"".$options['id']."\"";
		if(isset($options['name']))
			$input .= " name=\"".$options['name']."\"";
		$input .= " />";
		return $input;
	}
    
    function generate_yes_no_radio($name, $value="1", $int=true, $yes_options=array(), $no_options = array())
	{
		global $lang;

		// Checked status
		if($value == "no" || $value === '0')
		{
			$no_checked = 1;
			$yes_checked = 0;
		}
		else
		{
			$yes_checked = 1;
			$no_checked = 0;
		}
		// Element value
		if($int == true)
		{
			$yes_value = 1;
			$no_value = 0;
		}
		else
		{
			$yes_value = "yes";
			$no_value = "no";
		}

		if(!isset($yes_options['class']))
			$yes_options['class'] = '';

		if(!isset($no_options['class']))
			$no_options['class'] = '';

		// Set the options straight
		$yes_options['class'] = "radio_yes ".$yes_options['class'];
		$yes_options['checked'] = $yes_checked;
		$no_options['class'] = "radio_no ".$no_options['class'];
		$no_options['checked'] = $no_checked;
        
        $yesno = "<div class=\"btn-group\" data-toggle=\"buttons\">\n";
		$yesno .= "  <label";
        if(isset($yes_options['checked']) && $yes_options['checked'] != 0)
			$yesno .= " class=\"btn btn-default active\"";
        else
            $yesno .= " class=\"btn btn-default\"";
        $yesno .= " data-toggle-class=\"btn-default\" data-toggle-passive-class=\"btn-default\">\n";
        $yesno .= "    <input name=\"{$name}\" value=\"{$yes_value}\" data-icheck=\"no\" type=\"radio\"";
        if(isset($yes_options['checked']) && $yes_options['checked'] != 0)
			$yesno .= " class=\"{$yes_options['class']} active\" checked=\"checked\"";
        else
            $yesno .= " class=\"{$yes_options['class']}\"";
        $yesno .= " /> {$lang->yes}\n";
        $yesno .= "  </label>\n";
        $yesno .= "  <label";
        if(isset($no_options['checked']) && $no_options['checked'] != 0)
			$yesno .= " class=\"btn btn-default active\"";
        else
            $yesno .= " class=\"btn btn-default\"";
        $yesno .= " data-toggle-class=\"btn-default\" data-toggle-passive-class=\"btn-default\">\n";
        $yesno .= "    <input name=\"{$name}\" value=\"{$no_value}\" data-icheck=\"no\" type=\"radio\"";
        if(isset($no_options['checked']) && $no_options['checked'] != 0)
			$yesno .= " class=\"{$no_options['class']} active\" checked=\"checked\"";
        else
            $yesno .= " class=\"{$no_options['class']}\"";
        $yesno .= " /> {$lang->no}\n";
        $yesno .= "  </label>\n";
        $yesno .= "</div>";
        
		return $yesno;
	}
    
    function generate_on_off_radio($name, $value=1, $int=true, $on_options=array(), $off_options = array())
	{
		global $lang;

		// Checked status
		if($value == "off" || (int) $value !== 1)
		{
			$off_checked = 1;
			$on_checked = 0;
		}
		else
		{
			$on_checked = 1;
			$off_checked = 0;
		}
		// Element value
		if($int == true)
		{
			$on_value = 1;
			$off_value = 0;
		}
		else
		{
			$on_value = "on";
			$off_value = "off";
		}

		// Set the options straight
		if(!isset($on_options['class']))
			$on_options['class'] = '';

		if(!isset($off_options['class']))
			$off_options['class'] = '';

		$on_options['class'] = "radio_on ".$on_options['class'];
		$on_options['checked'] = $on_checked;
		$off_options['class'] = "radio_off ".$off_options['class'];
		$off_options['checked'] = $off_checked;

		$onoff = "<div class=\"btn-group\" data-toggle=\"buttons\">\n";
		$onoff .= "  <label";
        if(isset($on_options['checked']) && $on_options['checked'] != 0)
			$onoff .= " class=\"btn btn-default active\"";
        else
            $onoff .= " class=\"btn btn-default\"";
        $onoff .= " data-toggle-class=\"btn-default\" data-toggle-passive-class=\"btn-default\">\n";
        $onoff .= "    <input name=\"{$name}\" value=\"{$on_value}\" data-icheck=\"no\" type=\"radio\"";
        if(isset($on_options['checked']) && $on_options['checked'] != 0)
			$onoff .= " class=\"{$on_options['class']} active\" checked=\"checked\"";
        else
            $onoff .= " class=\"{$on_options['class']}\"";
        $onoff .= " /> {$lang->on}\n";
        $onoff .= "  </label>\n";
        $onoff .= "  <label";
        if(isset($off_options['checked']) && $off_options['checked'] != 0)
			$onoff .= " class=\"btn btn-default active\"";
        else
            $onoff .= " class=\"btn btn-default\"";
        $onoff .= " data-toggle-class=\"btn-default\" data-toggle-passive-class=\"btn-default\">\n";
        $onoff .= "    <input name=\"{$name}\" value=\"{$off_value}\" data-icheck=\"no\" type=\"radio\"";
        if(isset($off_options['checked']) && $off_options['checked'] != 0)
			$onoff .= " class=\"{$off_options['class']} active\" checked=\"checked\"";
        else
            $onoff .= " class=\"{$off_options['class']}\"";
        $onoff .= " /> {$lang->off}\n";
        $onoff .= "  </label>\n";
        $onoff .= "</div>";
        
		return $onoff;
	}
    
    function generate_date_select($name, $day=0,$month=0,$year=0)
	{
		global $lang;

		$months = array(
			1 => $lang->january,
			2 => $lang->february,
			3 => $lang->march,
			4 => $lang->april,
			5 => $lang->may,
			6 => $lang->june,
			7 => $lang->july,
			8 => $lang->august,
			9 => $lang->september,
			10 => $lang->october,
			11 => $lang->november,
			12 => $lang->december,
		);

		// Construct option list for days
		$days = array();
		for($i = 1; $i <= 31; ++$i)
			$days[$i] = $i;

		if(!$day)
			$day = date("j", TIME_NOW);

		if(!$month)
			$month = date("n", TIME_NOW);

		if(!$year)
			$year = date("Y", TIME_NOW);
        
        $built = "<div>";
        $built .= "  <div class=\"col-md-5 col-sm-5 col-xs-12\">\n";
		$built .= $this->generate_select_box($name.'_day', $days, (int)$day, array('id' => $name.'_day', 'class' => 'date-picker'))." &nbsp; ";
        $built .= "  </div>\n  <div class=\"col-md-5 col-sm-5 col-xs-12\">\n";
		$built .= $this->generate_select_box($name.'_month', $months, (int)$month, array('id' => $name.'_month'))." &nbsp; ";
        $built .= "  </div>\n  <div class=\"col-md-2 col-sm-5 col-xs-12\">\n";
		$built .= $this->generate_numeric_field($name.'_year', $year, array('id' => $name.'_year', 'style' => 'width: 100px;', 'min' => 0));
        $built .= "  </div>\n";
        $built .= "  <div class=\"clearfix\"></div>\n";
        $built .= "</div>";
		return $built;
	}
    
    function output_submit_wrapper($buttons)
	{
		global $plugins;
		$return = "<div class=\"x_panel form_button_wrapper\">\n";
		foreach($buttons as $button)
			$return .= "  " . $button." \n";
        $return .= "</div>";
		if($this->_return == false)
			echo $return;
		else
			return $return;
    }
}

class FormContainer extends DefaultFormContainer
{
}
