<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <div id='dashboard'>
            <div id="marketing_channels">
                <table class="table">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        if (sizeof($this->model->results_per_marketingchannel) > 0)
                        {
                            foreach ($this->model->results_per_marketingchannel as $channel)
                            {
                                ?>
                                <td>
                                    <div>
                                        <h2><strong><?=$channel->marketingchannel?></strong></h2>

                                        <h2 style="color: <?= ($channel->grossprofit > 0) ? 'green' : 'red' ?>">
                                            <strong>&euro;<?= $channel->grossprofit ?></strong></h2>
                                    </div>
                                </td>
                            <?php
                            }
                        }
                        else
                        {
                            ?>
                            <td>
                                <div>
                                    <h1><strong>Geen verkoop resultaten</strong></h1>
                                    <h1><strong>Probeer een andere scope (dag, week, maand)</strong></h1>
                                </div>
                            </td>
                            <?php
                        }
                        reset($this->model->results_per_marketingchannel)
                        ?>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div id="marketing_channel_tables">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Marketing kanaal</th>
                        <th>Omzet</th>
                        <th>Vaste lasten</th>
                        <th>Klikkosten</th>
                        <th>Totale kosten</th>
                        <th>Winst</th>
                        <th>Rendement (over de omzet)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (sizeof($this->model->results_per_marketingchannel) > 0)
                    {
                        foreach ($this->model->results_per_marketingchannel as $data)
                        {
                            $ratio = round($data->revenue / $this->model->total_revenue, 2);
                            $cost = round($this->model->webshop_costs * $ratio, 2) ;
                            $totalcost = $cost + $data->costs + $data->marketingchannelcost;
                            $profit = $data->revenue - $totalcost;
                            $efficiency = round($profit / $data->revenue * 100, 2);

                            ?>
                            <tr class="<?= ($efficiency > 0) ? 'success' : 'error' ?>">
                                <td><strong><a href="<?=WEBSITE_URL?>dashboard/channel/<?=$data->id?>"><?=$data->marketingchannel?></a></strong></td>
                                <td>&euro;<?=round($data->revenue, 2)?></td>
                                <td>&euro;<?=round($cost, 2)?></td>
                                <td>&euro;<?=round($data->marketingchannelcost, 2)?></td>
                                <td>&euro;<?=round($totalcost, 2)?></td>
                                <td>&euro;<?=round($profit, 2)?></td>
                                <td><?=$efficiency?>%</td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php $this->googlechart_controller->pie($this->webshop_id);  ?>
        </div>
    </div>
</section>