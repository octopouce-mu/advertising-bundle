var advs = [];
$( ".advocto" ).each(function( index ) {
    var className = $(this).attr('class');
    var classArray = className.split(" ");

    var adv = { 'az': classArray[1], 'ad': classArray[2] ? classArray[2] : null };
    advs.push(adv);
});
if(advs.length > 0) {
    $.ajax({
        type: "POST",
        url: '/advertising/statistic/add/view',
        data: { 'advs': advs },
        dataType: 'json'
    });
}
$(".advocto").on('click', function () {
    var className = $(this).attr('class');
    var classArray = className.split(" ");

    var adv = { 'az': classArray[1], 'ad': classArray[2] ? classArray[2] : null };
    $.ajax({
        type: "POST",
        url: '/advertising/statistic/add/click',
        data: { 'adv': adv },
        dataType: 'json'
    });
});