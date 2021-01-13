/** initPio */
var home_Path = $("#live2d").attr("homeurl");
var re = /x/;
var timeout = 0;
var hiden = false;
console.log('%c Live2D 1.0 %c https://www.onesnowwarrior.cn ', 'color: #fadfa3; background: #23b7e5; padding:5px 0;', 'background: #1c2b36; padding:5px 0;');
function showLive2D() {
    if(cdn!==""){
        loadlive2d("live2d", "/usr/plugins/Live2D/model/getmodel.php?cdn="+encodeURIComponent(cdn))
    }else{
        loadlive2d("live2d", "/usr/plugins/Live2D/model/getmodel.php")
    }
}
function renderTip(template, context) {
    var tokenReg = /(\\)?\{([^\{\}\\]+)(\\)?\}/g;
    return template.replace(tokenReg,
    function(word, slash1, token, slash2) {
        if (slash1 || slash2) {
            return word.replace('\\', '')
        }
        var variables = token.replace(/\s/g, '').split('.');
        var currentObject = context;
        var i, length, variable;
        for (i = 0, length = variables.length; i < length; ++i) {
            variable = variables[i];
            currentObject = currentObject[variable];
            if (currentObject === undefined || currentObject === null) return ''
        }
        return currentObject
    })
}
function initTips() {
    if (dMobile) return;
    var text;
    if (document.referrer !== '') {
        var referrer = document.createElement('a');
        referrer.href = document.referrer;
        text = '嗨！来自 <span style="color:#0099cc;">' + referrer.hostname + '</span> 的朋友！';
        var domain = referrer.hostname.split('.')[1];
        if (domain == 'baidu') {
            text = '嗨！ 来自 百度搜索 的朋友！<br>欢迎访问<span style="color:#0099cc;">「 ' + document.title.split(' - ')[0] + ' 」</span>'
        } else if (domain == 'so') {
            text = '嗨！ 来自 360搜索 的朋友！<br>欢迎访问<span style="color:#0099cc;">「 ' + document.title.split(' - ')[0] + ' 」</span>'
        } else if (domain == 'google') {
            text = '嗨！ 来自 谷歌搜索 的朋友！<br>欢迎访问<span style="color:#0099cc;">「 ' + document.title.split(' - ')[0] + ' 」</span>'
        }
    } else {
        if (window.location.href == `$ {
            home_Path
        }`) {
            var now = (new Date()).getHours();
            if (now > 23 || now <= 5) {
                text = '你是夜猫子呀？这么晚还不睡觉，明天起的来嘛？'
            } else if (now > 5 && now <= 7) {
                text = '早上好！一日之计在于晨，美好的一天就要开始了！'
            } else if (now > 7 && now <= 11) {
                text = '上午好！工作顺利嘛，不要久坐，多起来走动走动哦！'
            } else if (now > 11 && now <= 14) {
                text = '中午了，工作了一个上午，现在是午餐时间！'
            } else if (now > 14 && now <= 17) {
                text = '午后很容易犯困呢，今天的运动目标完成了吗？'
            } else if (now > 17 && now <= 19) {
                text = '傍晚了！窗外夕阳的景色很美丽呢，最美不过夕阳红~~'
            } else if (now > 19 && now <= 21) {
                text = '晚上好，今天过得怎么样？'
            } else if (now > 21 && now <= 23) {
                text = '已经这么晚了呀，早点休息吧，晚安~~'
            } else {
                text = '嗨~ 快来逗我玩吧！'
            }
        } else {
            text = '欢迎阅读<span style="color:#0099cc;">「 ' + document.title.split(' - ')[0] + ' 」</span>'
        }
    }
    showMessage(text, 3000)
    $.ajax({
        cache: true,
        url: "/usr/plugins/Live2D/message.json?v=" + String(Math.random() * 100),
        dataType: "json",
        success: function(result) {
            $.each(result.mouseover,
            function(index, tips) {
                $(tips.selector).mouseover(function() {
                    var text = tips.text;
                    if (Array.isArray(tips.text)) text = tips.text[Math.floor(Math.random() * tips.text.length + 1) - 1];
                    text = text.renderTip({
                        text: $(this).text()
                    });
                    showMessage(text, 3000)
                })
            });
            $.each(result.click,
            function(index, tips) {
                $(tips.selector).click(function() {
                    var text = tips.text;
                    if (Array.isArray(tips.text)) text = tips.text[Math.floor(Math.random() * tips.text.length + 1) - 1];
                    text = text.renderTip({
                        text: $(this).text()
                    });
                    showMessage(text, 3000)
                })
            })
        }
    })
}
function showHitokoto() {
    $.getJSON('https://v1.hitokoto.cn/?encode=json',
    function(result) {
        showMessage(result.hitokoto, 2800)
    })
}
function showMessage(text, dt) {
    if (Array.isArray(text)) text = text[Math.floor(Math.random() * text.length + 1) - 1];
    $('#l2d-message').html(text);
    $("#l2d-message").css("transform", "translateX(0em)");
    timeout = dt
}

$(document).ready(function(){
    if(dMobile)  return;

    window.setInterval(function() {
        if (timeout > 0) {
            timeout = timeout - 500
        }
        if (timeout <= 0) {
            $('#l2d-message').css("transform", "translateX(-17.2em)")
        }
    },
    500)
    $("#l2d-tools-panel").show();
    showLive2D();
    initTips();
    $("#l2d-message").click(function() {
        showHitokoto()
    });
    $("#l2d-change").click(function() {
        showLive2D();
        showMessage("喜欢我的新衣服吗~", 5000)
    });
    $("#l2d-photo").click(function() {
        window.Live2D.captureName = 'pio.png';
        window.Live2D.captureFrame = true;
        showMessage("照好了没？喜欢吗～", 10000)
    });
    $("#l2d-hide").click(function() {
        if (!hiden) {
            $("#live2d").css("display", "none");
            $("#l2d-message").css("display", "none");
            $("#l2d-change").css("display", "none");
            $("#l2d-photo").css("display", "none");
            $(this).html("Show");
            hiden = true
        } else {
            $("#live2d").css("display", "block");
            $("#l2d-change").css("display", "block");
            $("#l2d-photo").css("display", "block");
            if (!dMobile) {
                $("#l2d-message").css("display", "block")
            }
            $(this).html("Hide");
            hiden = false
        }
    });
    console.log(re);
    re.toString = function() {
        showMessage('哈哈，你打开了控制台，是想要看看我的秘密吗？', 5000);
        return ''
    };
    String.prototype.renderTip = function(context) {
        return renderTip(this, context)
    };
    $(document).on('copy',
    function() {
        showMessage('你都复制了些什么呀，转载要记得加上出处哦~~', 5000)
    });
})
