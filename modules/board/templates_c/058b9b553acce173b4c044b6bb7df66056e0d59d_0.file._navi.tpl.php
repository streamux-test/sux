<?php
/* Smarty version 3.1.30, created on 2016-09-09 09:54:42
  from "/Applications/MAMP/htdocs/sux/modules/board/skin/default/_navi.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d26ac29d0ab6_08918778',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '058b9b553acce173b4c044b6bb7df66056e0d59d' => 
    array (
      0 => '/Applications/MAMP/htdocs/sux/modules/board/skin/default/_navi.tpl',
      1 => 1473407623,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d26ac29d0ab6_08918778 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['naviData']->value['okpage'] != 'yes') {?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['naviData']->value['PHP_SELF'];?>
?board=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['board'];?>
&board_grg=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['board_grg'];?>
&passover=<?php echo $_smarty_tpl->tpl_vars['naviData']->value['prevpassover'];?>
&page=<?php echo $_smarty_tpl->tpl_vars['naviData']->value['befopage'];?>
&find=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['find'];?>
&search=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['search'];?>
&action=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['action'];?>
">이전</a>	
<?php }?>

<?php
$__section_page_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_page']) ? $_smarty_tpl->tpl_vars['__smarty_section_page'] : false;
$__section_page_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['naviData']->value['nowpageend']) ? count($_loop) : max(0, (int) $_loop));
$__section_page_0_start = (int)@$_smarty_tpl->tpl_vars['naviData']->value['nowpage'] < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['naviData']->value['nowpage'] + $__section_page_0_loop) : min((int)@$_smarty_tpl->tpl_vars['naviData']->value['nowpage'], $__section_page_0_loop);
$__section_page_0_total = min(($__section_page_0_loop - $__section_page_0_start), $__section_page_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_page'] = new Smarty_Variable(array());
if ($__section_page_0_total != 0) {
for ($__section_page_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_page']->value['index'] = $__section_page_0_start; $__section_page_0_iteration <= $__section_page_0_total; $__section_page_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_page']->value['index']++){
?>
	<?php $_smarty_tpl->_assignInScope('index', (isset($_smarty_tpl->tpl_vars['__smarty_section_page']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_page']->value['index'] : null));
?>
	<?php $_smarty_tpl->_assignInScope('nowpassover', $_smarty_tpl->tpl_vars['naviData']->value['limit']*($_smarty_tpl->tpl_vars['index']->value-1));
?>

	<?php if ($_smarty_tpl->tpl_vars['naviData']->value['total'] > $_smarty_tpl->tpl_vars['nowpassover']->value) {?>
		<?php if ($_smarty_tpl->tpl_vars['naviData']->value['passover'] != $_smarty_tpl->tpl_vars['nowpassover']->value) {?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['naviData']->value['PHP_SELF'];?>
?board=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['board'];?>
&board_grg=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['board_grg'];?>
&passover=<?php echo $_smarty_tpl->tpl_vars['nowpassover']->value;?>
&page=<?php echo $_smarty_tpl->tpl_vars['naviData']->value['page'];?>
&find=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['find'];?>
&search=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['search'];?>
&action=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['action'];?>
">[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
]</a>
		<?php } else { ?>
			&nbsp;<span class="color-red"><?php echo $_smarty_tpl->tpl_vars['index']->value;?>
</span>&nbsp
		<?php }?>
	<?php }
}
}
if ($__section_page_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_page'] = $__section_page_0_saved;
}
?>

<?php if ($_smarty_tpl->tpl_vars['naviData']->value['total'] >= $_smarty_tpl->tpl_vars['naviData']->value['hanpassoverpage']) {?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['naviData']->value['PHP_SELF'];?>
?board=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['board'];?>
&board_grg=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['board_grg'];?>
&passover=<?php echo $_smarty_tpl->tpl_vars['naviData']->value['newpassover'];?>
&page=<?php echo $_smarty_tpl->tpl_vars['naviData']->value['nextpage'];?>
&find=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['find'];?>
&search=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['search'];?>
&action=<?php echo $_smarty_tpl->tpl_vars['requestData']->value['action'];?>
">다음</a>
<?php }?>


<?php }
}
