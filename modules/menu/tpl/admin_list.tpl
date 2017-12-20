<div class="sx-contents">
  <section class="sx-menu-panel">
    <header class="header">
      <h1 class="title">메뉴 관리</h1>    
      <form action="{$rootPath}menu-admin/add" name="f_admin_menu_add" class="search_form sx-form-horizontal">
        <div class="sx-form-inline clearfix">
          <span class="title_down">전체 메뉴(7)</span>
          <div class="sx-input-group pull-right">
            <label for="menuName" class="sr-only">메뉴 생성</label>
            <input type="text" id="menuName" name="menu_name" class="sx-form-control" placeholder="메뉴 영문 이름"><input type="submit" name="confirm" class="sx-btn" value="메뉴 생성" />
          </div>            
        </div>
      </form>
    </header>    
    
    <div class="sx_plugin_panel">
      <div class="sx-box-content sx_draggable_list">
        <div id="SlidingBoxPanel" class="sx_sliding_box">
          <div class="sx_menu sx_menu_list">
            <input type="hidden" name="gnb_json_path" value="{$rootPath}menu-admin/gnb-list">
            <input type="hidden" name="list_json_url" value="{$rootPath}menu-admin/list-json">
            <input type="hidden" name="save_json_url" value="{$rootPath}menu-admin/save-json">
            <input type="hidden" name="menu_url" value="{$rootPath}menu-admin/menu">
            <input type="hidden" name="location_back" value="{$rootPath}menu-admin">

            <header class="sx-header-panel">
              <h2>메뉴 리스트</h2>
              <div class="sx-btn-group">
                <button name="edit_seleced_menu" onclick="jsux.fn.list.editSelectedMenu();" class="sx-btn">편집하기</button>
                <button name="save_json" onclick="jsux.fn.list.saveJson();" class="sx-btn">저장하기</button>
              </div>
            </header>
            <div class="swiper_container_wrapper_tree">
              <div class="swiper-container swiper_container_draggable_list">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <ul class="menu_list_panel selected_menu_list" id="selectedMenuList">
                      <!--
                        @ jquery templete
                        @ name  warnMsgTmpl, menuListTmpl
                      -->
                      <li>
                        <span class="sx_text_msg">로딩 중...</span>   
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="swiper-scrollbar"></div>
              </div><!-- end of swiper-container //-->
            </div>
          </div>

          <script type="jquery-templete" id="menuInfoTmpl">
            <div class="sx_menu sx_menu_info">
              <header class="sx-header-panel">
                <h2>메뉴 정보 수정</h2>
              </header>
              <form action="{$rootPath}menu-admin/menu" name="f_admin_menu_modify" method="post" class="sx-form-horizontal">
                <input type="hidden" name="_method" value="update">
                <input type="hidden" name="id" value="{literal}${id}{/literal}">
                <input type="hidden" name="category" value="{literal}${category}{/literal}">

                <div class="sx-form-group">
                  <label for="emptyLabel" class="sx-control-label label_width">카테고리 이름</label>
                  <span class="sx-form-control" disabled>{literal}${category}{/literal}</span>
                </div>
                <div class="sx-form-group">
                  <label for="menuName" class="sx-control-label label_width">메뉴 이름</label>
                  <input type="text" id="menuName" name="name" size="20" maxlength="20" value="{literal}${name}{/literal}" class="sx-form-control">
                </div>
                <div class="sx-form-group">
                  <label for="urllink" class="sx-control-label label_width">URL 링크</label>
                  <input type="text" id="urllink" name="url" size="25" maxlength="120" value="{literal}${url}{/literal}" class="sx-form-control">
                </div>
                <div class="sx-form-group">
                  <label for="activateState" class="sx-control-label label_width">활성화 상태</label>
                  <select id="activateState" name="is_active" class="sx-form-control">
                    {assign var=states value=['On'=>1,'Off'=>0]}
                    {foreach $states as $key=>$value}
                      <option value="{$value}" {literal}{{if is_active == {/literal} {$value} {literal} }} selected=selected {{/if}}{/literal}>{$key}</option>
                    {/foreach}
                  </select>
                </div>
                <div class="btn_group text-center">
                  <button type="submit" id="btnConfirm" class="sx-btn">확인</button>
                  <button type="button" id="btnCancel" onclick="jsux.fn.list.canceModifyMenu();" class="sx-btn">취소</button>
                </div> 
              </form>
            </div>
          </script>
        </div><!-- sliding box -->
      </div>      
    </div><!-- sx_plugin_panel -->

    <div class="draggable_action text-center"><button name="btn_add_draggable" class="sx-btn lst_rotate" title="메뉴 리스트에 등록하기"><i class="xi-angle-up"></i><i class="xi-angle-left"></i></button><button name="btn_remove_draggable" class="sx-btn" title="메뉴 리스트에서 제거하기"><i class="xi-angle-down"></i><i class="xi-angle-right"></i></button></div>

    <div class="sx_plugin_panel">
      <div class="sx-box-content sx_item_list">
        <input type="hidden" name="list_json_path" value="{$rootPath}menu-admin/list-json">
        <header class="sx-header-panel">
          <h2>등록 가능 메뉴</h2>
        </header>
        <div class="swiper_container_wrapper_list">
          <div class="swiper-container swiper_container_item_list">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <ul class="menu_list_panel addable_menu_list" id="addableMenuList">
                  <!--
                    @ jquery templete
                    @ name  warnMsgTmpl, menuListTmpl
                  -->
                  <li>
                    <span class="sx_text_msg">로딩 중...</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="swiper-scrollbar"></div>
          </div><!-- end of swiper-container //-->
        </div>        
      </div>
    </div>
  </section>
