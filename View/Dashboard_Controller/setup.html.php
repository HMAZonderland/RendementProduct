<script type="text/javascript">
    $(document).ready(function(){

        $("a.google_analytics_profile").click(function(event) {

            event.preventDefault();

            var profile = $(this).data('profile');
            var property = $(this).data('property');
            var account = $(this).data('account');

            console.log(profile);
            console.log(property);
            console.log(account);

            $("div#magento_form").slideDown('slow', function(){});
            $("#google_analytics_selector").slideUp('slow', function() {
                $("a.show_ga").show();
                $("a.hide_magento").show();
            });

            $("a.google_analytics_profile").each(function() {
                $(this).css("font-weight","normal");
                $(this).css("color","#00B2CC");
            });

            $(this).css("font-weight","bold");
            $(this).css("color","red");
        });

        $("a.show_ga").click(function(event) {
           event.preventDefault();
           $(this).hide();
           $("div#magento_form").slideUp('slow', function() {});
           $("#google_analytics_selector").slideDown('slow', function() {
               $("a.hide_ga").show();
               $("a.hide_magento").hide();
               $("a.show_magento").hide();
           });
        });

        $("a.hide_ga").click(function(event) {
            event.preventDefault();
            $(this).hide();
            $("div#magento_form").slideDown('slow', function() {});
            $("#google_analytics_selector").slideUp('slow', function() {
                $("a.show_ga").show();
                $("a.hide_magento").hide();
            });
        });
    });
</script>
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
                    <td><a href="" class="hide_ga">Toon Magento formulier..</a></td>
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
            <form>
            <table width="100%">
                <tr>
                    <td>Internet adres </td>
                    <td><input name="magento_host" required="" type="text" placeholder="bijv. webwinkel.nl" /></td>
                </tr>
                <tr>
                    <td>API gebruikersnaam </td>
                    <td><input name="magento_user" required="" type="text" placeholder="bijv. api_user" /></td>
                </tr>
                <tr>
                    <td>API gebruiker key </td>
                    <td><input name="magento_key" required="" type="text" placeholder="bijv. uliehqf78feyuiehgfe78ofy" /></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</section>