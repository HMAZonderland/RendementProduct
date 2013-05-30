<script type="text/javascript" src="<?=JAVASCRIPT_ROOT?>setup.functions.js"></script>
<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <table>
            <tr>
                <td><h1>1. Klik op het Google Analytics profiel die je wilt gebruiken.</h1></td>
            </tr>
            <tr>
                <td><a href="" class="show_ga" style="display:none;">Toon Google Analytics selectie scherm..</a></td>
            </tr>
        </table>
        <div id='google_analytics_selector' style="width:100%">
            <table width="100%">
                <tr>
                    <td>
                        <?php
                        $counter = 0;
                        foreach ($this->model->google_analytics_profiles as $website => $data_array)
                        {
                            if ($counter % 2 == 0) {
                                echo '<div class="col6">';
                            } else {
                                echo '<div class="col6 last">';
                            }
                            echo '<h2 class="ic">' . $website . '</h2>';
                            echo '<p>';
                            foreach ($data_array as $var) {
                                echo '<a href="" class="google_analytics_profile" data-profile="' . $var['profile'] . '" data-property="' . $var['property'] . '" data-account="' . $var['account'] . '">' . $var['name'] . '</a><br />';
                            }
                            echo '</p>';
                            echo '<p></p></div>';
                            $counter++;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><a href="" class="show_magento">Toon Magento formulier..</a></td>
                </tr>
            </table>
        </div>
        <p><hr /></p>
        <table>
            <tr>
                <td><h1>2. Voer de Magento API instellingen in.</h1></td>
            </tr>
        </table>

        <div id="magento_form" style="display:none; width:80%">
            <form action="<?=WEBSITE_URL?>dashboard/setup" name="setup_form" method="post">
                <input type="hidden" name="hid_profile" class="profile" />
                <input type="hidden" name="hid_property" class="property" />
                <input type="hidden" name="hid_account" class="account" />
            <table width="100%">
                <tr>
                    <td>Hoe heet deze webshop?</td>
                    <td><input name="webshop_name" required="" type="text" placeholder="bijv. Web Winkel" /></td>
                </tr>
                <tr>
                    <td>Internet adres API</td>
                    <td><input name="magento_host" required="" type="text" placeholder="bijv. http://webwinkel.nl/api/soap/?wsdl" /></td>
                </tr>
                <tr>
                    <td>API gebruikersnaam </td>
                    <td><input name="magento_user" required="" type="text" placeholder="bijv. api_user" /></td>
                </tr>
                <tr>
                    <td>API gebruiker key </td>
                    <td><input name="magento_key" required="" type="text" placeholder="bijv. uliehqf78feyuiehgfe78ofy" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="opslaan" /></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</section>