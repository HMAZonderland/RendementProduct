<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <div class="col6">
            <table>
                <tr>
                    <td><h1>Webshop instellingen wijzigen</h1></td>
                </tr>
                <?php
                foreach ($this->model->webshops as $webshop)
                {
                    ?>
                    <tr>
                        <td><a href="<?=WEBSITE_URL . 'dashboard/settings/' . $webshop->id?>"><?=$webshop->name?></a></td>
                    </tr>
                    <?php
                }
                reset($this->model->webshops);
                ?>
            </table>
        </div>
        <div class="col6 last">
            <table>
                <tr>
                    <td><h1>Markting kanaal kosten wijzigen</h1></td>
                </tr>
                <?php
                foreach ($this->model->webshops as $webshop)
                {
                ?>
                    <tr>
                        <td><a href="<?=WEBSITE_URL . 'dashboard/settings/' . $webshop->id?>"><?=$webshop->name?></a></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</section>