<?php
/* Smarty version 3.1.31, created on 2017-08-30 11:29:59
  from "/Applications/MAMP/htdocs/sux/modules/popup/tpl/admin_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59a68597460997_65557011',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea136852f9f2f31473bbc36b01e8fa90ffa67225' => 
    array (
      0 => '/Applications/MAMP/htdocs/sux/modules/popup/tpl/admin_add.tpl',
      1 => 1501062118,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a68597460997_65557011 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('rootPath', $_smarty_tpl->tpl_vars['skinPathList']->value['root']);
$_smarty_tpl->_assignInScope('headerPath', $_smarty_tpl->tpl_vars['skinPathList']->value['header']);
$_smarty_tpl->_assignInScope('footerPath', $_smarty_tpl->tpl_vars['skinPathList']->value['footer']);
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['headerPath']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"SUX관리자 팝업 추가 - StreamUX"), 0, true);
?>

<div class="articles ui-edgebox">
	<div class="add">
		<div class="tt">
			<div class="imgbox">
				<h1>팝업생성</h1>
			</div>
		</div>
		<div class="box">
			<form action="<?php echo $_smarty_tpl->tpl_vars['rootPath']->value;?>
popup-admin/add" name="info_add" method="post">
			<input type="hidden" name="_method" value="insert">
			<dl>
				<dt>팝업생성 옵션설정</dt>
				<dd>
					<img src="<?php echo $_smarty_tpl->tpl_vars['rootPath']->value;?>
modules/admin/tpl/images/icon_notice.gif" width="30" height="13" align="absmiddle" class="icon-notice">
					<span class="text-notice">발강색(별표)으로 표신된 부분은 반드시 입력해주세요.</span>			
				</dd>
			</dl>
			<table summary="팝업 정보를 입력해 생성해주세요.">
				<caption class="blind">팝업 정보 입력</caption>
				<tbody>
					<tr>
						<td><label for="popup_name">*팝업이름</label></td>
						<td>
							<input type="text" id="popup_name" name="popup_name" size="20" maxlength="20" value="">
						</td>
					</tr>
					<tr>
						<td><label for="popup_title">제목</label></td>
						<td>
							<input type="text" name="popup_title" size="30" maxlength="30" value="">
						</td>
					</tr>
					<tr>
						<td>노출</td>
						<td>
							<select name="choice">
								<option value="n">n</option>
								<option value="y">y</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>시간</td>
						<td>
							<input type="text" id="period_year" name="time_year" size="4" maxlength="4" value="2017">
							<span><label for="period_year">년</label></span>
							<input type="text" id="period_month" name="time_month" size="2" maxlength="2" value="12">
							<span><label for="period_month">월</label></span>
							<input type="text" id="period_day" name="time_day" size="2" maxlength="2" value="18">
							<span><label for="period_day">일</label></span>
							<input type="text" id="period_hours" name="time_hours" size="2" maxlength="2" value="13">
							<span><label for="period_hours">시</label></span>
							<input type="text" id="period_minutes" name="time_minutes" size="2" maxlength="2" value="30">
							<span><label for="period_minutes">분</label></span>
							<input type="text" id="period_seconds" name="time_seconds" size="2" maxlength="2" value="00">
							<span><label for="period_seconds">초 까지</label></span>
							<span>※ 팝업창 닫을 시간을 정확하게 설정하세요.</span>
						</td>
					</tr>
					<tr>
						<td>스킨</td>
						<td>
							<select name="skin" id="skinList">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['documentData']->value['skin_list'], 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
								<option><?php echo $_smarty_tpl->tpl_vars['item']->value['file_name'];?>
</option>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

							</select>
						</td>
					</tr>
					<tr>
						<td>팝업크기</td>
						<td>
							<label for="popup_width">넓이</label>
							<input type="text" id="popup_width" name="popup_width" size="4" maxlength="3" value="100">
							<label for="popup_height">높이</label>
							<input type="text" id="popup_height" name="popup_height" size="4" maxlength="3" value="300">
						</td>
					</tr>
					<tr>
						<td>팝업위치</td>
						<td>
							<label for="popup_top">상단</label>
							<input type="text" id="popup_top" name="popup_top" size="4" maxlength="3" value="0">
							<label for="popup_left">좌측</label>
							<input type="text" id="popup_left" name="popup_left" size="4" maxlength="3" value="0">
							<span>※ 모니터 기준</span>
						</td>
					</tr>		
					<tr>
						<td>내용여백</td>
						<td>
							<label for="skin_top">상단</label>
							<input type="text" id="skin_top" name="skin_top" size="4" maxlength="3" value="50">
							<label for="skin_left">좌측</label>
							<input type="text" id="skin_left" name="skin_left" size="4" maxlength="3" value="25">
							<label for="skin_right">우측</label>
							<input type="text" id="skin_right" name="skin_right" size="4" maxlength="3" value="25">
						</td>
					</tr>						
					<tr>
						<td><label for="textarea_contents">수정내용</label></td>
						<td>
							<textarea id="textarea_contents" name="contents" cols="25" rows="6"></textarea>
							<span>※ 팝업에 들어갈 내용을 입력해주세요.</span>
						</td>
					</tr>
				</tbody>
			</table>
			
			<input type="submit" name="submit" size="10" value="확 인">
			<input type="button" name="cancel" size="10" value="취 소">
			</form>
		</div>
	</div>
</div>
<?php echo '<script'; ?>
 type="jquery-templete" id="skinList_tmpl">
	<option>${file_name}</option>
<?php echo '</script'; ?>
>
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['footerPath']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}