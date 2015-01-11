{include file='header.tpl'}
<form  method="post" action="{"?edit=`$editAd.id`"|default:''}" >
    <table>
	<tr>
            <td>
            </td>
            <td>
                {html_radios name="private" options=$radio_id selected=$editAd.private|default:0 separator="&nbsp;&nbsp;"}
            </td>
	</tr>
	<tr>
            <td>
                <b>Ваше имя</b>
            </td>    
            <td>
                <input type="text" maxlength="40" value="{$editAd.seller_name|default:''}" name="seller_name" required >
            </td>
	</tr>
	<tr>
            <td>
                Электронная почта
            </td>
            <td>
                <input type="email" value="{$editAd.email|default:''}" name="email" required>
            </td>
        </tr>
	<tr>
            <td>
            </td>
            <td>
                <input type="checkbox" {$editAd.allow_mails|default:''|replace:1:'checked=""'} value="1" name="allow_mails" >&nbsp;&nbsp;Я не хочу получать вопросы по объявлению по e-mail
            </td>
    	</tr>
	<tr>
            <td>
                Номер телефона
            </td>
            <td>
                <input type="tel"  value="{$editAd.phone|default:''}" name="phone" required>
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
                    {html_options options=$location_id selected=$editAd.location_id|default:$location_sel}
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
                        {foreach from=$label_id item=label key=key}
                            <optgroup label="{$label}">
                                {html_options options=$category_id.$key selected=$editAd.category_id|default:''}
                            </optgroup>
                        {/foreach}    
                </select>
            </td>	
	</tr>
	<tr>
            <td>
                Название объявления
            </td>
            <td>
                <input type="text" maxlength="50"  value="{$editAd.title|default:''}" name="title" required>
            </td>
    	</tr>
	<tr>
            <td>
                Описание объявления
            </td>
            <td>
                <textarea maxlength="3000"  name="description" required>{$editAd.description|default:''}</textarea>
            </td>
      	</tr>
	<tr>
            <td>
                Цена
            </td>
            <td>
                <input type="text" maxlength="9"  value="{$editAd.price|default:0}" name="price" >&nbsp;руб.
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <input type="submit" value="{if !isset($editAd)}Подать объявление{else}Сохранить изменения{/if}" name="main_form_submit" >
            </td>
	</tr>
    </table>
</form>

<hr/>

{* Вывод списка объявлений  *}
{if isset($showAd)}
    {foreach from=$showAd item=ad}
	<p>{$ad.date|date_format:"%d:%m:%Y %T"} | <a href="?show={$ad.id}">{$ad.title}</a> | {$ad.price|string_format:"%.2f"} руб. | {$ad.seller_name} | <a href="?delete={$ad.id}">Удалить</a></p>
    {/foreach}
{/if}

{include file='footer.tpl'}