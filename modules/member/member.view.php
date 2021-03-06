<?php

class MemberView extends View {

  var $class_name = 'member_view';

  function displayMember() {

    $this->displayMemberJoin();
  }

  function displayMemberJoin() {

    $UIError = UIError::getInstance();
    $context = Context::getInstance();

    $context->setSession('sx_sended_join_mail', '');

    /**
     * css, js file path handler
     */
    $this->document_data['jscode'] = 'join';
    $this->document_data['module_code'] = 'member';
    $this->document_data['module_name'] = '회원 가입';
    
    /**
     * skin directory path
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . 'modules/member/tpl/';
    $skinRealPath = _SUX_PATH_ . 'modules/member/tpl/';

    $headerPath = _SUX_PATH_ . 'common/_header.tpl';
    if (!is_readable($headerPath)) {
      $headerPath = $skinRealPath . "_header.tpl";
      $UIError->add("상단 파일경로가 올바르지 않습니다.");
    }

    $footerPath = _SUX_PATH_ . 'common/_footer.tpl';
    if (!is_readable($footerPath)) {
      $footerPath = $skinRealPath . "_footer.tpl";
      $UIError->add("하단 파일경로가 올바르지 않습니다.");
    }
    $contentsPath = $skinRealPath . 'join.tpl';

    $this->model->select('member_group', '*');

    $this->document_data['group'] = $this->model->getRows();

    $this->skin_path_list['root'] = $rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath;
    $this->skin_path_list['header'] = $headerPath;
    $this->skin_path_list['content'] = $contentsPath;
    $this->skin_path_list['footer'] = $footerPath;

    $this->output();
  }

  function displayMemberModify() {

    $context = Context::getInstance();
    $this->session_data = $context->getSessionAll();
    $category = $this->session_data['category'];
    $user_id = $this->session_data['user_id'];

    /**
     * css, js file path handler
     */
    $this->document_data['jscode'] = 'modify';
    $this->document_data['module_code'] = 'member';
    $this->document_data['module_name'] = '회원 정보 수정';

    /**
     * skin directory path
     */
    $rootPath = _SUX_ROOT_;
    $skinPath = _SUX_ROOT_ . 'modules/member/tpl/';
    $skinRealPath = _SUX_PATH_ . 'modules/member/tpl/';

    $headerPath = _SUX_PATH_ . 'common/_header.tpl';
    if (!is_readable($headerPath)) {
      $headerPath = $skinRealPath . "_header.tpl";
      $UIError->add("상단 파일경로가 올바르지 않습니다.");
    }

    $footerPath = _SUX_PATH_ . 'common/_footer.tpl';
    if (!is_readable($footerPath)) {
      $footerPath = $skinRealPath . "_footer.tpl";
      $UIError->add("하단 파일경로가 올바르지 않습니다.");
    }

    $contentsPath = $skinRealPath . 'modify.tpl';

    $where = new QueryWhere();
    $where->set('category', $category);
    $where->set('user_id', $user_id, '=', 'and');
    $result = $this->model->select('member', '*', $where);
    //echo Tracer::getInstance()->output();
    if ($result) {
      $contentsData = $this->model->getRow();
      if (isset($contentsData['hp1']) && $contentsData['hp1']) {
        $contentsData['hp'] = $contentsData['hp1'] .' - '. $contentsData['hp2'] . ' - '. $contentsData['hp3'];
      }
      $contentsData['hobby'] = explode(',', $contentsData['hobby']);
    } 

    $this->document_data['content'] = $contentsData;
    
    $this->skin_path_list['root'] = $rootPath;
    $this->skin_path_list['path'] = $skinPath;
    $this->skin_path_list['realPath'] = $skinRealPath;
    $this->skin_path_list['header'] = $headerPath;
    $this->skin_path_list['content'] = $contentsPath;
    $this->skin_path_list['footer'] = $footerPath;

    $this->output();
  }

  function displayMemberGroupList() {

    $msg = '데이터 로드를 완료하였습니다.';
    $result = $this->model->select('member_group', '*');
    if ($result) {
      $data = array(  'data'=>$this->model->getRows(),
              'msg'=>$msg);
    } else {
      $msg = '데이터 로드를 실패하였습니다.';
      $data = array('msg'=>$msg);     
    }

    $this->callback($data);
  } 
}
