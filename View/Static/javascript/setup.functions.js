/**
 * Created with JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 29-05-13
 * Time: 18:00
 * To change this template use File | Settings | File Templates.
 */
$(function(){
    $("a.google_analytics_profile").click(function(event) {

        event.preventDefault();

        $('input.profile').val($(this).data('profile'));
        $('input.property').val($(this).data('property'));
        $('input.account').val($(this).data('account'));

        /*console.log(profile);
        console.log(property);
        console.log(account);*/

        $("div#magento_form").slideDown('slow', function(){});
        $("a.show_ga").show();
        $("#google_analytics_selector").slideUp('slow', function() {});

        $("a.google_analytics_profile").each(function() {
            $(this).css("font-weight","normal");
            $(this).css("color","#00B2CC");
        });

        $(this).css("font-weight","bold");
        $(this).css("color","red");
    });
});

$(function() {
    $("a.show_ga").click(function(event) {
        event.preventDefault();
        $(this).hide();
        $("a.show_magento").show();
        $("div#magento_form").slideUp('slow', function() {});
        $("#google_analytics_selector").slideDown('slow', function() {});
    });
});

$(function() {
    $("a.show_magento").click(function(event) {
        event.preventDefault();
        $(this).hide();
        $("a.show_ga").show();
        $("div#magento_form").slideDown('slow', function(){});
        $("#google_analytics_selector").slideUp('slow', function() {});
    });
});