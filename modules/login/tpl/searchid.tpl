<div class="articles"> 
  <div class="sx_login">
    <h1 class="title">아이디 찾기</h1>
    <p class="sx_subtitle">SUX Board 솔루션을 이용해 주셔서 진심으로 감사합니다.</p>
     <div class="sx_login_box sx-edgebox-2px">
      <form action="{$rootPath}search-id" name="f_searchid" method="post">

        <div class="sx-form-group">
          <i class="xi-user xi-2x"></i>
          <label for="userName" class="sx-control-label">이름</label>
          <input type="text" name="user_name" id="userName" maxlength="22" class="sx-form-control">
        </div>
        <div class="sx-form-group">
          <i class="xi-mail xi-2x"></i>
          <label for="emailAddress" class="sx-control-label">이메일 주소</label>
          <input type="text" name="email_address" id="emailAddress" maxlength="34" class="sx-form-control">
        </div>
        <div class="sx-form-inline text-center submit_top_margin">
          <div class="sx-input-group">
            <input type="submit" name="btn_confirm" value="확 인" class="sx-btn sx-space-right sx_btn_md">
            <a href="{$rootPath}login" class="sx-btn sx_btn_md">취소</a>
          </div>
        </div>
      </form>
      <div class="sx_login_footer">
        <a href="{$rootPath}member-join">회원가입</a><span>|</span><a href="{$rootPath}search-password">비밀번호 찾기</a>
      </div>
    </div>
    <div class="notice_panel">
      <ul>
        <li><span>위 사항을 입력해 주세요.</span></li>
        <li>기타 궁금한 사항이나 질문은 Q&amp;A 게시판을 이용해 주세요.</li>
      </ul>
    </div>    
  </div>      
</div> 