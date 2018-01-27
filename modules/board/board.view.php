<?php

class BoardView extends View
{
  function getNonTagFields() {

    return array('category','user_id','user_name','nickname');
  }

  function getSimpleTagFields() {

    return array('title');
  }

  function displayList() {

    $context = Context::getInstance();
    $UIError = UIError::getInstance();

    $returnURL = $context->getServer('REQUEST_URI');
    $requestData = $context->getRequestAll();
    $sessionData = $context->getSessionAll();
    
    $category = $context->getParameter('category');
    $passover = (int) $requestData['passover'];    
    $find = $requestData['find'];
    $search = $requestData['search'];
    
    if (empty($passover)) {
       $passover = 0;
    }
    
    $where = new QueryWhere();
    $where->set('category',$category,'=');
    $this->model->select('board_group', '*', $where);

    $groupData = $this->model->getRow();
    $headerPath = $groupData['header_path'];
    $skinName = $groupData['skin_path'];
    $footerPath = $groupData['footer_path'];
    $limit = $groupData['limit_pagination'];

    /**
     * css, js file path handler
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . "modules/board/skin/${skinName}/";
    $skinRealPath = _SUX_PATH_ . "modules/board/skin/${skinName}/";    

    /**
     * @var headerPath
     * @descripttion
     * smarty include 상대경로 접근 방식이 달라서 convertAbsolutePath()함수에 절대경로 처리 함.
     */   
    $headerPath = Utils::convertAbsolutePath($headerPath, _SUX_PATH_);
    $footerPath = Utils::convertAbsolutePath($footerPath, _SUX_PATH_);

    $testPath = '../files/document/';
    $templateRealPath = Utils::getRealPath($testPath);
    echo "<br><br><br> - " . $testPath . "<br>" . $templateRealPath . "<br>" . $templateRealPath;

    if (!is_readable($headerPath)) {
      $headerPath = "{$skinRealPath}/_header.tpl";
      $UIError->add("상단 파일경로가 올바르지 않습니다.");
    }

    if (!is_readable($footerPath)) {
      $footerPath = "{$skinRealPath}/_footer.tpl";
      $UIError->add("하단 파일경로가 올바르지 않습니다.");
    }

    $where = new QueryWhere();    

    if (isset($search) && $search) {
      $where->set($find, $search, 'like');
    }

    // total rows from board
    $where->set('category', $category, '=');
    $result = $this->model->select('board', '*', $where);

    if ($result) {      
      $numrows = $this->model->getNumRows();
      $where->reset();

      if (isset($search) && $search) {
        $where->set($find, $search, 'like');
      }

      $where->set('category', $category, '=');
      $result = $this->model->select('board', '*', $where, 'igroup_count desc, ssunseo_count asc', $passover, $limit);

      if ($result) {
        $numrows2 = $this->model->getNumRows();
        $contentData['list'] = $this->model->getRows();         
        $today = date("Y-m-d");

        for ($i=0; $i<count($contentData['list']); $i++) {

          $id = (int) $contentData['list'][$i]['id'];
          $user_id = FormSecurity::decodeByNonTags($contentData['list'][$i]['user_id']);          
          $name = $contentData['list'][$i]['nickname'] | $contentData['list'][$i]['user_name'];
          $name = FormSecurity::decodeByNonTags($name); 
          $title = FormSecurity::decodeBySimpleTags($contentData['list'][$i]['title']);
          $content = FormSecurity::decodeByText($contentData['list'][$i]['content']);
          $progressStep = FormSecurity::decodeByNonTags($contentData['list'][$i]['progress_step']);
          $hit = (int) $contentData['list'][$i]['readed_count'];
          $space = (int) $contentData['list'][$i]['space_count'];
          $filename = $contentData['list'][$i]['filename'];
          $filetype = $contentData['list'][$i]['filetype'];
          
          $date =$contentData['list'][$i]['date'];        
          $compareDayArr = split(' ', $date);
          $compareDay = $compareDayArr[0];
          
          if (isset($search) && $search != '') {
            $search_replace = sprintf('<span class="sx-text-success">%s</span>', $search);
            $find_key = strtolower($find);

            switch ($find_key) {
              case 'title':
                $title = str_replace($search,$search_replace,$title);
                break;
              case 'name':
                $name = str_replace($search,$search_replace,$name);
                break;
              default:
                break;
            }
          }

          $subject = array();
          $subject['id'] = $id;
          $subject['title'] = $title;         
          $subject['icon_img_name'] = '';
          $subject['progress_step_name'] = '';

          // 'hide' in value is a class name of CSS
          $subject['space'] = 0;
          $subject['prefix_icon_label'] = '';
          $subject['prefix_icon_type'] = 0;

          $subject['icon_img'] = 'sx-hide';
          $subject['comment_num'] = '';
          $subject['icon_new'] = 'sx-hide';
          $subject['icon_opkey'] = 'sx-hide';

          if (isset($space) && $space) {
            $subject['space'] = $space*10;
            $subject['prefix_icon_label'] = '답변';
            $subject['prefix_icon_color'] = 'sx-bg-reply';
          }

          //공지글 설정은 개발 예정 
          /*if (isset($isNotice) && $isNotice != '') {
            $subject['space'] = '10px';
            $subject['prefix_icon'] = '공지';
            $subject['prefix_icon_color'] = 'sx-bg-notice';
          }*/

          if (isset($filename) && $filename){
            $imgname = '';

            if (preg_match('/(image\/gif|image\/jpeg|image\/x-png|image\/bmp)+/', $filetype)) {             
              $imgname = "icon_img.png";
            } else if ($download === 'y'  && preg_match('/(application/x-zip-compressed|application/zip)+/', $filetype)) { 
              $imgname = "icon_down.png";
            }

            if ($imgname !== '') {
              $subject['icon_img'] = 'sx-show-inline';
              $subject['icon_img_name'] = $imgname;
            } 
          }

          $where->reset();
          $where->set('content_id', $id, '=');
          $this->model->select('comment', 'id', $where);
          $commentNums = $this->model->getNumRows();

          if ($commentNums > 0) {
            $subject['comment_num'] = $commentNums;
          }

          if ($compareDay == $today){
            $subject['icon_new'] = 'sx-show-inline';
            $subject['icon_new_title'] = 'new';
          }
          
          $subject['progress_step_name'] = ($progressStep === '초기화') ? '' : $progressStep;
          $subject['icon_progress_color'] = 'sx-bg-progress';

          $contentData['list'][$i]['name'] = $name;
          $contentData['list'][$i]['hit'] = $hit;
          $contentData['list'][$i]['space'] = $space;
          $dateArr = split(' ', $date);
          $contentData['list'][$i]['date'] = $dateArr[0];
          $contentData['list'][$i]['subject'] = $subject;

          $subject = null;
        }
      } else {
        $UIError->add('게시물 목록 가져오기를 실패하였습니다.');
      }
    } else {
      $UIError->add('게시물 전체 목록 가져오기를 실패하였습니다.');
    }

    // navi logic
    $navi = New Navigator();
    $navi->passover = $passover;
    $navi->limit = $limit;
    $navi->total = $numrows;
    $navi->init();

    $this->request_data = $requestData;
    $this->session_data = $sessionData;

    $this->document_data['jscode'] = 'list';
    $this->document_data['module_code'] = 'board';
    $this->document_data['module_name'] = '게시판 목록'; 
    $this->document_data['pagination'] = $navi->get();
    $this->document_data['group'] = $groupData;
    $this->document_data['content'] = $contentData;
    $this->document_data['category'] = $category;
    
    $this->skin_path_list['root'] = $rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath;
    $this->skin_path_list['header'] = $headerPath;
    $this->skin_path_list['content'] = "{$skinRealPath}/list.tpl";
    $this->skin_path_list['footer'] = $footerPath;

    $this->output();
  } 

