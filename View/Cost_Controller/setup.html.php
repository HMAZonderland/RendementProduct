<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <h1>Kosten opgaaf voor <?=$this->model->webshop_name?></h1>
        <form action="<?=WEBSITE_URL?>dashboard/cost/setup" name="setup_form" method="post">
            <input type="hidden" name="webshop_id" value="<?=$this->model->webshop_id?>" />
            <table>
                <tr>
                    <td><h2>1. Voer hier de vaste lasten per maand in.</h2></td>
                </tr>
            </table>
            <br />
            <div style="width: 75%;">
                <table width="70%">
                    <tr>
                        <td style="width: 50%">Vaste lasten per maand</td>
                        <td style="width: 50%"><input type="number" name="cost" required placeholder="bijv. &euro;8000" /></td>
                    </tr>
                </table>
            </div>

            <p><hr /></p>

            <table>
                <tr>
                    <td><h2>2. Geef een schatting van de verwachte kosten (per kanaal).</h2></td>
                </tr>
                <tr>
                    <td>De kosten van afgelopen maand of een verwachting van aankomende maand.</td>
                </tr>
            </table>
            <br />
            <div style="width: 75%;">
                <table width="70%">
                <?php
                    foreach ($this->model->marketing_channels as $channel)
                    {
                        if ($channel != '(direct)')
                        {
                            ?>
                            <tr>
                                <td style="width: 50%"><?=$channel?></td>
                                <td style="width: 50%"><input type="number" name="<?=$channel?>_cost" required placeholder="bijv. &euro;250" /></td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </table>
            </div>
            <input type="submit" name="submit" value="Opslaan!" />
        </form>
    </div>
</section>