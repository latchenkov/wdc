<?php /* Smarty version 2.6.28, created on 2015-01-06 12:39:02
         compiled from install.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'install.tpl', 20, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form  method="post" >
    <p>Server name:</br>
        <input type="text" maxlength="40" value="" name="db_host" required  >
    </p>
    <p>User name:</br>
        <input type="text" maxlength="40" value="" name="db_user" required >
    </p>
    <p>Password:</br>
        <input type="text" maxlength="40" value="" name="db_password" >
    </p>
    <p>Database:</br>
        <input type="text" maxlength="40" value="" name="db_name" required >
    </p>
    <p>
        <input type="submit" value="Install" name="submit" >        
    </p>
</form>
<?php if (( ((is_array($_tmp=@$this->_tpl_vars['success'])) ? $this->_run_mod_handler('default', true, $_tmp, false) : smarty_modifier_default($_tmp, false)) )): ?>
    	<p>База данных успешно восстановлена из дампа.</br>
            <a href="index.php">Перейти на главную страницу сайта.</a></p>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>