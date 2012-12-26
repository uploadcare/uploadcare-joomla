<?php
defined('_JEXEC') or die('Restricted access'); 
jimport('joomla.application.component.controller');
class UploadcareController extends JController
{
	public function display()
	{
		$tmpl = JRequest::getVar( 'tmpl' );
		if (!$tmpl) {
			$tmpl = 'default';
		}
		$view = & $this->getView( 'uploadcare', 'html' );
		$view->display($tmpl);
	}
}