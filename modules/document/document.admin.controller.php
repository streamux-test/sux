<?php

class DocumentAdminController extends Controller
{

	function insertAdd() {

		$context = Context::getInstance();
		$posts = $context->getPostAll();
		$category = $posts['category'];		

		$returnURL = $context->getServer('REQUEST_URI');
		$resultYN = 'Y';
		$contentsPath = _SUX_PATH_ . 'modules/document/contents/';				

		$where = new QueryWhere();
		$where->set('category', $category);
		$this->model->selectFromDocument('id', $where);

		$numrows = $this->model->getNumRows();
		if ($numrows > 0) {
			$msg = $category . '페이지가 이미 등록되어 있습니다.';
			UIError::alertToBack($msg, true, array('url'=>$returnURL, 'delay'=>3));
			exit;
		} else {
			$this->model->selectFromBoardGroup('id', $where);
			$numrows = $this->model->getNumRows();
			if ($numrows> 0) {
				$msg = "${category}는 게시판에서 이미 사용하고 있습니다.";
				UIError::alertToBack($msg, true, array('url'=>$returnURL, 'delay'=>3));
				exit;
			}
		}

		$filters = '/(id|contents|_method)+$/i';
		$column = array('');
		foreach ($posts as $key => $value) {
			if (!(preg_match($filters, $key))) {
				if ($key === 'contents_path') {
					if (!preg_match('/(.tpl+)$/i', $value)) {
						$value = $value . $category . '.tpl';
						$contents_path = $value;
					}
				}

				$column[] = $value;			
			}			
		}
		$column[] = 'now()';

		$result = $this->model->insertIntoDocument($column);
		if (!$result) {
			$msg .= "${category}페이지 등록을 실패하였습니다.<br>";
		}else{

			//  컨텐츠 내용 저장 
			$contentsPath =Utils::convertAbsolutePath($contents_path, $contentsPath);
			$fp = fopen($contentsPath, "w");
			fwrite($fp, $contents);
			fclose($fp);
			$msg .= "${category}페이지가 정상적으로 등록되었습니다.<br>";

			// 라우트 키 저장 
			$filePath = _SUX_PATH_ . 'caches/document.cache.php';
			$routes = array();
			if (is_readable($filePath)) {
				include($filePath);
				$routes['categories'] = $categories;
				$routes['action'] = $action;

				$pattern = sprintf('/(%s)+/i', $category);
				if (!preg_match($pattern, implode(',', $routes['categories']))) {
					$routes['categories'][] = $category; 
				}
			}

			$modueCache = ModuleCache::getInstance();
			$modueCache->saveCacheForRoute($filePath, $routes);
		}		
		//$msg = Tracer::getInstance()->getMessage();
		$data = array(	"result"=>$resultYN,
						"msg"=>$msg);

		$this->callback($data);
	}

	function updateModify() {

		$context = Context::getInstance();
		$posts = $context->getPostAll();
		$id = $posts['id'];
		$category = $posts['category'];
		$contents_path = $posts['contents_path'];
		$contents = $posts['contents'];

		$dataObj = array();
		$resultYN = "Y";
		$msg = "";
		$contentsPath = _SUX_PATH_ . 'modules/document/contents/';
		
		$filters = '/(id|category|contents|_method)+$/';
		$column = array();
		foreach ($posts as $key => $value) {			
			if (!(preg_match($filters, $key))) {
				$column[$key] = $value;			
			}			
		}

		if (!preg_match('/(.tpl+)$/i', $contents_path)) {
			$column['contents_path'] = $contents_path . $category . '.tpl';
		} else {
			$column['contents_path'] = $contents_path;
		}		

		$where = new QueryWhere();
		$where->set('id', $id);
		$result = $this->model->updateDocument($column, $where);
		if (!$result) {
			$msg .= "$category 페이지 수정을 실패하였습니다.";
			$resultYN = "N";	
		} else {

			$contentsPath =Utils::convertAbsolutePath($column['contents_path'], $contentsPath);
			$fp = fopen($contentsPath, "w");
			fwrite($fp, $contents);
			fclose($fp);

			$msg .= "$category 페이지 수정을 완료하였습니다.";
			$resultYN = "Y";
		}
		//$msg = Tracer::getInstance()->getMessage();
		$data = array(	"member"=>$dataObj,
						"result"=>$resultYN,
						"msg"=>$msg);

		$this->callback($data);
	}

	function deleteDelete() {

		$context = Context::getInstance();
		$category = $context->getPost('category');
		$id = $context->getPost('id');

		$resultYN = "Y";
		$msg = "";
		$contentsPath = _SUX_PATH_ . 'modules/document/contents/';

		$where = new QueryWhere();
		$where->set('id', $id);
		$this->model->selectFromDocument('contents_path', $where);
		$row = $this->model->getRow();		
			
		$result = $this->model->deleteFromDocument($where);
		if (!$result) {
			$msg .= "${category} 페이지 삭제를 실패하였습니다.<br>";
		} else {
			$msg .= "${category} 페이지을 삭제하였습니다.<br>";

			$contentsPath =Utils::convertAbsolutePath($row['contents_path'], $contentsPath);
			$result = Utils::deleteFile($contentsPath);
			if (!$result) {
				$msg .= "$category 컨텐츠파일 삭제를 실패하였습니다.<br>";
			}

			// 라우트 카테고리 키 저장 
			$filePath = _SUX_PATH_ . 'caches/document.cache.php';
			$routes = array();
			if (is_readable($filePath)) {
				include($filePath);
				$routes['categories'] = $categories;
				$routes['action'] = $action;

				$len = count($routes['categories']);
				for($i=0; $i<$len; $i++) {
					$input = $routes['categories'][$i];
					//$msg .= $input . '  ';
					if (strcmp($input, $category) === 0) {
						array_splice($routes['categories'], $i, 1);
						break;
					}
				}
			}

			$modueCache = ModuleCache::getInstance();
			$modueCache->saveCacheForRoute($filePath, $routes);
		}
		//$msg .= Tracer::getInstance()->getMessage();
		$data = array(	"result"=>$resultYN,
						"msg"=>$msg);

		$this->callback($data);
	}
}