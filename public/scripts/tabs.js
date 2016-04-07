$(function() {
    function makeTabs(contId) {
        var tabContainers = $('#' + contId + ' div.tabs > div');
        tabContainers.hide().filter(':first').show();
        $('#' + contId + ' div.tabs ul.tabs-ul a').click(function() {
            tabContainers.hide();
            tabContainers.filter(this.hash).show();
            $('#' + contId + ' div.tabs ul.tabs-ul a').removeClass('selected');
            $(this).addClass('selected');
            return false
        }).filter(':first').click()
    }
    makeTabs('tabs-1');
    makeTabs('tabs-2');
    makeTabs('tabs-3');
    makeTabs('tabs-4');
    makeTabs('tabs-5');
});