</div>

<!-- mobile start -->
<script type="jquery-templete" id="warnMsgTmpl">
{literal}
  <li>
    <span class="sx_text_msg sx-text-warning">${msg}</span>         
  </li>
{/literal}
</script>

<script type="jquery-templete" id="menuListTmpl">
  <li>
    <a href="#">
      <span class="sx_name">
        {literal}${name}{/literal}
      </span>
      <span class="sx_date"><i class="xi-clock-o"></i>{literal}${$item.editDate(date)}{/literal}</span>
    </a>
    <div class="sx-btn-group">
      <button name="btn_add" class="sx-btn" onclick="jsux.fn.list.addMenu({literal}${id}{/literal});">추가</button> 
      <button class="sx-btn sx-btn-info" onclick="jsux.fn.list.modifyMenuInfo({literal}${id}{/literal});">정보수정</button>
      <button name="btn_remove" class="sx-btn sx-btn-warning" onclick="jsux.fn.list.removeMenu({literal}${id}{/literal});">삭제</button>
    </div>
  </li>
</script>

<script type="jquery-templete" id="treeListTmpl">
  <li data-id="{literal}${id}{/literal}" data-type="item_draggable">
    <button type="button" name="btn_drag">
      <i class="xi-drag-vertical"></i>      
    </button>    
    <a href="#">
      <i class="xi-folder"></i>
      <i class="xi-folder-open"></i>
      <span class="sx_name">        
        {literal}${name}{/literal}
      </span>
    </a>
    <div class="sx-btn-group">
      <button class="sx-btn btn_select" onclick="jsux.fn.list.selectMenu({literal}${id}{/literal}{literal}${depth}{/literal});">선택</button>
      <button class="sx-btn sx-btn-info" onclick="jsux.fn.list.modifyMenuInfo({literal}${id}{/literal});">정보수정</button>
      <button class="sx-btn sx-btn-warning" onclick="jsux.fn.list.removeTreeMenu({literal}${id}{/literal});">삭제</button>
    </div>
    <div class="sub_mask">
      <ul></ul>
    </div>
  </li>
</script>
<!-- mobile end -->

<!--<a href="{$rootPath}menu-admin/{literal}${id}{/literal}/modify" class="sx-btn sx-btn-info" onclick="jsux.fn.list.modifyInfo({literal}${id}{/literal});">정보수정</a>-->