  function displayRead() {

    $UIError = UIError::getInstance();
    $context = Context::getInstance();
    $requestData = $context->getRequestAll();
    $sessionData = $context->getSessionAll();

    $find = $requestData['find'];
    $search = $requestData['search'];

    $category = $context->getParameter('category');
    $id = $context->getParameter('id');     
    $grade = $sessionData['grade'];
    $nickname = $sessionData['nickname'] | $sessionData['user_name'];
    $password = $sessionData['password'];    

    $where = new QueryWhere();
    $where->set('category',$category,'=');
    $this->model->select('board_group', '*', $where);

    $groupData = $this->model->getRow();
    $nonmember = strtolower($groupData['allow_nonmember']);
    $grade_r = strtolower($groupData['grade_r']);
    $is_readable = strtolower($groupData['is_readable']);
    $is_download = strtolower($groupData['is_download']);
    $is_comment = strtolower($groupData['is_comment']);
    $is_progress_step = strtolower($groupData['is_progress_step']);
    $headerPath = $groupData['header_path'];
    $skinName = $groupData['skin_path'];
    $footerPath = $groupData['footer_path'];
    $contentType = $groupData['board_type'];

    /**
     * css, js file path handler
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . "modules/board/skin/${skinName}/";
    $skinRealPath = "modules/board/skin/${skinName}/";

    $headerPath =Utils::convertAbsolutePath($headerPath, _SUX_PATH_);
    $skinRealPath =Utils::convertAbsolutePath($skinRealPath, _SUX_PATH_);
    $footerPath = Utils::convertAbsolutePath($footerPath, _SUX_PATH_);

    $testPath = "/modules/board/skin/${skinName}/";
    $getRealPath = Utils::getRealPath($testPath);
    $convertRealPath = Utils::convertRealPath($testPath);

    echo "<br><br><br> sux_path : " . _SUX_PATH_ . "<br>test : " . $getRealPath . "<br> real : " . $convertRealPath . "<br> absolute : " . $skinRealPath;

    if (!is_readable($headerPath)) {
      $headerPath = "{$skinRealPath}/_header.tpl";
      $UIError->add('상단 파일경로가 올바르지 않습니다.');
    }

    if (!is_readable($footerPath)) {
      $footerPath = "{$skinRealPath}/_footer.tpl";
      $UIError->add('하단 파일경로가 올바르지 않습니다.');
    }

    if (isset($grade) && $grade) {
      $level = $grade;
    } else {
      $level = 0;
    }

    $returnURL = $rootPath . $category;
    if (isset($search) && $search) {
      $returnURL .= "?find=${find}&search=${search}";
    }

    // level
    if ($level < $grade_r) {
      $msg .= '죄송합니다. 읽기 권한이 없습니다.';
      UIError::alertTo($msg, true, array('url'=>$returnURL, 'delay'=>3));
      exit;
    }

    // nonmember's authority
    if ($nonmember != 'y' && empty($nickname)) {
      $returnToURL = $rootPath . $category . '/'. $id ;
      $msg = '죄송합니다. 이곳은 회원 전용 게시판 입니다.<br>로그인을 먼저 하세요.';
      UIError::alertTo( $msg, true, array('url'=>$rootPath . 'login?return_url=' . $returnToURL, 'delay'=>3));
      exit;
    }

    // admin
    if ($is_readable == 'n' && $context->checkAdminPass() === FALSE) {
      $msg = '죄송합니다. 이곳은 관리자 전용 게시판입니다.';
      UIError::alertTo( $msg, true, array('url'=>$returnURL, 'delay'=>3));
      exit;
    }

    // read panel
    $where->reset();
    $where->set('id',$id,'=');
    $this->model->select('board', 'readed_count', $where);

    $row = $this->model->getRow();
    $hit = $row['readed_count']+1;
    $this->model->update('board', array('readed_count'=>$hit), $where);
    $this->model->select('board','*', $where);

    $contentData = $this->model->getRow();
    $nickname = $contentData['nickname'] | $contentData['user_name'];
    $contentData['nickname'] = FormSecurity::decodeByNonTags($nickname);
    $nickname = '';
    $contentData['title'] = FormSecurity::decodeBySimpleTags($contentData['title']);    

    $filename = $contentData['filename'];
    $filetype = $contentData['filetype'];
    $filesize = $contentData['filesize'];
    $content = $contentData['content'];

    switch ($contentType) {
      case 'text':
        $content = FormSecurity::decodeByText($content);
        break;
      case 'html':
        $content = FormSecurity::decodeByHtml($content);    
        break;
    }

    $contentData['content'] = nl2br($content);
    $content = '';    
    $contentData['css_down'] = 'hide';
    $contentData['css_img'] = 'hide';

    if (isset($filename) && $filetype) {
      $fileupPath = $rootPath . "files/board/${filename}";

      if (($is_download === 'y') && preg_match( '/(application\/x-zip-compressed|application\/zip)+', $filetype)) {
        $contentData['css_down'] = 'sx-show';
      } else if (preg_match( '/(jpg|jpeg|gif|png)+/i', $filetype)){

        $imageInfo = getimagesize($fileupPath);
        $imageType = $imageInfo[2];

        if ($imageType === IMAGETYPE_JPEG) {
          $image = imagecreatefromjpeg($fileupPath);
        } elseif($imageType === IMAGETYPE_GIF) {
          $image = imagecreatefromgif($fileupPath);
        } elseif($imageType === IMAGETYPE_PNG) {
          $image = imagecreatefrompng($fileupPath);
        }

        $contentData['css_img'] = 'sx-show';
        $contentData['css_img_width'] = imagesx($image) . 'px';
      }
      $contentData['fileup_name'] = $filename;
      $contentData['fileup_path'] = $fileupPath;
    }

    // Opkey
    $contentData['css_progress_step'] = 'hide';

    if ($is_progress_step === 'y') {
      $contentData['css_progress_step'] = 'show';
      $progressSteps = array(
        '진행완료'=>'progress_step_done',
        '진행중'=>'progress_step_ing',
        '입금완료'=>'progress_step_charged',
        '미입금'=>'progress_step_nocharged',
        '메일발송'=>'progress_step_sended',
        '초기화'=>'progress_step_reset'
      );

      $stepKey = strtolower($contentData['progress_step']);     
      $contentData[$progressSteps[$stepKey]] = 'checked';
    }

    // comment
    $contentData['css_comment'] = 'hide';
    $commentData = array();  

    if ($is_comment === 'y') {
      $contentData['css_comment'] = 'show';

      $where->reset();
      $where->set('content_id',$id,'=');
      $this->model->select('comment','*', $where);
      $commentData['num'] = $this->model->getNumRows();
      $commentData['list'] = $this->model->getRows();
    }

    $this->request_data = $requestData;
    $this->session_data = $sessionData;

    $this->document_data['jscode'] = 'read';
    $this->document_data['module_code'] = 'board';
    $this->document_data['module_name'] = '게시판 읽기';
    $this->document_data['category'] = $category;
    $this->document_data['id'] = $id;
    $this->document_data['group'] = $groupData;
    $this->document_data['content'] = $contentData;
    $this->document_data['comments'] = $commentData;
    $this->document_data['category'] = $category;

    $this->skin_path_list['root'] =$rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath;
    $this->skin_path_list['header'] = $headerPath;    
    $this->skin_path_list['content'] = "{$skinRealPath}read.tpl";
    $this->skin_path_list['footer'] = $footerPath;
    $this->skin_path_list['comment'] =  "{$skinRealPath}_comment.tpl";
    $this->skin_path_list['progress_step'] =  "{$skinRealPath}_progress_step.tpl"; 

    $this->output();    
  }

  function displayWrite() {

    $UIError = UIError::getInstance();
    $context = Context::getInstance();
    $requestData = $context->getRequestAll();
    $sessionData = $context->getSessionAll();
    
    $find = $requestData['find'];
    $search = $requestData['search'];
    $category = $context->getParameter('category');
    $grade = $sessionData['grade'];
    $nickname = $sessionData['nickname'] | $sessionData['user_name'];
    $password = $sessionData['password'];    
    $admin_pass = $context->checkAdminPass();

    $where = new QueryWhere();
    $where->set('category',$category,'=');
    $this->model->select('board_group', '*', $where);

    $groupData = $this->model->getRow();
    $nonemember = $groupData['allow_nonmember'];
    $grade_r = $groupData['grade_r'];
    $grade_w = $groupData['grade_w'];
    $is_writable   = $groupData['is_writable'];
    $headerPath = $groupData['header_path'];
    $skinName = $groupData['skin_path'];
    $footerPath = $groupData['footer_path'];

    /**
     * css, js file path handler
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . "modules/board/skin/${skinName}/";
    $skinRealPath = _SUX_PATH_ . "modules/board/skin/${skinName}/";
    
    $headerPath =Utils::convertAbsolutePath($headerPath, _SUX_PATH_);
    $footerPath = Utils::convertAbsolutePath($footerPath, _SUX_PATH_);

    if (!is_readable($headerPath)) {
      $headerPath = "{$skinRealPath}/_header.tpl";
      $UIError->add('상단 파일경로가 올바르지 않습니다.');
    }

    if (!is_readable($footerPath)) {
      $footerPath = "{$skinRealPath}/_footer.tpl";
      $UIError->add('하단 파일경로가 올바르지 않습니다.');
    }

    if ($nonemember === 'n' && empty($nickname)) {
      $returnToURL = $rootPath . $category . '/write';
      $msg = '죄송합니다. 이곳은 회원 전용 게시판 입니다.<br>로그인을 먼저 하세요.';
      UIError::alertTo( $msg, true, array('url'=>$rootPath . 'login?return_url=' . $returnToURL, 'delay'=>3));
    }

    if (isset($grade) && $grade) {
      $level = $grade;
    } else {
      $level = 0;
    }

    $returnURL = urldecode($context->getServer('HTTP_REFERER'));
    if ($level < $grade_r) {
      $returnURL = $rootPath . $category;
    }

    if (isset($search) && $search) {
      $returnURL .= "?find=${find}&search=${search}";
    }

    if ($level < $grade_w) {
      $msg .= '죄송합니다. 쓰기 권한이 없습니다.';      
      UIError::alertTo( $msg, true, array('url'=>$returnURL, 'delay'=>3));
      exit;
    }

    if ($is_writable === 'n') {
      if ($admin_pass === FALSE) {
        $msg = '죄송합니다. 이곳은 관리자 전용게시판입니다.';
        UIError::alertTo( $msg, true, array('url'=>$returnURL, 'delay'=>3));
        exit;
      }
    }

    $contentData = array();
    $contentData['wallname'] = Utils::getWallKey();

    if (isset($nickname) && $nickname) {
      $contentData['css_user_label'] = 'sx-hide';
      $contentData['user_name_type'] = 'hidden';
      $contentData['user_pass_type'] = 'hidden';
      $contentData['nickname'] = $nickname;
      $contentData['user_password'] = $password;
    } else {
      $contentData['css_user_label'] = 'sx-show-inline';      
      $contentData['user_name_type'] = 'text';
      $contentData['user_pass_type'] = 'password';
      $contentData['nickname'] = 'Guest';
      $contentData['user_password'] = '';
    }

    $this->request_data = $requestData;
    $this->session_data = $sessionData;

    $this->document_data['jscode'] = 'write';
    $this->document_data['module_code'] = 'board';
    $this->document_data['module_name'] = '게시판 쓰기';
    $this->document_data['category'] = $category;
    $this->document_data['group'] = $groupData;
    $this->document_data['content'] = $contentData;

    $this->skin_path_list['root'] = $rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath;    
    $this->skin_path_list['header'] = $headerPath;    
    $this->skin_path_list['content'] = "{$skinRealPath}/write.tpl";
    $this->skin_path_list['footer'] = $footerPath;    

    $this->output();
  }

  function displayModify() {

    $UIError = UIError::getInstance();
    $context = Context::getInstance();
    
    $sessionData = $context->getSessionAll();
    $requestData = $context->getRequestAll();

    $category = $context->getParameter('category');
    $id = $context->getParameter('id');
    $find = $requestData['find'];
    $search = $requestData['search'];    
    $grade = $sessionData['grade'];   
    $nickname = $sessionData['nickname'] | $sessionData['user_name'];
    $password = $this->session_data['password'];  

    $where = new QueryWhere();
    $where->set('category',$category,'=');
    $this->model->select('board_group', '*', $where);

    $groupData = $this->model->getRow();
    $grade_r = $groupData['grade_r'];
    $grade_m = $groupData['grade_m'];
    $nonemember = $groupData['allow_nonmember'];
    $is_modifiable = $groupData['is_modifiable'];
    $is_progress_step = $groupData['is_progress_step'];
    $headerPath =  $groupData['header_path'];
    $skinName =  $groupData['skin_path'];
    $footerPath =  $groupData['footer_path'];

    /**
     * css, js file path handler
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . "modules/board/skin/${skinName}/";
    $skinRealPath = _SUX_PATH_ . "modules/board/skin/${skinName}/";
    $this->document_data['uri'] = $rootPath.$category;

    $headerPath =Utils::convertAbsolutePath($headerPath, _SUX_PATH_);
    $footerPath = Utils::convertAbsolutePath($footerPath, _SUX_PATH_);

    if (!is_readable($headerPath)) {
      $headerPath = "{$skinRealPath}/_header.tpl";
      $UIError->add('상단 파일경로가 올바르지 않습니다.');
    }

    if (!is_readable($footerPath)) {
      $footerPath = "{$skinRealPath}/_footer.tpl";
      $UIError->add('하단 파일경로가 올바르지 않습니다.');
    }

    $where->reset();
    $where->set('id', $id, '=');
    $this->model->select('board', '*', $where);

    $contentData = $this->model->getRow();
    $contentData['user_name'] = $contentData['user_name'];
    $contentData['nickname'] = $contentData['nickname'] | $contentData['user_name'];
    $contentData['title'] = $contentData['title'];
    $contentData['content'] = FormSecurity::decodeByHtml($contentData['content']);    
    
    $contentType = $contentData['content_type'];
    $contentData['content_type_' . $contentType] = 'checked';
    unset($contentData['password']);
    $contentData['wallname'] = Utils::getWallKey();

    if ($nonemember === 'n' && empty($nickname)) {
      $returnToURL = $rootPath . $category . ' / '. $id . '/modify';
      $msg = '죄송합니다. 이곳은 회원 전용 게시판 입니다.<br>로그인을 먼저 하세요.';
      UIError::alertTo( $msg, true, array('url'=>$rootPath . 'login?return_url=' . $returnToURL, 'delay'=>3));
    }

    if (isset($grade) && $grade) {
      $level = $grade;
    } else {
      $level = 0;
    }

    $returnURL = urldecode($context->getServer('HTTP_REFERER'));
    if ($level < $grade_r) {
      $returnURL = $rootPath . $category;
    }

    if (isset($search) && $search) {
      $returnURL .= "?find=${find}&search=${search}";
    }

    if ($level < $grade_m) {
      $msg = '죄송합니다. 수정권한이 없습니다.';
      UIError::alertTo( $msg, true, array('url'=>$returnURL, 'delay'=>3));
      exit;
    }

    $admin_pass = $context->checkAdminPass(); 
    if ($is_modifiable === 'n' && $admin_pass === false) {
      $msg = '죄송합니다. 이곳은 관리자 전용 게시판입니다.';
      UIError::alertTo( $msg, true, array('url'=>$returnURL, 'delay'=>3));
    }

    $this->document_data['jscode'] = 'modify';
    $this->document_data['module_code'] = 'board';
    $this->document_data['module_name'] = '게시판 수정';
    $this->document_data['category'] = $category;
    $this->document_data['id'] = $id;
    $this->document_data['group'] = $groupData;
    $this->document_data['content'] = $contentData;

    $this->skin_path_list['root'] =$rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath; 
    $this->skin_path_list['header'] = $headerPath;    
    $this->skin_path_list['content'] = "{$skinRealPath}/modify.tpl";
    $this->skin_path_list['footer'] = $footerPath;    

    $this->output();
  }

  function displayReply() {

    $UIError = UIError::getInstance();
    $context = Context::getInstance();
    $requestData = $context->getRequestAll();
    $sessionData = $context->getSessionAll();    

    $find = $requestData['find'];
    $search = $requestData['search'];
    $category = $context->getParameter('category');
    $id = $context->getParameter('id');
    $grade = $sessionData['grade'];    
    $nickname = $sessionData['nickname'] | $sessionData['user_name'];
    $password = $sessionData['password'];    
    $admin_pass = $context->checkAdminPass();

    $where = new QueryWhere();
    $where->set('category',$category,'=');
    $this->model->select('board_group', '*', $where);

    $groupData = $this->model->getRow();
    $is_progress_step = $groupData['is_progress_step'];
    $grade_r = $groupData["grade_r"];
    $grade_re = $groupData["grade_re"];
    $is_repliable = $groupData["is_repliable"];
    $headerPath = $groupData['header_path'];
    $skinName = $groupData['skin_path'];
    $footerPath = $groupData['footer_path'];

    /**
     * css, js file path handler
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . "modules/board/skin/${skinName}/";
    $skinRealPath = _SUX_PATH_ . "modules/board/skin/${skinName}/";   
    
    $headerPath =Utils::convertAbsolutePath($headerPath, _SUX_PATH_);
    $footerPath = Utils::convertAbsolutePath($footerPath, _SUX_PATH_);

    if (!is_readable($headerPath)) {
      $headerPath = "{$skinRealPath}/_header.tpl";
      $UIError->add('상단 파일경로가 올바르지 않습니다.');
    }

    if (!is_readable($footerPath)) {
      $footerPath = "{$skinRealPath}/_footer.tpl";
      $UIError->add('하단 파일경로가 올바르지 않습니다.');
    }

    $where->reset();
    $where->set('id',$id,'=');
    $this->model->select('board', '*', $where);

    $contentData = $this->model->getRow();    
    $contentData['nickname'] = empty($nickname) ? 'Guest' : $nickname;
    $contentData['title'] = htmlspecialchars($contentData['title']);
    $contentType = trim($contentData['conetents_type']);

    $is_download = $contentData['is_download'];
    $filename = $contentData['filename'];
    $filetype = $contentData['filetype'];
    
    if ($contentType === 'html'){
      $contentData['content'] = htmlspecialchars_decode($contentData['content']);
    }else if ($contentType === 'text'){
      $contentData['content'] = nl2br(htmlspecialchars($contentData['content']));
    }
    
    $contentData['css_down'] = 'hide';
    $contentData['css_img'] = 'hide';
    $fileupPath = '';

    if ($filename) {
      $fileupPath = $rootPath . "files/board/${filename}";

      if (($is_download == 'y') && ($filetype === ("application/x-zip-compressed" || "application/zip"))) {
        $contentData['css_down'] = 'sx-show';
      } else if ($filetype !== ("application/x-zip-compressed" || "application/zip")){
        $image_info = getimagesize($fileupPath);
        $image_type = $image_info[2];

        if ( $image_type === IMAGETYPE_JPEG ) {
          $image = imagecreatefromjpeg($fileupPath);
        } elseif( $image_type === IMAGETYPE_GIF ) {
          $image = imagecreatefromgif($fileupPath);
        } elseif( $image_type === IMAGETYPE_PNG ) {
          $image = imagecreatefrompng($fileupPath);
        }
        $contentData['css_img'] = 'sx-show';
        $contentData['img_width'] = imagesx($image) . 'px';
      }
      $contentData['fileup_name'] = $filename;
      $contentData['fileup_path'] = $fileupPath;
    }  

    // Create Wall Key
    $contentData['wallname'] = Utils::getWallKey();    
    $contentType = $contentData['content_type'];
    $contentData['content_type_' . $contentType] = 'checked';
    
    // 비회원 허용 유무 
    if ($nonemember === 'n' && empty($user_name)) {
      $returnToURL = $rootPath . $category . '/'. $id . '/reply' ;
      $msg = '죄송합니다. 이곳은 회원 전용 게시판 입니다.<br>로그인을 먼저 하세요.';
      UIError::alertTo( $msg, true, array('url'=>$rootPath . 'login?return_url=' . $returnToURL, 'delay'=>3));
    }

    if (isset($grade) && $grade) {
      $level = $grade;
    } else {
      $level = 0;
    }

    $returnURL = urldecode($context->getServer('HTTP_REFERER'));

    if ($level < $grade_r) {
      $returnURL = $rootPath . $category;
    }

    if (isset($search) && $search) {
      $returnURL .= "?find=${find}&search=${search}";
    }

    if ($level < $grade_re) {
      $msg = '죄송합니다. 답변권한이 없습니다.';
      UIError::alertTo( $msg, true, array('url'=>$returnURL, 'delay'=>3));
      exit;
    }

    if ($is_repliable === 'n') {
      if ($admin_pass == false) {
        $msg = '죄송합니다. 이곳은 관리지 전용게시판입니다.';
        UIError::alertTo( $msg, true, array('url'=>$returnURL, 'delay'=>3));
        exit;
      }
    }

    if (isset($nickname) && $nickname) {
      $contentData['css_user_label'] = 'sx-hide';
      $contentData['user_name_type'] = 'hidden';
      $contentData['user_pass_type'] = 'hidden';
      $contentData['nickname'] = $nickname;
      $contentData['user_password'] = $password;
    } else {
      $contentData['css_user_label'] = 'sx-show-inline';      
      $contentData['user_name_type'] = 'text';
      $contentData['nickname'] = 'Guest';
      $contentData['user_pass_type'] = 'password';
      $contentData['user_password'] = '';
    }

    $this->request_data = $requestData;
    $this->session_data = $sessionData;

    $this->document_data['jscode'] = 'reply';
    $this->document_data['module_code'] = 'board';
    $this->document_data['module_name'] = '게시판 답변';
    $this->document_data['category'] = $category;
    $this->document_data['id'] = $id;
    $this->document_data['group'] = $groupData;
    $this->document_data['content'] = $contentData;
    $this->document_data['uri'] = $rootPath.$category;

    $this->skin_path_list['root'] =$rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath; 
    $this->skin_path_list['header'] = $headerPath;    
    $this->skin_path_list['content'] = "{$skinRealPath}/reply.tpl";
    $this->skin_path_list['footer'] = $footerPath;    

    $this->output();
  }

  function displayDelete() {

    $UIError = UIError::getInstance();
    $context = Context::getInstance();

    $category = $context->getParameter('category');
    $id = $context->getParameter('id');

    $where = new QueryWhere();
    $where->set('category', $category, '=');
    $this->model->select('board_group', '*');

    $groupData = $this->model->getRow();
    $headerPath = $groupData['header_path'];
    $skinName = $groupData['skin_path'];
    $footerPath = $groupData['footer_path'];

    /**
     * css, js file path handler
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . "modules/board/skin/${skinName}/";
    $skinRealPath = _SUX_PATH_ . "modules/board/skin/${skinName}/";   
    $this->document_data['uri'] = $rootPath.$category;

    $headerPath =Utils::convertAbsolutePath($headerPath, _SUX_PATH_);
    $footerPath = Utils::convertAbsolutePath($footerPath, _SUX_PATH_);

    if (!is_readable($headerPath)) {
      $headerPath = "{$skinRealPath}/_header.tpl";
      $UIError->add('상단 파일경로가 올바르지 않습니다.');
    }

    if (!is_readable($footerPath)) {
      $footerPath = "{$skinRealPath}/_footer.tpl";
      $UIError->add('하단 파일경로가 올바르지 않습니다.');
    }
    
    $where->reset();
    $where->set('id', $id, '=');
    $this->model->select('board', 'id, category, user_name', $where);
    $contentData = $this->model->getRow();

    $this->document_data['jscode'] = 'delete';
    $this->document_data['module_code'] = 'board';
    $this->document_data['module_name'] = '게시물 삭제'; 
    $this->document_data['category'] = $category;
    $this->document_data['id'] = $id;
    $this->document_data['group'] = $groupData;
    $this->document_data['content'] = $contentData;

    $this->skin_path_list['root'] =$rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath; 
    $this->skin_path_list['header'] = $headerPath;    
    $this->skin_path_list['content'] = "{$skinRealPath}/delete.tpl";
    $this->skin_path_list['footer'] = $footerPath;    

    $this->output();
  }

  function displayCommentJson() {

    $resultYN = 'Y';
    $msg = '';

    $context = Context::getInstance();

    $category = $context->getParameter('category');
    $cid = $context->getParameter('id');
    $rootPath = _SUX_ROOT_;

    $where = QueryWhere::getInstance();
    $where->set('content_id',$cid);
    $result = $this->model->select('comment','*', $where);
    $msg .= Tracer::getInstance()->getMessage();

    if (!$result) {
      $msg .= '댓글 가져오기를  실패하였습니다.';
    }
    $rows = $this->model->getRows();
 
    $data = array(
            'data'=>$rows,
            'url'=>$rootPath . $category,
            'result'=>$resultYN,
            'msg'=>$msg,
            'delay'=>0);

    $this->callback($data);
  }

  function displayDeleteComment() {

    $UIError = UIError::getInstance();
    $context = Context::getInstance();

    $category = $context->getParameter('category');
    $mid = $context->getParameter('id');  // 메인 아이디
    $id = $context->getParameter('sid');    // 서브 아이디 

    $this->document_data['category'] = $category;
    $this->document_data['mid'] = $mid;

    $this->document_data['jscode'] ='delete';
    $this->document_data['module_code'] = 'board';
    $this->document_data['module_name'] = '게시물 삭제';

    $where = new QueryWhere();
    $where->set('category', $category, '=');
    $this->model->select('board_group', '*', $where);

    $groupData = $this->model->getRow();
    $headerPath = $groupData['header_path'];
    $skinName = $groupData['skin_path'];
    $footerPath = $groupData['footer_path'];

    /**
     * css, js file path handler
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . "modules/board/skin/${skinName}/";
    $skinRealPath = _SUX_PATH_ . "modules/board/skin/${skinName}/";   

    $headerPath =Utils::convertAbsolutePath($headerPath, _SUX_PATH_);
    $footerPath = Utils::convertAbsolutePath($footerPath, _SUX_PATH_);

    if (!is_readable($headerPath)) {
      $headerPath = "{$skinRealPath}/_header.tpl";
      $UIError->add('상단 파일경로가 올바르지 않습니다.');
    }

    if (!is_readable($footerPath)) {
      $footerPath = "{$skinRealPath}/_footer.tpl";
      $UIError->add('하단 파일경로가 올바르지 않습니다.');
    }

    $where->reset();
    $where->set('id', $id, '=');
    $this->model->select('comment', '*', $where);

    $contentData = $this->model->getRow();
    $contentData['id'] = $id;
    $this->document_data['group'] = $groupData;
    $this->document_data['content'] = $contentData;

    $this->skin_path_list['root'] =$rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath; 
    $this->skin_path_list['header'] = $headerPath;    
    $this->skin_path_list['content'] = "{$skinRealPath}/delete_comment.tpl";
    $this->skin_path_list['footer'] = $footerPath;  

    $this->output();
  }
}