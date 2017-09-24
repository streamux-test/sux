<?php

class InstallView extends View
{

  function displayInstall() {

    $this->displayTerms();
  }

  function displayTerms() {

    $this->skin_path_list['root'] = _SUX_ROOT_;
    $this->skin_path_list['header'] = _SUX_PATH_.'modules/install/tpl/_header.tpl';
    $this->skin_path_list['footer'] = _SUX_PATH_.'modules/install/tpl/_footer.tpl';
    $this->skin_path_list['contents'] = _SUX_PATH_ . 'modules/install/tpl/terms.tpl';

    $this->output();
  }

  function displaySetupDb() {

    $context = Context::getInstance();
    $this->request_data['action'] = 'setupDb';

    $this->skin_path_list['root'] = _SUX_ROOT_;
    $this->skin_path_list['header'] = _SUX_PATH_.'modules/install/tpl/_header.tpl';
    $this->skin_path_list['footer'] = _SUX_PATH_.'modules/install/tpl/_footer.tpl';
    $this->skin_path_list['contents'] = _SUX_PATH_ . 'modules/install/tpl/db_setup.tpl';

    $this->output();
  }

  function displaySetupAdmin() {

    $context = Context::getInstance();
    $this->request_data['action'] = 'setupAdmin';

    $this->skin_path_list['root'] = _SUX_ROOT_;
    $this->skin_path_list['header'] = _SUX_PATH_.'modules/install/tpl/_header.tpl';
    $this->skin_path_list['footer'] = _SUX_PATH_.'modules/install/tpl/_footer.tpl';
    $this->skin_path_list['contents'] = _SUX_PATH_ . 'modules/install/tpl/admin_setup.tpl';

    $this->output();
  } 
}