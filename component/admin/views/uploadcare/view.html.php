<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
class UploadcareViewUploadcare extends JView
{
	public function display($tpl = null)
	{
		$this->addToolBar();
		$this->setDocument();
		parent::display($tpl);
	}
	protected function addToolBar()
	{
		JToolBarHelper::title('Uploadcare');
		JToolBarHelper::preferences('com_uploadcare');
	}

	function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle('Uploadcare Administration');
	}
}
