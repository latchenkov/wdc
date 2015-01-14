<?php /* Smarty version 2.6.28, created on 2015-01-14 17:24:34
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'index.tpl', 2, false),array('modifier', 'replace', 'index.tpl', 31, false),array('modifier', 'date_format', 'index.tpl', 108, false),array('modifier', 'string_format', 'index.tpl', 108, false),array('function', 'html_radios', 'index.tpl', 8, false),array('function', 'html_options', 'index.tpl', 50, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form  method="post" action="<?php echo ((is_array($_tmp="?edit=".($this->_tpl_vars['id']))) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" >
    <table>
	<tr>
            <td>
            </td>
            <td>
                <?php echo smarty_function_html_radios(array('name' => 'private','options' => $this->_tpl_vars['radio_id'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['private'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'separator' => "&nbsp;&nbsp;"), $this);?>

            </td>
	</tr>
	<tr>
            <td>
                <b>Ваше имя</b>
            </td>    
            <td>
                <input type="text" maxlength="40" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['seller_name'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="seller_name" required >
            </td>
	</tr>
	<tr>
            <td>
                Электронная почта
            </td>
            <td>
                <input type="email" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['email'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="email" required>
            </td>
        </tr>
	<tr>
            <td>
            </td>
            <td>
                <input type="checkbox" <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['allow_mails'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')))) ? $this->_run_mod_handler('replace', true, $_tmp, 1, 'checked=""') : smarty_modifier_replace($_tmp, 1, 'checked=""')))) ? $this->_run_mod_handler('replace', true, $_tmp, 0, '') : smarty_modifier_replace($_tmp, 0, '')); ?>
 value="1" name="allow_mails" >&nbsp;&nbsp;Я не хочу получать вопросы по объявлению по e-mail
            </td>
    	</tr>
	<tr>
            <td>
                Номер телефона
            </td>
            <td>
                <input type="tel"  value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['phone'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="phone" required>
            </td>
     	</tr>
	<tr>
            <td>
                Город
            </td>
            <td>
		<select title="Выберите Ваш город" name="location_id" required  > 
                    <option value="">-- Выберите город --</option>
                    <option disabled="disabled">-- Города --</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['location'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['location_id'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['location_sel']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['location_sel']))), $this);?>

	        </select>
            </td>
      	</tr>
        <tr>
            <td>
                Категория
            </td>
            <td>
		<select title="Выберите категорию объявления" name="category_id"  required>
                    <option value="">-- Выберите категорию --</option>
                        <?php $_from = $this->_tpl_vars['label']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                            <optgroup label="<?php echo $this->_tpl_vars['item']; ?>
">
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['category'][$this->_tpl_vars['key']],'selected' => ((is_array($_tmp=@$this->_tpl_vars['category_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, ''))), $this);?>

                            </optgroup>
                        <?php endforeach; endif; unset($_from); ?>    
                </select>
            </td>	
	</tr>
	<tr>
            <td>
                Название объявления
            </td>
            <td>
                <input type="text" maxlength="50"  value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" name="title" required>
            </td>
    	</tr>
	<tr>
            <td>
                Описание объявления
            </td>
            <td>
                <textarea maxlength="3000"  name="description" required><?php echo ((is_array($_tmp=@$this->_tpl_vars['description'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
</textarea>
            </td>
      	</tr>
	<tr>
            <td>
                Цена
            </td>
            <td>
                <input type="text" maxlength="9"  value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['price'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" name="price" >&nbsp;руб.
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <input type="submit" value="<?php if (! isset ( $this->_tpl_vars['id'] )): ?>Подать объявление<?php else: ?>Сохранить изменения<?php endif; ?>" name="main_form_submit" >
            </td>
	</tr>
    </table>
</form>

<hr/>

<?php if (isset ( $this->_tpl_vars['showAd'] )): ?>
    <?php $_from = $this->_tpl_vars['showAd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ad']):
?>
	<p><?php echo ((is_array($_tmp=$this->_tpl_vars['ad']->getDate())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d:%m:%Y %T") : smarty_modifier_date_format($_tmp, "%d:%m:%Y %T")); ?>
 | <a href="?show=<?php echo $this->_tpl_vars['ad']->getId(); ?>
"><?php echo $this->_tpl_vars['ad']->getTitle(); ?>
</a> | <?php echo ((is_array($_tmp=$this->_tpl_vars['ad']->getPrice())) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
 руб. | <?php echo $this->_tpl_vars['ad']->getSeller_name(); ?>
 | <a href="?delete=<?php echo $this->_tpl_vars['ad']->getId(); ?>
">Удалить</a></p>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>