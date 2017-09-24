<div class="articles ui-edgebox">
  <div class="del">
    <h2 class="blind">페이지 삭제 알림</h2>
    <div class="tt">
      <div class="imgbox">
        <span>페이지 삭제 알림</span>  
      </div>
    </div>
    <div class="box">
      <ul>
        <li>
          <img src="{$rootPath}modules/admin/tpl/images/icon_stop.gif" width="30" height="13" alt="경고아이콘" class="icon">
          <span class="title1">{$documentData.category} 페이지를 정말로 삭제 하시겠습니까?</span>
          <input type="hidden" name="_method" value="delete">
          <input type="hidden" name="category" value="{$documentData.category}">
          <input type="hidden" name="id" value="{$documentData.id}">
        </li>
        <li>
          <span class="title2">다시한번 잘 확인해 주세요.</span>
          <a href="#" data-key="del" class="button-del"><span>[삭제]</span></a>
          <a href="#" data-key="back" class="button-cancel"><span>[취소]</span></a>   
        </li>
      </ul>
    </div>
  </div>
</div>