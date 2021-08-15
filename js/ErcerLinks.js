function isUrl(str) {
    var v = new RegExp('^(?!mailto:)(?:(?:http|https|ftp)://|//)(?:\\S+(?::\\S*)?@)?(?:(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[0-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))|localhost)(?::\\d{2,5})?(?:(/|\\?|#)[^\\s]*)?$', 'i');
    return v.test(str);
}


function Friends_Link() {
    var png = $('input[name="host_png"]').val();
    var pngif = isUrl(png);
    var url = $('input[name="host_url"]').val();
    var urlif = isUrl(url);
    var name = $('input[name="host_name"]').val();
    var msg = $('input[name="host_msg"]').val();
    if (name == '') {
        $.message({title: '提交失败：',message: '站点名称未填写哦！',type: 'error'});
    } else if (url == '') {
        $.message({title: '提交失败：',message: '站点链接未填写哦！',type: 'error'});
    } else if (png == '') {
        $.message({title: '提交失败：',message: '站点图标未填写哦！',type: 'error'});
    } else if (msg == '') {
        $.message({title: '提交失败：',message: '站点描述未填写哦！',type: 'error'});
    } else if (pngif || urlif) {
        $.post("/link_add",
            $('#F-link').serialize(), function(data) {
                if (data == 'postok') {
                    $.message({
                        title: '提交成功，',
                        message: "等待站长通过哟！",
                        type: 'success'
                    });
                } else {

                    $.message({
                        title: '提交失败，',
                        message: data,
                        type: 'error'
                    });
                }
            });


    } else {

        $.message({
            title: '图标或站点地址错误',
            message: "请带上http或者https呐！",
            type: 'warning'
        });
    }

}


function Friends_Link_Page() {
    var png = $('input[name="host_png_page"]').val();
    var pngif = isUrl(png);
    var url = $('input[name="host_url_page"]').val();
    var urlif = isUrl(url);
    var name = $('input[name="host_name_page"]').val();
    var msg = $('input[name="host_msg_page"]').val();
    if (name == '') {
        $.message({title: '提交失败：',message: name,type: 'error'});
    } else if (url == '') {
        $.message({title: '提交失败：',message: '站点链接未填写哦！',type: 'error'});
    } else if (png == '') {
        $.message({title: '提交失败：',message: '站点图标未填写哦！',type: 'error'});
    } else if (msg == '') {
        $.message({title: '提交失败：',message: '站点描述未填写哦！',type: 'error'});
    } else if (pngif || urlif) {
        $.post("/link_add",
            $('#F-link_Page').serialize(), function(data) {
                if (data == 'postok') {
                    $.message({
                        title: '提交成功，',
                        message: "等待站长通过哟！",
                        type: 'success'
                    });
                    console.log($('#F-link_Page').serialize())
                } else {

                    $.message({
                        title: '提交失败，',
                        message: data,
                        type: 'error'
                    });
                }
            });


    } else {

        $.message({
            title: '图标或站点地址错误',
            message: "请带上http或者https呐！",
            type: 'warning'
        });
    }

}



$(document).ready(function() {
    $(".nav.navbar-nav.hidden-sm").append('<li class="dropdown pos-stc"><a id="statistic_pane" data-status="false" href="#" data-toggle="dropdown" class="dropdown-toggle feathericons dropdown-toggle" aria-expanded="false"><i data-feather="link"></i> <span class="caret"></span></a><div class="dropdown-menu wrapper w-full bg-white" style="max-height: 400px;overflow-y: scroll;padding: 30px;"><div class="row"><div id="addhere"></div><div class="row"><div class="col-sm-12"><div class="panel-body"><h4 style="text-align:center">申请友链🌸</h4><form class="form-inline" style="text-align: center;" role="form" id="F-link"><div class="form-group"><label class="sr-only" for="host_name">站点名称</label> <input type="text" name="host_name" class="form-control" id="host_name" placeholder="站点名称"></div><div class="form-group"><label class="sr-only" for="host_url">站点链接</label> <input type="text" name="host_url" class="form-control" id="host_url" placeholder="站点链接"></div><div class="form-group"><label class="sr-only" for="host_png">站点图标</label> <input type="text" name="host_png" class="form-control" id="host_png" placeholder="站点图标"></div><div class="form-group"><label class="sr-only" for="host_msg">站点描述</label> <input type="text" name="host_msg" class="form-control" id="host_msg" placeholder="站点描述（不用太长）"></div><div class="form-group"><a class="btn btn-danger" onclick="Friends_Link()">申请</a></div><br><div class="checkbox m-l m-r-xs" style="margin-top:5px"><label class="i-checks"><input type="checkbox" name="host_yes" value="yes"><i></i>已添加本站为友链</label></div><br></form></div></div></div></div></div></li>');
});