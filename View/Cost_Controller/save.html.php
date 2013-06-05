<script>
    function save() {
        $.get('<?=WEBSITE_URL?>cron/forwebshop/<?=$_POST['webshop_id']?>',
            function(data) {
                if (data) {
                    $('#loading_gif').hide();
                    $('#complete').show();
                } else {
                    alert('Het ophalen van de eerste data is NIET gelukt. Neem contact op met esser-emmerik.');
                }
            }
        );
    }
</script>
<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        De installatie is bijna voltooid, we gaan nu de eerste data importeren. Dit kan 5 tot 10 minuten duren.
        <p style='margin:20px 50px 20px 20px;'>
            <img src="<?=IMAGE_ROOT?>essy_logo.png" alt="Laden.." id="loading_gif" onload="save();"  />
        </p>
        <div id='complete' style='display: none;'>
            Het ophalen van de eerste data is gelukt!<br />
            <a href="<?=WEBSITE_URL?>dashboard">Ga door naar het dashboard</a>
        </div>
    </div>
</section>