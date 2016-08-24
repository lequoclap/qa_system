var News = {};
News.baseUrl = '/news/';

News.getNewDetail = function($newId) {

    var url = News.baseUrl + $newId;
    $.getJSON(url, function (data) {
        riot.tag('new_detail',
            $("#new_detail").html(),
            function (opts) {
                this.newDetail = data;
            });
        riot.mount('new_detail');
    }).error(function (jpXHR, status, errors) {
        console.log("ERROR", status);
    });
};
