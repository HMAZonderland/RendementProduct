<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <div id='dashboard'>
            <div id="marketing_channel_tables">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Verkoopprijs</th>
                        <th>Inkoopprijs</th>
                        <th>Verzendkosten</th>
                        <th>BTW</th>
                        <th>Aantal</th>
                        <th>Omzet</th>
                        <th>Totale kosten</th>
                        <th>Bruto winst</th>
                        <th>Vaste lasten</th>
                        <th>Totale kosten</th>
                        <th>Winst</th>
                        <th>Rendement</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if (sizeof($this->model->products_per_marketingchannel) > 0)
                    {
                        foreach ($this->model->products_per_marketingchannel as $data)
                        {
                            $cost = (($this->model->webshop_costs * $this->model->ratio) / $this->model->sold_products) * $data->quantity;
                            $costs = $cost + $data->costs;
                            $profit = $data->grossprofit - $cost - $data->cost;
                            $efficiency = round($profit / $data->revenue * 100, 2);

                            ?>
                            <tr class="<?= ($profit > 0) ? 'success' : 'error' ?>">
                                <td style='width:30%'><strong><?=$data->name?></strong></td>
                                <td>&euro;<?=round($data->price, 2)?></td>
                                <td>&euro;<?=round($data->base_cost, 2)?></td>
                                <td>&euro;<?=round($data->shipping_costs, 2)?></td>
                                <td>&euro;<?=round($data->tax_amount, 2)?></td>
                                <td><?=$data->quantity?></td>
                                <td>&euro;<?=round($data->revenue, 2)?></td>
                                <td>&euro;<?=round($data->costs, 2)?></td>
                                <td>&euro;<?=round($data->grossprofit, 2)?></td>
                                <td>&euro;<?=round($cost, 2)?></td>
                                <td>&euro;<?=round($costs,2)?></td>
                                <td>&euro;<?=round($profit,2)?></td>
                                <td><?=$efficiency?>%</td>
                            </tr>
                        <?php
                        }
                    }
                    else
                    {
                        ?>
                        <td colspan="13">Geen producten verkocht, probeer een andere scope (dag, week, maand)</td>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <a href="<?=WEBSITE_URL?>index.php">Terug naar de marketingkanalen</a>
            </div>
        </div>
    </div>
</section>