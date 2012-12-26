<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );

class plgButtonUploadcare extends JPlugin {
	function plgJFUploader(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onDisplay($name)
	{
		$application = JFactory::getApplication();
		$user =& JFactory::getUser();
		$prefix = '';
		if ($application->isAdmin()) {
			$prefix = '../';
		}

		// needed because of user friendly urls!! Relative urls for the css does not work then.
		$relative_dir = parse_url(JURI::base());
		$relative_dir = $relative_dir['path'];
		$relative_dir = rtrim($relative_dir,"\\/.") . '/'; // we replace to get a consistent output with different php versions!

		$css = ".button2-left{background: transparent url(".$relative_dir.$prefix."plugins/editors-xtd/uploadcare/logo.png) no-repeat 100% 3px;}";

		// we need to use the right part to get the right user!!
		if ($application->isAdmin()) {
			// front and admin do not have the sames session. I have to create a secret token to check that the request is not modified
			$jConfig = new JConfig();
			$secret = $jConfig->secret;
			$ts = time();
			$token = md5($user->id . $secret . $ts);
			$stub =  $prefix. "administrator/index.php";
			$link = $stub . '?option=com_uploadcare&tmpl=component&type=uploadcare&e_name='.$name .'&ts='.$ts.'&myid=' . $user->id . '&mytoken=' . $token;
		} else {
			$stub =  "administrator/index.php";
			$link = $prefix.$stub . '?option=com_uploadcare&tmpl=component&type=uploadcarer&e_name='.$name;
		}
			
		$popup_width =  680;
		$popup_height = 520;

		$doc = &JFactory::getDocument();
		if ($application->isAdmin()) {
			$doc->addStyleDeclaration($css);
		}
		$button = new JObject();
		$button->set('modal', true);
		$button->set('text', JText::_('Uploadcare'));
		$button->set('name', 'jfuButton');
		$button->set('options', "{handler: 'iframe',size: {x: $popup_width, y: $popup_height}}");
		$button->set('link', $link);
		return $button;
	}
}
?>