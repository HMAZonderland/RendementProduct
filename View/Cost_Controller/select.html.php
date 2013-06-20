<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <table>
            <tr>
                <td><h1>Selecteer een van de onderstaande webshops</h1></td>
            </tr>
            <tr>
                <td>
                    <?php
                    foreach ($this->model->webshops as $webshop)
                    {
                        echo '<h2><a href="' . WEBSITE_URL . 'dashboard/' . $webshop->id . '">' . $webshop->name . '</a></h2><br />';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</section>