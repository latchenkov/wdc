<?php /* Smarty version 2.6.28, created on 2015-01-27 11:46:50
         compiled from table.tpl */ ?>
<h2 class="sub-header" >Все объявления</h2>
    <div class="table-responsive" >
        <table class="table">
            <thead>
                <tr>
                    <th>Дата публикации</th>
                    <th>Название</th>
                    <th></th>
                    <th>Цена</th>
                    <th>Имя автора</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                   <?php echo $this->_tpl_vars['ads_rows']; ?>

            </tbody>
        </table>
    </div>