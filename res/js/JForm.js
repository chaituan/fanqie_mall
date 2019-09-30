var JForm = function ( __options ) {

    //默认参数
    var options  = {
        formId : '',        //要验证的表单的id
        filter : function( ele ) {  //需要验证的表单元素过滤
            return $(ele).attr('required') == undefined;
        },
        continueCheck : false, //是否连续验证
        showMessage : function( type, message, ele ) { //错误处理接口
            $(ele).focus();
            layer.msg(message,{icon: 2});
        },
    };

    if ( __options ) $.extend(options, __options);
    var o = {};

    o.checkboxsCache = {}; //checkbox 集合缓存
    o.checkSuccess = true; //是否验证通过
    o.cname = ''; //字段标题
    o.failText = ''; //元素验证失败时候的提示信息
    o.message = {}; //错误提示信息对象map

    //验证的验证的正则表达式
    o.regExp = {
        //用户名
        uname: /^[0-9|a-z|_]{4,20}$/i,
        //邮箱
        email: /^[a-z0-9]\w{1,18}@[a-z0-9]{1,20}(\.[a-z]{1,6}){1,3}$/i,
        //网址url
        url: /^https?:\/\/(www\.)?\w+(\.[a-z|0-9]+){1,2}/i,
        //域名
        domain: /^\w+(\.[a-z|0-9]+){1,2}$/i,
        //手机号码
        mobile: /^1[3|4|5|7|8][0-9]{9}$/,
        //电话号码
        phone: /^[0-9]{2,5}[-][0-9]{7,8}$/,
        //整数
        number: /^[0-9]+$/,
        //浮点数
        float: /^[0-9]+\.[0-9]+/,
        //中文
        cn : /^[\u4E00-\u9FA5]+$/,
        //英文
        en : /^\w+$/,
        //IP
        ip: /^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/
    };

    /**
     * 验证表单数据合法性
     * @param formid 要验证的表单id
     * @param filter 元素验证过滤器
     */
    o.checkFormData = function () {

        var form = document.getElementById(options.formId);
        var elements = form.elements;
        var needCheck = 0;  //需要验证的字段数
        var hasChecked = 0; //已经验证的字段数
        o.checkSuccess = true;  //初始化验证状态
        
        for ( var i = 0; i < elements.length; i++ ) {

            var ele = elements[i], value = ele.value.trim();
            var hasError = false;
            if ( options.filter(ele) ) continue;

            needCheck++;

            //获取字段名称
            o.cname = $(ele).attr('cname');
            if ( o.cname == undefined ) o.cname = $(ele).attr('placeholder');

            o.failText = $(ele).attr("message");  //获取验证失败的提示语
            if ( !o.failText ) {
                try { o.failText = o.message[$(ele).attr("dtype")].replace("{cname}", o.cname); }
                catch (e) { o.failText = o.cname + "格式错误."; }
            }

            if ( !notEmptyCheck(value, ele) ) { //非空验证
	            hasError = true;
                if ( !options.continueCheck ) break;
            }

            if ( !hasError && !lengthCheck(value, ele) ) {   //数据长度的验证
	            hasError = true;
                if ( !options.continueCheck ) break;
            }

            if ( !hasError && !checkBoxCheck(ele) ) {    //checkbox验证
	            hasError = true;
                if ( !options.continueCheck ) break;
            }

            if ( !hasError && !repassCheck(value, ele) ) { //确认密码验证
	            hasError = true;
                if ( !options.continueCheck ) break;
            }

            if ( !hasError && !regExpCheck(value, ele) ) {    //正则判断
	            hasError = true;
                if ( !options.continueCheck ) break;
            }

            if ( !hasError && !customCheck(value, ele) ) {   //自定义的验证操作
                o.checkSuccess = false;
                hasError = true;
                if ( !options.continueCheck ) break;
            }

            if ( !hasError && !ajaxCheck(value, ele) ) {   //ajax验证
	            hasError = true;
                if ( !options.continueCheck ) break;
            }

            //数据验证通过
            if ( options.continueCheck && !hasError && ele.type != 'radio' ) {
	            __ERROR__('ok', o.cname+"填写正确！", ele);
            }

            if ( o.checkSuccess ) hasChecked++;

        }
        //console.log("needCheck:"+needCheck);
        //console.log("hasChecked:"+hasChecked);
        return (needCheck == hasChecked);

    };

    //对18位身份证进行校验码验证
    o.idNumCheck = function (value) {

        if (value.length != 18) return false;
        //加权因子
        var wi = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1];
        //校验码对应值
        var vi = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
        var ai = new Array(17);
        var sum = 0;
        var remaining, verifyNum;

        for (var i = 0; i < 17; i++) ai[i] = parseInt(value.substring(i, i + 1));

        for (var m = 0; m < ai.length; m++) sum = sum + wi[m] * ai[m];

        remaining = sum % 11;
        if (remaining == 2) verifyNum = "X";
        else verifyNum = vi[remaining];

        return (verifyNum == value.substring(17, 18));
    };

    /**
     *
     * 1.如果密码少于6位，那么就认为这是一个太弱密码。返回0
     * 2.如果密码只由数字、小写字母、大写字母或其它特殊符号当中的一种组成，则认为这是一个弱密码。返回1
     * 3.如果密码由数字、小写字母、大写字母或其它特殊符号当中的两种组成，则认为这是一个中度安全的密码。返回2
     * 4.如果密码由数字、小写字母、大写字母或其它特殊符号当中的三种以上组成，则认为这是一个比较安全的密码。返回3
     * @param str
     */
    o.getPassRank = function( str ) {

        if ( str.length <= 5 ) return 0;
        var mode = 0;
        //获取该字符串的所有组成模式
        for ( var i = 0; i < str.length; i++ ) {
            mode |= charMode(str.charCodeAt(i));
        }
        return getModeNum(mode);
    };

    /**
     * 设置全局的提示信息
     * @param message
     */
    o.setMessage = function(message) {

        if ( Object.prototype.toString.call(message) == "[object Object]" ) {
            this.message = message;
        }
    }

    /**
     * 新增正则表达式
     * @param name
     * @param value
     */
    o.addRegExp = function(name, value) {
        o.regExp[name] = value;
    }


	/**
     * 非空验证
     * @param value
     * @param ele
     * @returns {boolean}
     */
    function notEmptyCheck(value, ele) {

        if ( !value ) {
            if ( ele.type == 'text'
                || ele.type == 'textarea'
                || ele.type == 'password'
                || ele.type == 'email') {

               try {
                   var message = o.message["empty"].replace("{cname}", o.cname);
               } catch (e) {
                   message = '请填写' +o.cname + '.';
               }
                __ERROR__('error', message, ele);
            } else {
                __ERROR__('error', '请选择' + o.cname, ele);
            }

            return false;
        }
        return true;
    }

	/**
     * 数据长度验证
     * @param value
     * @param ele
     */
    function lengthCheck(value, ele) {

        var minLength = $(ele).attr('min-length'), maxLength = $(ele).attr('max-length');
        if ( minLength && value.length < minLength ) {
            __ERROR__('error', o.cname+"最少需要输入 "+minLength+" 个字符.", ele);
            return false;
        }
        if ( maxLength && value.length > maxLength ) {
            __ERROR__('error', o.cname+"最多可以输入 "+maxLength+" 个字符.", ele);
            return false;
        }
        return true;

    }

	/**
     * checkbox 验证
     * @param ele
     * @returns {boolean}
     */
    function checkBoxCheck(ele) {

        if ( ele.type == 'checkbox' && o.checkboxsCache[ele.name] == undefined ) {

            var max_check = parseInt($(ele).attr("max-check"));
            var min_check = parseInt($(ele).attr("min-check"));
            var checked = 0;
            var checkboxs = $("#"+options.formId).find("input[name='"+ele.name+"']");
            for ( var n = 0; n < checkboxs.length; n++ ) {
                if ( checkboxs[n].checked ) checked++;
            }

            if ( min_check && checked < min_check ) {
                __ERROR__('error', o.cname+"至少要选中 "+min_check+" 项！", ele);
                return false;

            }

            if ( max_check && checked > max_check ) {
                __ERROR__('error', o.cname+"最多选中 "+max_check+" 项！", ele);
                return false;
            }

            o.checkboxsCache[ele.name] = 1;    //缓存checkbox，同样名称的checkbox只检查一个
        }
        return true;
    }

	/**
     * 确认密码验证
     * @param value
     * @param ele
     * @returns {boolean}
     */
    function repassCheck(value, ele) {

        var dtype = $(ele).attr('dtype');
        if ( dtype == 'repass' ) {
            var password = $(ele).attr('for-password');
            if ( value != $('#'+password).val() ) {
                __ERROR__('error', "确认密码必须和密码一致！", ele);
                return false;
            }

        }
        return true;
    }

	/**
     * 自定义验证 callback(value, elements)
     * @param value
     * @param ele
     * @returns {boolean}
     */
    function customCheck(value, ele) {

        var handler = $(ele).attr('handler');
        if ( handler ) {

            var p1 = handler.indexOf("(");
            var p2 = handler.indexOf(")");
            var argstr = handler.substring(p1+1, p2);
            var args = argstr.replace(/^\s+/g, '').split(",");
            var checkFunc = new Function(args, "return "+handler);

            if ( !checkFunc(value, ele) ) {
                return false;
            };

        }
        return true;

    }

	/**
     * ajax 验证
     * @param value
     * @param ele
     * @returns {boolean}
     */
    function ajaxCheck(value, ele) {
        var url = $(ele).attr('ajax');
        if ( url != undefined ) {
            $.ajax({url : url, data : {ajaxdata : value}, type : 'get', dataType : 'json', async : false,
                success : function( result ) {
                    if ( result.code == "0" ) return true;
                    else  __ERROR__(result.code, result.message, ele);
                }
            });
            return false;
        }
        return true;
    }

	/**
     * 正则验证
     * @param value
     * @param ele
     * @returns {boolean}
     */
    function regExpCheck(value, ele) {

        var type = $(ele).attr("dtype");
        if (!type) return true;

        if ( type == "idnum" && !o.idNumCheck(value) ) { //身份证验证
            __ERROR__('error', o.failText, ele);
            return false;
        }

        if ( type == "number" ) {
            if ( !o.regExp[type].test(value) ) {
                __ERROR__("error", o.cname+"必须是数字！", ele);
                return false;
            }
            var range = $(ele).attr("range");
            if ( range ) {
                var __range = range.split("-");
                if ( __range[1] != '' && value > __range[1] ) {
                    __ERROR__("error", o.cname+"不能大于"+__range[1]+".", ele);
                } else if( __range[0] != '' && value < __range[0] ) {
                    __ERROR__("error", o.cname+"不能小于"+__range[0]+".", ele);
                }
                return (value >= __range[0] && value <= __range[1]);
            }
            return true;
        }


        if ( o.regExp[type] && !o.regExp[type].test(value) ) {
            __ERROR__('error', o.failText, ele);
            return false;
        }
        return true;
    };

    /**
     * 计算一个字符所属的类型
     * 数字|小写字母|大写字母|特殊字符
     */
    function charMode( code ) {
        if ( code >= 48 && code <= 57 ) //数字 00000000 00000000 00000000 00000001
            return 1;
        if ( code >= 65 && code <= 90 ) //大写字母 00000000 00000000 00000000 00000010
            return 2;
        if ( code >= 97 && code <= 122 ) //小写 00000000 0000000 00000000 00000100
            return 4;
        else
            return 8; //特殊字符    0000000 0000000 00000000 00001000
    };

    /**
     * 获取一共有多少种组合模式，并转换为十进制的表示模式
     * @param number 模式总数
     * 00000010
     * 00000001
     */
    function getModeNum( number ) {
        var modes = 0;
        for ( var i = 0; i < 4; i++ ) {
            if ( number & 1 ) modes++;
            number>>>=1;    //向右移动一位
        }
        return modes;
    };

    /**
     * 错误信息处理
     * @param type
     * @param message
     * @param ele
     */
    function __ERROR__( type, message, ele ) {

        if ( type == 'error' ) o.checkSuccess = false;
        options.showMessage(type, message, ele);    //调用用户的错误信息处理接口

    };

    return o;
};
