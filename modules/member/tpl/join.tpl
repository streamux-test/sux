<section class="section sx_member">
  <h1 class="title">회원 가입</h1>
  <form name="f_member_join" action="{$rootPath}member-join" method="post" class="sx-form-horizontal">
    <input type="hidden" name="_method" value="insert">
    <input type="hidden" name="category" value="member">
    <p class="sx_text_notice">
      <img src="{$rootPath}modules/admin/tpl/images/icon_notice.gif" class="icon_notice">
      <span>*(별표)는 필수 입력 사항입니다.</span>
    </p>
    <div class="sx-form-group">
      <label for="userId" class="sx-control-label sx_label_width">아이디 *</label><input type="text" id="userId" name="user_id" value="" class="sx-form-control">
      <input type="button" name="checkID" value='아이디 중복체크' class="sx-btn sx-btn-block">
    </div>    
    <div class="sx-form-group">
      <label for="emailAddress" class="sx-control-label sx_label_width">이메일 *</label><input type="text" id="emailAddress" name="email_address" value="" class="sx-form-control">
    </div>
    <div class="sx-form-group">
      <label for="nickName" class="sx-control-label sx_label_width">닉네임 *</label><input type="text" id="nickName" name="nickname" value="" class="sx-form-control">
    </div>
    <div class="sx-form-group">
      <label for="userName" class="sx-control-label sx_label_width">이름 *</label><input type="text" id="userName" name="user_name" value="" class="sx-form-control">
    </div>
    <div class="sx-form-group">
      <label for="password" class="sx-control-label sx_label_width">비밀번호 *</label><input type="password" id="password" name="password" value="" class="sx-form-control">
    </div>
    <div class="sx-form-group">
      <label for="passwordConf" class="sx-control-label sx_label_width">비밀번호 확인 *</label><input type="password" id="passwordConf" name="password_conf" value="" class="sx-form-control">
    </div>
    <p class="sx_text_notice">
      <img src="{$rootPath}modules/admin/tpl/images/icon_notice.gif" class="icon_notice">
      <span>아래 내용은 선택 사항입니다.</span>
    </p>
    <div class="sx-form-group">
      <label for="hp" class="sx-control-label sx_label_width">휴대폰 번호</label>
      <input type="text" id="hp" name="hp" class="sx-form-control">
    </div>
    <div class="sx-form-group">
      <label for="job" class="sx-control-label sx_label_width">직업</label>
      <select name="job" id="job" class="sx-form-control">
        <option value="">선택하기</option>
        {assign var='jobList' value=['프리랜서','교수','교사','학생','기업인','회사원','정치인','주부','농어업','기타']}
        {foreach from=$jobList item=value}                  
          <option value="{$value}" {if $fieldData['job'] === $value} selected {/if}>{$value}</option>
        {/foreach}
      </select>
    </div>
    <div class="sx-form-inline">
      <label for="emptyName" class="sx-control-label sx_label_width">취미</label>
      <div class="sx-form-group">
        <div class="sx-input-group">
          {assign var='hobbyBoxes' value=['인터넷','독서','여행','낚시','바둑','기타']}
          {foreach from=$hobbyBoxes item=mItem name=hobby}
            {assign var=index value=$smarty.foreach.hobby.index}           
            <input type="checkbox" name="hobby{$index}" id="hobby{$index}" value="{$mItem}"><label for="hobby{$index}" class="sx-text-normal">{$mItem}</label>
          {/foreach} 
        </div>             
      </div>          
    </div>
    <div class="sx-form-group">
      <label for="joinPath" class="sx-control-label sx_label_width">가입경로</label>
      <select name="join_path" id="joinPath" class="sx-form-control">
        <option value="">선택하기</option>
        {assign var='pathList' value=['네이버검색','네이버지식인','다음카페','학교소개','친구소개','차량광고','기타']}
        {foreach from=$pathList item=value}                 
          <option value="{$value}">{$value}</option>
        {/foreach}
      </select>
    </div>     
    <div class="sx-form-group">
      <label for="recommendId" class="sx-control-label sx_label_width">추천 아이디</label>
      <input type="text" id="recommendId" name="recommend_id" class="sx-form-control">
    </div>
    <div class="sx-form-inline text-center submit_top_margin">
      <div class="sx-input-group">
        <input type="submit" name="btn_confirm" id="btnConfirm" size="10" value="확 인" class="sx-btn btn_space">
        <input type="button" name="btn_cancel" id="btnCancel" value="취 소" onclick="location.href='{$rootPath}login'"  class="sx-btn">
      </div>        
    </div>     
  </form>
</section>