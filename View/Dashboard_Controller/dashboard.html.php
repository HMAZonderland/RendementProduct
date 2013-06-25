<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <div id='dashboard'>
            <?php
            if (sizeof($this->model->results_per_marketingchannel) > 0) {
                $this->googlechart_controller->pie($this->webshop_id);
            }
            ?>
            <div id="marketing_channel_tables">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Marketing kanaal</th>
                        <th>Omzet</th>
                        <th>Vaste lasten</th>
                        <th>Inkoop & BTW</th>
                        <th>Klikkosten</th>
                        <th>Totale kosten</th>
                        <th>Winst</th>
                        <th>Rendement</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (sizeof($this->model->results_per_marketingchannel) > 0)
                    {
                        foreach ($this->model->results_per_marketingchannel as $data)
                        {
                            $ratio = $data->revenue / $this->model->total_revenue;
                            $cost = $this->model->webshop_costs * $ratio;
                            $totalcost = $cost + $data->costs + $data->marketingchannelcost;
                            $profit = $data->revenue - $totalcost;
                            $efficiency = round($profit / $data->revenue * 100, 2);

                            ?>
                            <tr class="<?= ($efficiency > 0) ? 'success' : 'error' ?>">
                                <td><strong><a href="<?=WEBSITE_URL?>dashboard/channel/<?=$this->webshop_id?>/<?=$data->id?>"><?=$data->marketingchannel?></a></strong></td>
                                <td>&euro;<?=round($data->revenue, 2)?></td>
                                <td>&euro;<?=round($cost, 2)?></td>
                                <td>&euro;<?=round($data->costs,2)?></td>
                                <td>&euro;<?=round($data->marketingchannelcost, 2)?></td>
                                <td>&euro;<?=round($totalcost, 2)?></td>
                                <td>&euro;<?=round($profit, 2)?></td>
                                <td><?=$efficiency?>%</td>
                            </tr>
                        <?php
                        }
                    }
                    else
                    {
                     ?>
                     <tr>
                         <td colspan="7">Geen data</td>
                     </tr>
                     <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>