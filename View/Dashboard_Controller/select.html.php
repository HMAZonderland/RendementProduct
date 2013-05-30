<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <table>
            <tr>
                <th>Selecteer een van de webshops</th>
            </tr>
            <tr>
                <td>
                    <?php
                    foreach ($this->model->webshops as $webshop)
                    {
                        echo '<a href="' . WEBSITE_URL . 'dashboard/' . $webshop->id . '">' . $webshop->name . '</a><br />';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</section>