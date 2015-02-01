
{include file='header.tpl'}

<div class="container" style="width:900px; padding: 30px;" id="top">
    
{include file='table.tpl'}

<hr/>

<form class="form-horizontal" id="form" method="post" >
    {if isset($id)}<input type="hidden" name="id" value="{$id}">{/if}
    {if isset($date)}<input type="hidden" name="date" value="{$date}">{/if}
	<div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <div class="radio">
                    <label>
                        {html_radios name="type" options=$radio_id selected=$type|default:0 separator="</br>"}
                    </label>
                </div>
            </div>
        </div>            
        <div class="form-group">
            <label for="inputSeller_name" class="col-sm-3 control-label">Ваше имя</label>
                <div class="col-sm-6">
                    <input type="text" name="seller_name" class="form-control" id="inputSeller_name" placeholder="Ваше имя" maxlength="40" value="{$seller_name|default:''}"  required >
                </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-3 control-label">Электронная почта</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Ваш e-mail" value="{$email|default:''}"  required >
                </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" {$allow_mails|default:''|replace:1:'checked=""'|replace:0:''} value="1" name="allow_mails" ><small>&nbsp;&nbsp;Я не хочу получать вопросы по объявлению по e-mail</small>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPhone" class="col-sm-3 control-label">Номер телефона</label>
                <div class="col-sm-6">
                    <input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="Ваш телефон" value="{$phone|default:''}"  required >
                </div>
        </div>
        <div class="form-group">
            <label for="inputLocation" class="col-sm-3 control-label">Город</label>
                <div class="col-sm-6">
                   <select class="form-control" title="Выберите Ваш город" name="location_id" required  > 
                        <option value="">-- Выберите город --</option>
                        <option disabled="disabled">-- Города --</option>
                            {html_options options=$location selected=$location_id|default:$location_sel}
                    </select> 
                </div>
        </div>
        <div class="form-group">
            <label for="inputCategory" class="col-sm-3 control-label">Категория</label>
                <div class="col-sm-6">
                   <select class="form-control" title="Выберите категорию объявления" name="category_id"  required>
                        <option value="">-- Выберите категорию --</option>
                            {foreach from=$label item=item key=key}
                                <optgroup label="{$item}">
                                    {html_options options=$category.$key selected=$category_id|default:''}
                                </optgroup>
                            {/foreach}    
                    </select> 
                </div>
        </div>
        <div class="form-group">
            <label for="inputTitle" class="col-sm-3 control-label">Название объявления</label>
                <div class="col-sm-6">
                    <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Название объявления" value="{$title|default:''}"  required >
                </div>
        </div>
        <div class="form-group">
            <label for="inputDesc" class="col-sm-3 control-label">Описание объявления</label>
                <div class="col-sm-6">
                    <textarea name="description" class="form-control" rows="5" id="inputDesc" placeholder="Текст объявления" required>{$description|default:''}</textarea>
                </div>
        </div>
        <div class="form-group">
            <label for="inputPrice" class="col-sm-3 control-label">Цена</label>
                <div class="col-sm-6">
                    <div class="input-group">
                    <input type="text" name="price" class="form-control" id="inputPrice" placeholder="Ведите цену" value="{$price|default:0}" >
                        <div class="input-group-addon">руб.</div>
                    </div>
                </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-primary">{if !isset($id)}Подать объявление{else}Сохранить изменения{/if}</button>
            </div>
        </div>
</form>
    </div>
</div>

{include file='footer.tpl'}