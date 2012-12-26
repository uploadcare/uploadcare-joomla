<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<?php
    include dirname(__FILE__).'/../../../uploadcare-php/uploadcare/lib/5.2/Uploadcare.php';
    jimport('joomla.application.component.helper');
    $public_key = JComponentHelper::getParams('com_uploadcare')->get('publickey');
    $secret_key = JComponentHelper::getParams('com_uploadcare')->get('secretkey');
	$api = new Uploadcare_Api($public_key, $secret_key);
	
	$type = 'uploadcare_files';
	
	$page = 1;
	if (isset($_GET['page_num'])) {
		$page = $_GET['page_num'];
	}
	
	if (isset($_GET['delete'])) {
		$file_id = $_GET['file_id'];
		$file = $api->getFile($file_id);
		$file->delete();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$conditions = array("file_id='".$file_id."'");
		$query->delete($db->quotename('#__uploadcare'));
		$query->where($conditions);
		$db->setQuery($query);		
		$db->query();
	}
	
	$uri = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
	
	function change_param($uri, $param, $value) {
		$parsed = parse_url($uri);
		$path = $parsed['path'];
		$query = array();
		parse_str($parsed['query'], $query);
		$query[$param] = $value;
		return $path.'?'.http_build_query($query);
	}
	
	/*
	try {
		$files = $api->getFileList($page);
	} catch (Exception $e) {
		$page = 1;
		$files = $api->getFileList($page);
	}
	*/
	//$pagination_info = $api->getFilePaginationInfo();	
	$pagination_info = array();
	$db = JFactory::getDbo();
	$query = 'SELECT COUNT(id) as count from #__uploadcare';
	$db->setQuery($query);
	$results = $db->loadObjectList();	
	$result = $results[0];
	$count = $result->count;
	
	$pagination_info['pages'] = floor($count / 20);
	$query = $db->getQuery(true);
	$query->select(array('file_id'));
	$query->from('#__uploadcare');
	$query->limit((($page-1)*20), 20);
	$db->setQuery($query);
	$files = $db->loadObjectList();
?>
	<?php if ($pagination_info['pages'] > 1): ?>
	<div>
	Pages:
	<?php for ($i = 1; $i <= $pagination_info['pages']; $i++): ?>
		<?php if ($i == $page): ?>
			<span style="margin-left: 5px;"><?php echo $i; ?></span>
		<?php else: ?>
			<a href="<?php echo change_param($uri, 'page_num', $i);?>" style="margin-left: 5px;"><?php echo $i;?></a>
		<?php endif; ?>
	<?php endfor; ?>	
	<?php endif; ?>
		<div class="tablenav top">
			<div>
				<?php foreach ($files as $_file): ?>
					<?php $file = $api->getFile($_file->file_id); ?>
					<div style="float: left; width: 200px; height: 200px; margin-left: 10px; margin-bottom: 10px; text-align: center;">
						<a href="<?php echo $file; ?>" target="_blank"><img src="<?php echo $file->scaleCrop(200, 200, true); ?>" /></a><br />
						<a href="<?php echo change_param(change_param($uri, 'delete', 'true'), 'file_id', $file->getFileId());?>" onclick="document.location.href=document.location.href+'&delete=true&file_id=<?php echo $file->getFileId(); ?>'" style="color: red;">Delete</a> | <a href="<?php echo $file; ?>" target="_blank">View</a>
					</div>
				<?php endforeach; ?>
			</div>
			<br class="clear" />
	<?php if ($pagination_info['pages'] > 1): ?>
	<div>
	Pages:
	<?php for ($i = 1; $i <= $pagination_info['pages']; $i++): ?>
		<?php if ($i == $page): ?>
			<span style="margin-left: 5px;"><?php echo $i; ?></span>
		<?php else: ?>
			<a href="<?php echo change_param($uri, 'page_num', $i);?>" style="margin-left: 5px;"><?php echo $i;?></a>
		<?php endif; ?>
	<?php endfor; ?>	
	<?php endif; ?>			