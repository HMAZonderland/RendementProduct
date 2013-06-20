<script type="text/javascript" src="<?=JAVASCRIPT_ROOT?>dashboard.setup.functions.js"></script>
<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <div id="magento_form">
            <form action="<?=WEBSITE_URL?>dashboard/settings/<?= $this->model->id?>" method="post">
                <table width="100%">
                    <tr>
                        <td>Hoe heet deze webshop?</td>
                        <td><input name="webshop_name" required="" type="text" placeholder="bijv. Web Winkel" value="<?= $this->model->name ?>"/></td>
                    </tr>
                    <tr>
                        <td>Internet adres API</td>
                        <td><input name="magento_host" required="" type="text" placeholder="bijv. http://webwinkel.nl/api/soap/?wsdl" value="<?= $this->model->API_URL ?>" /></td>
                    </tr>
                    <tr>
                        <td>API gebruikersnaam </td>
                        <td><input name="magento_user" required="" type="text" placeholder="bijv. api_user" value="<?= $this->model->API_username ?>" /></td>
                    </tr>
                    <tr>
                        <td>API gebruiker key </td>
                        <td><input name="magento_key" required="" type="text" placeholder="bijv. uliehqf78feyuiehgfe78ofy" value="<?= $this->model->API_key ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="opslaan" name="settings" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</section>