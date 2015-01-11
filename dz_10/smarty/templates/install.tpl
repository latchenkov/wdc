{include file='header.tpl'}
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
{* Вывод уведомления об успехе  *}
{if ($success|default:false)}
    	<p>База данных успешно восстановлена из дампа.</br>
            <a href="index.php">Перейти на главную страницу сайта.</a></p>
{/if}

{include file='footer.tpl'}