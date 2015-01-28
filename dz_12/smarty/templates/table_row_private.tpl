<tr>
    <td>{$ad->getDate()|date_format:"%d:%m:%Y %T"}</td>
    <td>{$ad->getTitle()}</td>
    <td><a class="btn btn-info btn-xs " title="Показать объявление" href="?show={$ad->getId()}#form"><strong>?</strong></a></td>
    <td>{$ad->getPrice()|string_format:"%.2f"} руб.</td>
    <td>{$ad->getSeller_name()}</td>
    <td align="center"><a class="btn btn-danger btn-xs " title="Удалить объявление" href="?delete={$ad->getId()}"><strong>X</strong></a></td>
</tr>
               