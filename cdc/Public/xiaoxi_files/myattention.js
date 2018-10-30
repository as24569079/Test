/**
 * Created by xiangshoulai on 2016/5/12.
 */
;(function(global) {
    var M = global.M = global.M || {};
    var ObjectUtil = {
        $mObj : {},
        /**
         * 将config对象的属性合并到object
         */
        merge: function(object, config, isDeep) {
            if (!object || !config || typeof config != 'object') {
                return object;
            }

            if (!isDeep) {
                for (var p in config) {
                    object[p] = config[p];
                }
            }
            else {
                var property, value;
                for (property in config) {
                    if (config.hasOwnProperty(property)) {
                        value = config[property];
                        if (value && value.constructor === Object) {
                            if (object[property] && object[property].constructor === Object) {
                                ObjectUtil.merge(object[property], value);
                            }
                            else {
                                object[property] = value;
                            }
                        }
                        else {
                            object[property] = value;
                        }
                    }
                }
            }
            return object;
        },

        /**
         * 克隆object
         */
        clone: function(object, isDeep){
            return ObjectUtil.merge({}, object, isDeep);
        },

        /**
         * 创建命名空间所需要的对象
         */
        namespace: function() {
            var root = global,
                parts, part, i, j, ln, subLn;

            for (i = 0, ln = arguments.length; i < ln; i++) {
                var arg = arguments[i];
                if (ObjectUtil.$mObj.namespace[arg]) {
                    continue;
                }
                parts = arg.split('.');
                for (j = 0, subLn = parts.length; j < subLn; j++) {
                    part = parts[j];
                    if (!root[part]) {
                        root[part] = {};
                    }
                    root = root[part];
                }
                ObjectUtil.$mObj.namespace[arg] = true;
            }
        },

        /**
         * 类继承
         * @param {Function} 父类
         * @param {Object} 自定义可覆盖父类的方法
         * @return {Function} 子类
         */
        extend: function(){
            var inlineOverrides = function(o){
                for (var m in o) {
                    if (!o.hasOwnProperty(m)) {
                        continue;
                    }
                    this[m] = o[m];
                }
            };
            return function(superclass, overrides){
                (typeof superclass == 'function') || (superclass = function(){});
                var subclass = function(){
                    superclass.apply(this, arguments);
                };
                var F = function(){};

                F.prototype = superclass.prototype;
                subclass.prototype = new F();
                subclass.prototype.constructor = subclass;
                subclass.superclass = superclass.prototype;

                if (superclass.prototype.constructor === Object.prototype.constructor) {
                    superclass.prototype.constructor = superclass;
                }

                subclass.override = function(overrides){
                    if (subclass.prototype && overrides && typeof overrides == 'object') {
                        for (var p in overrides) {
                            subclass.prototype[p] = overrides[p];
                        }
                    }
                };
                subclass.prototype.override = inlineOverrides;
                subclass.override(overrides);

                return subclass;
            };
        }(),
        extends:function(target,source){
            for (var name in source) {
                if (source[name] !== undefined) {target[name] = source[name]}
            }
        },
        /**
         * 对象/数组遍历
         * @param {Object} values 遍历对象/数组
         * @param {Object} iterator 将遍历的对象/数组中的每一项元素传给该函数，函数参数为value, key
         * @param {Object} scope 函数作用域
         */
        each: function(values, iterator, scope){
            if (ObjectUtil.isEmpty(values) || !iterator) {
                return;
            }
            if (ObjectUtil.isArray(values)) {
                for (var i = 0, l = values.length; i < l; i++) {
                    try {
                        if (iterator.call(scope, values[i], i, values) === false) {
                            return;
                        }
                    } catch (e) {
                        M.log(e, 'error');
                    }
                }
            } else {
                for (var key in values) {
                    if (!values.hasOwnProperty(key)) {
                        continue;
                    }
                    try {
                        if (iterator.call(scope, values[key], key, values) === false) {
                            return;
                        }
                    } catch (e) {
                        M.log(e, 'error');
                    }
                }
            }
        },
        contains: function(obj, item){
            if (ObjectUtil.isArray(obj)) {
                if ('indexOf' in Array.prototype) {
                    return obj.indexOf(item) !== -1;
                }

                var i, ln;
                for (i = 0, ln = obj.length; i < ln; i++) {
                    if (obj[i] === item) {
                        return true;
                    }
                }

                return false;
            }
            else {
                return !ObjectUtil.isEmpty(obj) && item in obj;
            }
        },
        isEmpty: function(v, allowEmptyString){
            if ((typeof v === 'undefined') || (v === null) || (!allowEmptyString ? v === '' : false) ||
                (ObjectUtil.isArray(v) && v.length === 0)) {
                return true;
            } else if (ObjectUtil.isObject(v)) {
                for (var key in v) {
                    if (Object.prototype.hasOwnProperty.call(v, key)) {
                        return false;
                    }
                }
                return true;
            }
            return false;
        },
        isBlank: function(v){
            return ObjectUtil.isEmpty(v) ? true : ObjectUtil.isEmpty(String(v).replace(/^\s+|\s+$/g, ''));
        },
        isDefined: function(v){
            return typeof v === 'undefined';
        },
        isObject: function(value){
            if (Object.prototype.toString.call(null) === '[object Object]') {
                return value !== null && value !== undefined &&
                    Object.prototype.toString.call(value) === '[object Object]' && value.ownerDocument === undefined;
            } else {
                return Object.prototype.toString.call(value) === '[object Object]';
            }
        },
        isFunction: function(v){
            return Object.prototype.toString.apply(v) === '[object Function]';
        },
        isArray: function(v){
            return Object.prototype.toString.apply(v) === '[object Array]';
        },
        isDate: function(v){
            return Object.prototype.toString.apply(v) === '[object Date]';
        },
        isNumber: function(v){
            return typeof v === 'number' && isFinite(v);
        },
        isString: function(v){
            return typeof v === 'string';
        },
        isBoolean: function(v){
            return typeof v === 'boolean';
        }
    };
    M.object = ObjectUtil;
})(window);/**
 * Created by xiangshoulai on 2016/5/12.
 */
;(function(global) {
    var M = global.M = global.M || {};
    var ObjectUtil= M.object;
    /************************ Core *********************************/
    /*
     * 模块定义及加载状态 { factory: [Function], exports: [Object]}
     */
    M.modules = {};
    /**
     * 模块资源配置 	name :{depend: [name]}

     */
    M.runMod = [];

    /**
     * 全局配置
     */
    M.config = {
        debug: 0
    };

    /**
     * 日志
     */
    M.log = function(msg, type) {
        M.config && M.config.debug && (typeof console !== 'undefined' && console !== null) &&
        (console[type || (type = 'log')]) && console[type](msg);
    };

    var Core = {
        require: function(path, callback){
            !ObjectUtil.isArray(path) && (path = Array(path));
            // 加载JS
            Core.loadJs(path, callback);
        },
        loadJs: function(arrJs, callback) {
            $LAB.setOptions({AlwaysPreserveOrder: true}).script(arrJs).wait(function(){
                if(callback){
                    callback.call(null);
                }
            });
        },
        /**
         * 获取模块定义
         */
        exports : function(moduleName) {
            if (M.modules[moduleName] && M.modules[moduleName].exports) {
                return M.modules[moduleName].exports;
            }
            return null;
        },
        /**定义模块
         *
         */
        define : function(moduleName, fn){
            if (arguments.length == 1) {
                fn = moduleName;
            }
            if (ObjectUtil.isEmpty(moduleName) && M.isFunction(fn)) {
                fn.call(null);
                return;
            }
            !M.modules[moduleName] && (M.modules[moduleName] = {});
            M.modules[moduleName]['factory'] = fn;

        },
        /**
         * 执行模块的定义代码
         */
        defineModule : function() {
            ObjectUtil.each(M.modules, function(value, moduleName){
                var module = M.modules[moduleName];
                if (!module.exports && module.factory) {
                    module.exports = {};
                    var exports = module.factory.call(null, module.exports);
                    exports && (module.exports = exports);
                }
            });
        },
        /**
         * 批量设置模块资源配置
         */
        setRunMod : function(moduleNames, isCover) {
            if(ObjectUtil.isArray(moduleNames)){
                if(isCover){
                    M.runMod = moduleNames;
                }else{
                    M.runMod = M.runMod.concat(moduleNames);
                }
            }else if(ObjectUtil.isString(moduleNames) && !ObjectUtil.isBlank(moduleNames)){
                if(isCover){
                    M.runMod = [moduleNames];
                }else{
                    M.runMod.push(moduleNames);
                }
            }
        },
        /**
         * 获取配置信息
         */
        setConfig : function(name, value) {
            Core.setGlobalProp('config', name, value);
        },

        /**
         * 全局配置设置
         */
        setGlobalProp : function(prop, name, value) {
            var global = M[prop];
            // key-value方式设置单个配置
            if (ObjectUtil.isString(name)) {
                /*if (MC.contains(global, name)) {
                 MC.log('全局配置被覆盖：' + '[' + prop + ']' + name);
                 }*/
                global[name] = value;
                return;
            }

            // 对象方式设置多个配置
            if (ObjectUtil.isObject(name)) {
                var obj = name;
                ObjectUtil.each(obj, function(_value, _name){
                    setGlobalProp(prop, _name, _value);
                });
            }
        },
        /**
         * id生成器
         */
        idSeed : 0,
        genId : function(prefix) {
            var id = (prefix || 'mGen') + (++Core.idSeed);
            return id;
        },
        /**
         *
         * @param opt
         * @param paramsOpt
         */
        runner : function(args){
            Core.defineModule();
            var hasArgs = false;
            if(ObjectUtil.isObject(args)){
                hasArgs = true;
            }
            ObjectUtil.each(M.runMod, function(moduleName){
                var moduleNameArgs = hasArgs &&  args[moduleName] ? args[moduleName] : null;
                if(Core.exports(moduleName)){
                    var exports = Core.exports(moduleName);
                    var run = exports.clazz ? new exports.clazz(moduleNameArgs) : exports;
                    if(ObjectUtil.isFunction(run.run)){
                        try{
                            run.run();
                        }catch(e){
                            M.log(e, 'error');
                        }
                    }
                }
            });
        }
    };
    M.require = function(){
        return Core.require.apply(null,arguments);
    };
    M.genId = function(){
        return Core.genId.apply(null,arguments);
    };
    M.define = function(){
        return Core.define.apply(null,arguments);
    };
    M.runner = function(){
        return Core.runner.apply(null,arguments);
    };
    M.setConfig = function(){
        return Core.setConfig.apply(null,arguments);
    };
    M.setRunMod = function(){
        return Core.setRunMod.apply(null,arguments);
    };
    M.exports = function(){
        return Core.exports.apply(null,arguments);
    };
})(window);;(function($){
    'use strict';
    $.fn.loadPage=function(options){
        return new LoadPage(this[0],options);
    };
    var LoadPage = (function(){
        var LoadPage=function(contianerEl,options){
            this.init(options);
        };
        LoadPage.prototype = {
            init: function(options) {
                var settings = {
                    containId: '',//wrapperId
                    currentPage: 1,//current pageNum
                    baseUrl: '',//baseURL
                    reqPara: '',//parameter data
                    beforeFn: null,// before send fn
                    successFn: null,//success fn
                    errorFn: null,//error fn
                    reLoad:true,
                    isRepeatReq: false,// control repeat request
                    pageNo: 'offset',// pageNumber key name
                    maxHeightFlag:0,
                    errorFlag:false, //error flag
                    firstLoad:true,
                    async:true
                    // listHeight:0
                };
                this.settings = $.extend(settings,options);
                this.currentPage = settings.currentPage;
                this.containId = settings.containId;
                this.objContain = document.querySelector(this.containId);

                //if(this.currentPage>1||this.settings.firstLoad){
                //    this.getData(this.currentPage);
                //}
                this.currentPage++;
                this.events();
                // this.listHeight = settings.listHeight;
                // this.h = document.body.scrollHeight-settings.listHeight*2
            },
            bindScrollEvts: function(){
                var _this = this;
                window.onscroll=function(){
                    $('body').css({"height":document.documentElement.clientHeight});
                    /*if(_this.settings.maxHeightFlag == document.body.scrollHeight&& _this.settings.errorFlag&& !_this.settings.isRepeatReq){
                     _this.getData(_this.currentPage);
                     return false
                     }else if(_this.settings.maxHeightFlag == document.body.scrollHeight){
                     return false
                     }*/
                    if((document.body.clientHeight+document.body.scrollTop)>=document.body.scrollHeight-356&& !_this.settings.isRepeatReq&&!_this.settings.errorFlag&&!_this.settings.isEmpty){
                        _this.settings.maxHeightFlag = document.body.scrollHeight;
                        _this.getData(_this.currentPage++);
                    }else if((document.body.clientHeight+document.body.scrollTop)>=document.body.scrollHeight-356&&!_this.settings.isRepeatReq&& (_this.settings.errorFlag&&_this.settings.isEmpty)){
                        _this.settings.maxHeightFlag = document.body.scrollHeight;
                        _this.getData(_this.currentPage);
                        //console.log(_this.currentPage);
                    }
                    return false;
                };
            },

            events: function(){
                this.bindScrollEvts();
                this.goBack2Top();
            },
            goBack2Top: function(){
                var oUP = document.querySelector('#indexToTop');
                var CLICK='click',agent = window.navigator.userAgent;
                var evts = {
                    init:function(){
                        evts.scrollEvt();
                        evts.toTopEvt();
                    },
                    toTopEvt:function(){
                        oUP.addEventListener(CLICK,function(){
                            scroll(0,0);
                            oUP.style.display='none';
                        },false);
                    },
                    scrollEvt:function(){
                        window.addEventListener('scroll',function(){
                            var clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
                            var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                            if(scrollTop>clientHeight*2){
                                oUP.style.display='block';
                            }else{
                                oUP.style.display='none';
                            }
                        },false);
                    }
                };
                return evts.init();
            },
            getData: function(pageNum,flag) { //n pageNum
                if(!this.settings.isRepeatReq){
                    this.settings.isRepeatReq=true;
                }
                this.getSomeData(pageNum);
            },
            EncodeUtf8: function(s1){
                var s = escape(s1);
                var sa = s.split("%");
                var retV ="";
                if(sa[0] != "")
                {
                    retV = sa[0];
                }
                for(var i = 1; i < sa.length; i ++)
                {
                    if(sa[i].substring(0,1) == "u")
                    {
                        retV += Hex2Utf8(Str2Hex(sa[i].substring(1,5)));

                    }
                    else retV += "%" + sa[i];
                }

                return retV;
            },
            getSomeData: function(pageNum){
                var _this = this;
                var urlTemp;
                var parameter = _this.settings.reqPara;
                //parameter[_this.settings.pageNo] = pageNum; //pageNo		temp delete TODO !
                urlTemp=_this.settings.baseUrl+pageNum;
                $.ajax({
                    url: urlTemp,
                    type: _this.settings.reqType,
                    dataType:'json',
                    data:parameter,
                    beforeSend: _this.settings.beforeFn,
                    async:_this.settings.async,

                    success:function(data){
                        //_this.settings.reLoad=false;
                        //console.log(url);
                        _this.settings.successFn(data);
                        _this.settings.reLoad=false;
                        _this.settings.isRepeatReq=false;
                        _this.settings.errorFlag=false;
                    },
                    error: function(xhr, type){
                        _this.settings.errorFn();
                        _this.settings.isRepeatReq=false;
                        _this.settings.errorFlag=true;
                        _this.settings.isEmpty=true;
                    }
                });
            }
        };
        return LoadPage;
    })();

    $.loadPage=function(options){

        $(document.body).loadPage(options);
    };
})($);
/**
 * Created by meijishuang on 2016/6/20.
 */
/**
 *
 * Created by xiangshoulai on 2015/9/28.
 * Modified by shenpeng on 2016/5/23.
 * v1.3
 * styleType 1表示普通toast弹层, 2表示新版样式提示弹出层（底部双按钮）, 3表示老版样式提示弹出层（底部双按钮）, 4表示实名认证提示层（底部一个按钮）
 * width 弹框的宽度可填
 * cls 弹层所需的图标样式，没有图标的不用设置此项
 * titleName 提示title文案
 * message 具体提示文案
 * delay 计时器
 * autoClose 是否可以自动隐藏
 * maxHeight 设置最大高度，优化下发提示文案过多的情况
 * container 容器ID
 * btns 设置弹框中按钮的文案，json对象的方式 比如{cancelTxt:'取消',okTxt:'提交'}
 * okCallback 点击确定按钮执行的回调函数
 * listContainer 被遮盖的列表容器
 * islimitHeight 弹出层弹出时是否限制页面高度来防止页面滚动
 */
;(function($) {
    'use strict';
    $.fn.toast = function(opts) {
        return new Toast(this[0],opts);
    }
    ;
    var Toast = (function() {
        var Toast = function(containerEl, opts) {
                if (typeof containerEl === 'string' || containerEl instanceof String) {
                    this.container = document.getElementById(containerEl);
                } else {
                    this.container = containerEl;
                }
                if (!this.container) {
                    window.alert("error finding container for toast " + containerEl);
                    return;
                }

                if (typeof (opts) === "string" || typeof (opts) === "number") {
                    opts = {
                        message: opts
                    };
                }
                if (opts.autoClose === false) {
                    opts.autoClose = false;
                }else{
                    opts.autoClose = true;
                }
                this.styleType = opts.styleType || 1;
                this.width = opts.width ? opts.width : this.width;
                this.height = opts.height ? opts.height : this.height;
                this.cls = opts.cls ? opts.cls : '';
                this.titleName = opts.titleName || '';
                this.message = opts.message || '';
                this.delay = opts.delay || this.delay;
                // this.type = opts.type || '';
                this.autoClose = opts.autoClose;
                this.isMaskClose = opts.isMaskClose;
                this.maxHeight = opts.maxHeight ? opts.maxHeight : this.maxHeight;
                this.islimitHeight = opts.islimitHeight ? opts.islimitHeight : this.islimitHeight;
                this.okCallback=opts.okCallback?opts.okCallback:this.okCallback;
                this.btns=opts.btns?opts.btns:this.btns;
                this.listContainer=opts.listContainer?opts.listContainer:this.listContainer;

                this.container = $(this.container);
                if (this.container.find(".mjdToastContainer").length === 0) {
                    this.container.append("<div class='mjdToastContainer'></div>");
                }
                this.container = this.container.find(".mjdToastContainer");
                this.container.removeClass("tr tb br tl tc bc");

                this.show();
            }
            ;
        Toast.prototype = {
            cls: null ,
            titleName: null ,
            message: null ,
            delay: 2000,
            styleType: 1,
            el: null ,
            container: null ,
            listContainer:null,
            timer: null ,
            width: 0,
            height: 0,
            autoClose: true,
            isMaskClose:true,
            scrollH:'',
            bodyH:'',
            maxHeight: 0,
            islimitHeight: true,
            btns: {cancelTxt:'取消',okTxt:'提交'},
            okCallback:function(){},
            show: function() {
                var self = this;
                var markUp = this.addHtml();
                this.el = $(markUp).get(0);
                this.container.append(this.el);
                var $el = $(self.el);
                if(self.listContainer!=null){
                    var listC=$(self.listContainer);
                    self.bodyH=listC.height();
                    self.scrollH=document.body.scrollTop;
                }

                self.setPosition($el);
                self.setEvent($el);
                if(self.styleType == 1){
                    self.islimitHeight = false;
                }
                if(self.islimitHeight){
                    self.setBody(1);
                }
                if (self.autoClose) {
                    self.timer = setTimeout(function() {
                        self.hide();
                    }, this.delay);
                }


            },
            setEvent:function($el){
                var self=this;
                switch(self.styleType)
                {
                    case 1:
                        if(self.isMaskClose){
                            $el.bind('click', function() {
                                self.hide();
                            });
                        }
                        break;
                    case 2:
                        $('.btn-close').bind('click', function() {
                            self.hide();
                        });
                        $('.btn-sure').bind('click',function() {
                            self.okCallback();
                            self.hide();
                        });
                        break;
                    case 3:
                        $('.btn-cancel').bind('click',function(){
                            self.hide();
                        });
                        $('.btn-ok').bind('click',function(){
                            self.okCallback();
                            self.hide();
                        });
                        break;
                    case 4:
                        $('.one-btn-tip-btn').bind('click',function(){
                            // $('#popModalOneBtn').remove();
                            self.hide();
                        });
                        break;
                    default:
                        break;
                }
            },
            /*
             * set the box location
             * */
            setPosition: function($el) {
                var self = this;
                var mbox = $el.find('.content-box');
                //mbox.css('height',height);
                if (self.width > 0) {
                    mbox.css('width', self.width);
                } else {
                    self.width = mbox.css('width').replace('px', '');
                }
                if (self.height <= 0) {
                    self.height = mbox.css('height').replace('px', '');
                }

                mbox.css('marginLeft', -self.width / 2);
                mbox.css('marginTop', -self.height / 2);
                // mbox.removeClass("hidden");

                //设置位置
                var wrapper = $el.find('.txt-max-height');
                wrapper.css({
                    'maxHeight' : self.maxHeight,
                    'overflow' : 'scroll'
                });
            },
            /*
             * set the body height
             * */
            setBody:function(type){
                var self=this;
                var clientH=document.documentElement.clientHeight;
                var listC=$(self.listContainer);

                if(type==1){
                    listC.css({
                        'height':clientH,
                        'overflow':'hidden'
                    });
                }else if(type==2){
                    listC.css({
                        'height':self.bodyH,
                        'overflow':''
                    });
                    document.body.scrollTop=self.scrollH;
                }
            },
            hide: function() {
                var self = this;
                if(self.islimitHeight){
                    self.setBody(2);
                }
                if (self.timer != null ) {
                    clearTimeout(self.timer);
                }
                // $(self.el).unbind('click').addClass("hidden");
                // $(self.el).css('height', '0');
                self.remove();
            },
            remove: function() {
                var $el = $(this.el);
                $el.remove();
            },
            addHtml: function() {
                var self = this;
                var maskHTML = "";
                switch (self.styleType) {
                    case 1:
                        maskHTML = '<div class="shade-floor">';
                        maskHTML += '<div class="message-box content-box">';
                        maskHTML += '<div class="message-box-icon"><i class="message-icon ' + self.cls + '"></i></div>';
                        maskHTML += '<div class="message-box-content txt-align">' + self.message + '</div>';
                        maskHTML += '</div>';
                        maskHTML += '</div>';
                        break;
                    case 2:
                        maskHTML = '<div class="shade-floor">';
                        maskHTML += '<div class="cover-floor"></div>';
                        maskHTML += '<div class="choose-box content-box">';
                        maskHTML += '<div class="choose-box-title">' + self.titleName + '</div>';
                        maskHTML += '<div class="message-div">';
                        maskHTML += '<div class="message-txt">' + self.message + '</div>';
                        maskHTML += '</div><div class="choose-box-btn">';
                        maskHTML += '<a class="btn-close">' + self.btns.cancelTxt + '</a>';
                        maskHTML += '<a class="btn-sure">' + self.btns.okTxt + '</a>';
                        maskHTML += '</div></div></div>';
                        break;
                    case 3:
                        maskHTML += '<div class="shade-floor" id="pop-modal">';
                        maskHTML += '<div class="cover-floor"></div>';
                        maskHTML += ' <div class="info-box content-box">';
                        maskHTML += ' <div class="info-box-content bdb-1px">';
                        maskHTML += ' <span class="info-box-text">' + self.message + '</span>';
                        maskHTML += ' </div><div class="box-container"><div class="btn-box">';
                        maskHTML += ' <a class="btn-box-item"><i class="btn-cancel">'+self.btns.cancelTxt+'</i></a>';
                        maskHTML += ' <a  class="btn-box-item"><i class="btn-ok">'+self.btns.okTxt+'</i></a>';
                        maskHTML += ' </div></div></div></div>';
                        break;
                    case 4:
                        maskHTML += '<div class="shade-floor" id="popModalOneBtn" style="visibility:visible;">';
                        maskHTML += '<div class="cover-floor"></div>';
                        maskHTML += ' <div class="content-box one-btn-tip-box-tip">';
                        maskHTML += '   <div class="one-btn-tip-info">'
                        maskHTML += '     <span class="txt-max-height">' + self.message + '</span>'
                        maskHTML += '   </div>'
                        maskHTML += '   <div class="one-btn-tip-btn">'+self.btns.closeTxt+'</div>'
                        maskHTML += ' </div></div>';
                        break;
                    default:
                        break;
                }

                return maskHTML;
            }
        };

        return Toast;
    })();

    $.toast = function(opts) {
        $(document.body).toast(opts);
    }
})($);
/**
 * Created by mjs on 2016/6/21.
 */
M.define('attention',function(exports){
    var Attention=function(argObj){
        this.init(argObj);
    };
    M.object.merge(Attention.prototype,{
        init:function(argObj){
            var _this = this;
            _this.resizeScreen();//REM
            _this.coverId= document.getElementById('attention');//塞进id为attention的div里
            _this.attentionSID = document.getElementById('sid');

            _this.dogFlag = 0;//已经出现没有更多狗和没有关注商品时dogFlag = 1 此时下拉不再加载数据

            try{
                _this.loaddingContent(argObj,1);//首屏数据；
            }catch(e){

            }

            _this.bind();
            _this.goBack2Top();
            _this.setHeight();

        },
        setHeight:function(){
            var viewports = document.getElementsByClassName("viewports")[0];
            var clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
            viewports.style.minHeight = clientHeight-44-170+'px';
        },

        loaddingContent:function(data,isFirst){
            var _this = this;
            if(data.code!=0 || data.favoriteList.length > 10 ){//上游请求数据错误；系统忙，请稍后再试~~
                $(_this.coverId).parent.append('<div class="just-text">\u7cfb\u7edf\u5fd9\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\u007e\u007e</div>');
                return;
            }


            if(data.favoriteList && data.favoriteList.length > 0){
                var content = '';
                var jdPrice = [];

                for(var i = 0;i < data.favoriteList.length;i++){

                    //懒加载例子
                    //content.push('<span><img _src="assets/i/row03-1.png" src="assets/i/loading-f04.png">'+data.favoriteList[i].name+'</span>') ;

                    content += '<li>';

                    if(data.favoriteList[i].wareId){
                        content += '<a href="http://item.m.jd.com/product/'+data.favoriteList[i].wareId+'.html" class="myattention-productlist-a J_ping" report-eventid="MMyJDFollowed_Commodity" report-eventparam="'+data.favoriteList[i].wareId+'_B" report-eventlevel="2">';
                    }

                    content += '<div class="pic-div">';

                    //content += '<img src="'+data.favoriteList[i].imageurl.replace(".webp","")+'">';
                    //下发链接有问题后台处理
                    var imageurl ;
                    if(data.favoriteList[i] && data.favoriteList[i].imageurl){
                        imageurl = data.favoriteList[i].imageurl.replace("http://","//");
                    }
                    content += '<img src="'+imageurl+'">';

                    if(data.favoriteList[i].stockStateId == 34 && !(data.favoriteList[i].isSoldOut == 0 || data.favoriteList[i].isSoldOut == 10)){//无货
                        content += '<span class="no-pro"></span>';
                        content += '<span class="pro-white"></span>';
                    }
                    if(data.favoriteList[i].isSoldOut == 0 || data.favoriteList[i].isSoldOut == 10){//已下柜
                        content += '<span class="pro-gone">\u5df2\u4e0b\u67dc</span>';
                    }
                    content += '</div>';

                    content += '<div class="prolist-content">';

                    var newPrice=data.favoriteList[i].psPrice?data.favoriteList[i].psPrice:data.favoriteList[i].jdPrice;
                    if(data.favoriteList[i].stockStateId == 34 || data.favoriteList[i].isSoldOut == 0 || data.favoriteList[i].isSoldOut == 10){//已下柜或者无货
                        content += '<div class="prolist-name grayF">';
                        content += '<span>'+data.favoriteList[i].wname+'</span>';
                        content += '</div>';

                        content += '<div class="pro-price grayF">';


                        if(data.favoriteList[i].text){//待发布或暂无报价
                            if(data.favoriteList[i].text.indexOf("待发布")!=-1){
                                var aLink="http://item.m.jd.com/product/"+data.favoriteList[i].wareId+".html";
                                content += '<em onclick="event.preventDefault();window.location.href='+aLink+'" class="J_ping dRelease" report-eventid="MMyJD_PendingRelease"><span class="no-price">'+data.favoriteList[i].text+'</span></em>';
                            }else{
                                content += '<em><span class="no-price">'+data.favoriteList[i].text+'</span></em>';
                            };
                        }else if(newPrice && (data.favoriteList[i].isSoldOut != 0 || data.favoriteList[i].isSoldOut != 10)){

                            jdPrice = newPrice.split('.');

                            content += '<em>&yen;<span class="big-price">'+jdPrice[0]+'.</span><span class="small-price">'+jdPrice[1]+'</span></em>';

                        }/*else{//已下柜或者没有价格   暂无报价
                            content += '<em class="no-price">\u6682\u65e0\u62a5\u4ef7</em>';
                        }*/

                        content += '</div>';
                    }else{//正常情况
                        content += '<div class="prolist-name">';
                        content += '<span>'+data.favoriteList[i].wname+'</span>';
                        content += '</div>';

                        content += '<div class="pro-price">';
                        

                        if(data.favoriteList[i].text){//待发布或暂无报价
                            if(data.favoriteList[i].text.indexOf("待发布")!=-1){
                                var aLink="http://item.m.jd.com/product/"+data.favoriteList[i].wareId+".html";
                                content += '<em onclick="event.preventDefault();window.location.href='+aLink+'" class="J_ping dRelease" report-eventid="MMyJD_PendingRelease"><span class="no-price">'+data.favoriteList[i].text+'</span></em>';
                            }else{
                                content += '<em><span class="no-price">'+data.favoriteList[i].text+'</span></em>';
                            };
                        }else if(newPrice){//价格
                            jdPrice= newPrice.split('.');
                            content += '<em>&yen;<span class="big-price">'+jdPrice[0]+'.</span><span class="small-price">'+jdPrice[1]+'</span></em>';

                        }/*else{//暂无报价
                            content += '<em class="no-price">\u6682\u65e0\u62a5\u4ef7</em>';
                        }*/


                        if(data.favoriteList[i].isMobileVip){
                            if(data.favoriteList[i].diffPrice && data.favoriteList[i].diffPrice != '0.00'){//既有专享价又有降价信息时 只显示降价信息
                                content += '<span class="de-price"><i></i><span>\u6bd4\u5173\u6ce8\u65f6\u964d'+data.favoriteList[i].diffPrice+'\u5143</span></span>';//比关注时降多少元
                            }else{
                                content += '<span class="exclusive-price"><i></i><span>\u4e13\u4eab\u4ef7</span></span>';//专享价
                            }
                        }else if(data.favoriteList[i].diffPrice && data.favoriteList[i].diffPrice != '0.00'){
                            content += '<span class="de-price"><i></i><span>\u6bd4\u5173\u6ce8\u65f6\u964d'+data.favoriteList[i].diffPrice+'\u5143</span></span>';//比关注时降多少元
                        }

                        content += '</div>';


                    }

                    content += '<div class="discount-info">';

                    if(data.favoriteList[i].salesList && data.favoriteList[i].salesList.length >= 1 && data.favoriteList[i].stockStateId != 34 && data.favoriteList[i].isSoldOut != 0 && data.favoriteList[i].isSoldOut != 10){//有促销
                        if(data.favoriteList[i].salesList.length == 1){//1条数据

                            content = _this.firstInfo(data,i,content);


                        }else{//数据大于1
                            content += '<em class="down-arrow-m J_ping" report-eventid="MMyJD_PromotionalArrow" report-eventparam=""></em>';
                            content += '<div class="discount-title">\u53ef\u4eab\u53d7\u4ee5\u4e0b\u4f18\u60e0</div>';//可享受以下优惠

                            //先展示第一条
                            content = _this.firstInfo(data,i,content);

                            //其他数据
                            content += '<div style="display: none">';
                            var dataNum ='';
                            if(data.favoriteList[i].salesList.length <= 8) {//大于1条数据小于8
                                dataNum = data.favoriteList[i].salesList.length;
                            }else{
                                dataNum = 8;
                            }

                            for(var j = 1;j<dataNum;j++){
                                if(data.favoriteList[i].salesList[j].text){
                                    var textType = _this.salesF(data.favoriteList[i].salesList[j].text);
                                }
                                if(data.favoriteList[i].salesList[j].adurl){//有adurl的情况 直接跳adurl
                                    if(textType == 2){//赠品
                                        content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[j].text+'" salesUrl="'+data.favoriteList[i].salesList[j].adurl+'"><i>\u8d60\u54c1</i><span>'+data.favoriteList[i].salesList[j].value+'</span><em></em></div>';
                                    }else if(textType == 3){//跳促销
                                        content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[j].text+'" salesUrl="'+data.favoriteList[i].salesList[j].adurl+'"><i>'+data.favoriteList[i].salesList[j].text+'</i><span>'+data.favoriteList[i].salesList[j].value+'</span><em></em></div>';
                                    }else if(textType == 1){//不跳
                                        content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[j].text+'" salesUrl="'+data.favoriteList[i].salesList[j].adurl+'"><i>'+data.favoriteList[i].salesList[j].text+'</i><span>'+data.favoriteList[i].salesList[j].value+'</span></div>';
                                    }else{//其他促销信息不展示
                                        content+='';
                                    }
                                }else{
                                    if(textType == 2){//赠品
                                        content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[j].text+'" salesUrl="http://item.m.jd.com/product/'+data.favoriteList[i].salesList[j].giftInfo.id+'.html"><i>\u8d60\u54c1</i><span>'+data.favoriteList[i].salesList[j].value+'</span><em></em></div>';
                                    }else if(textType == 3){//跳促销
                                        content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[j].text+'" salesUrl=" http://so.m.jd.com/list/homeSearch.action?activityId='+data.favoriteList[i].salesList[j].promotionId+'&skuId='+data.favoriteList[i].wareId+'&activitySTip='+data.favoriteList[i].salesList[j].value+'"><i>'+data.favoriteList[i].salesList[j].text+'</i><span>'+data.favoriteList[i].salesList[j].value+'</span><em></em></div>';
                                    }else if(textType == 1){//不跳
                                        content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[j].text+'" salesUrl=""><i>'+data.favoriteList[i].salesList[j].text+'</i><span>'+data.favoriteList[i].salesList[j].value+'</span></div>';
                                    }else{//其他促销信息不展示
                                        content+='';
                                    }
                                }

                            }
                            content += '</div>';
                        }
                    }
                    content += '</div>';


                    content += '<div class="buttons cf">';
                    content += '<span class="sim-btn J_ping" report-eventid="MMyJD_Similar" report-eventparam="" sim-url="/myjd/similar/list.action?skuId='+data.favoriteList[i].wareId+'&baseWarePic='+imageurl+'&baseWareName='+encodeURIComponent(data.favoriteList[i].wname)+'&baseWarePrice='+data.favoriteList[i].jdPrice+'&sid='+_this.attentionSID.value+'">\u770b\u76f8\u4f3c</span>';//看相似
                    //content += '<span class="cancle-btn" cancle-url="/myJd/myFocus/cancelFocusWare.action?wareId='+data.favoriteList[i].wareId+'&sid'+_this.attentionSID.value+'">\u53d6\u6d88\u5173\u6ce8</span>';
                    content += '<span class="cancle-btn J_ping"  report-eventid="MMyJD_CancelFollow" report-eventparam="B" cancle-url="/myJd/myFocus/cancelFocusWare.action?wareId='+data.favoriteList[i].wareId+'&sid='+_this.attentionSID.value+'&_format_=json">\u53d6\u6d88\u5173\u6ce8</span>';
                    if(data.favoriteList[i].stockStateId == 34 || data.favoriteList[i].isSoldOut == 0 || data.favoriteList[i].isSoldOut == 10 || data.favoriteList[i].wareType != 0){
                    }else{
                        //content += '<i class="car-btn J_ping" report-eventid="MMyJD_AddToCart" report-eventlevel="5" car-url='+data.favoriteList[i].wareId+'></i>';
                        content += '<i class="car-btn" car-url='+data.favoriteList[i].wareId+'></i>';
                    }

                    content += '</div>';
                    content += '</div>';
                    content += '</a>';
                    content += '</li>';


                }//for结束


                $(_this.coverId).append(content);

                if(data.favoriteList.length<10){//最后一页 没有更多出现
                    $('.no-more')[0].style.display = "block";
                    _this.dogFlag =1;

                }

            }else if(isFirst){//首屏没有关注商品
                $('.just-text')[0].style.display = "block";
                _this.dogFlag = 1;

            }else{
                $('.no-more')[0].style.display = "block";
                _this.dogFlag = 1;
            }
        },
        firstInfo:function(data,i,content){
            var _this = this;
            if(data.favoriteList[i].salesList[0].text){
                var textType = _this.salesF(data.favoriteList[i].salesList[0].text);
            }

            if(data.favoriteList[i].salesList[0].adurl){//有adurl的情况 直接跳adurl
                if(textType == 2){//赠品
                    content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[0].text+'" salesUrl="'+data.favoriteList[i].salesList[0].adurl+'"><i>\u8d60\u54c1</i><span>'+data.favoriteList[i].salesList[0].value+'</span><em></em></div>';
                }else if(textType == 3){//跳促销
                    content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[0].text+'" salesUrl="'+data.favoriteList[i].salesList[0].adurl+'"><i>'+data.favoriteList[i].salesList[0].text+'</i><span>'+data.favoriteList[i].salesList[0].value+'</span><em></em></div>';
                }else if(textType == 1){//不跳
                    content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[0].text+'" salesUrl="'+data.favoriteList[i].salesList[0].adurl+'"><i>'+data.favoriteList[i].salesList[0].text+'</i><span>'+data.favoriteList[i].salesList[0].value+'</span></div>';
                }else{//其他促销信息不展示
                    content+='';
                }

            }else{//没有adurl时正常跳链接
                if(textType == 2){//赠品
                    content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[0].text+'" salesUrl="http://item.m.jd.com/product/'+data.favoriteList[i].salesList[0].giftInfo.id+'.html"><i>\u8d60\u54c1</i><span>'+data.favoriteList[i].salesList[0].value+'</span><em></em></div>';
                }else if(textType == 3){//跳促销
                    content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[0].text+'" salesUrl=" http://so.m.jd.com/list/homeSearch.action?activityId='+data.favoriteList[i].salesList[0].promotionId+'&skuId='+data.favoriteList[i].wareId+'&activitySTip='+data.favoriteList[i].salesList[0].value+'"><i>'+data.favoriteList[i].salesList[0].text+'</i><span>'+data.favoriteList[i].salesList[0].value+'</span><em></em></div>';
                }else if(textType == 1){//不跳
                    content += '<div class="discount-text J_ping" report-eventid="MMyJD_Gift" report-eventparam="'+data.favoriteList[i].salesList[0].text+'" salesUrl=""><i>'+data.favoriteList[i].salesList[0].text+'</i><span>'+data.favoriteList[i].salesList[0].value+'</span></div>';
                }else{//其他促销信息不展示
                    content+='';
                }
            }
            return content;
        },
        salesF:function(text){
            var type='';
            var textT = text.trim();
            switch (true) {
                case textT == '\u8d60\u5238'|| textT == '\u8d60\u4eac\u8c46' || textT == '\u56e2\u8d2d'://赠券 赠京豆 团购
                    type = 1;
                    break;
                case textT == '\u8d60\u54c1'://赠品
                    type = 2;
                    break;
                case textT == '\u6ee1\u51cf'|| textT == '\u6ee1\u9001' || textT == '\u52a0\u4ef7\u8d2d' || textT == '\u591a\u4e70\u4f18\u60e0' || textT == '\u6ee1\u8d60' || textT == '\u8de8\u5e97\u94fa\u6ee1\u514d':
                    type = 3;//满减 满送 加价购 多买优惠 满赠 跨店铺满免
                    break;
                default:
                    type = 4;

            }
            return type;
        },
        loadList:function(){
            var show = $('.is-loading')[0];
            var _this = this;
            $.loadPage({
                containId:'#attention',
                reqType: 'get',
                //baseUrl: 'attention1.json?v=',
                baseUrl:'/myJd/myFocus/newFocusWare.action?sortType=time_desc&pageSize=10&sid='+_this.attentionSID.value+'&_format_=json&page=',
                //baseUrl:'/myJd/myFocus/newFocusWare.action?sortType=time_desc&pageSize=10&sid='+_this.attentionSID.value+'&page=',
                isEmpty:false,
                currentPage:1,//从第二页开始ajax请求


                beforeFn: function(){
                    if($('.no-more')[0].getAttribute('style').indexOf('block')!=-1){

                    }else{
                        show.style.display='block';
                    }

                },
                successFn:function(data){

                    var obj =  JSON.parse(data.favoriteList);
                    if(obj.favoriteList.length>0){
                        _this.loaddingContent(obj,false);

                        show.style.display='none';

                    }else if($('.just-text')[0].getAttribute('style').indexOf('block')!=-1){
                        $('.no-more')[0].style.display = "none";
                        _this.dogFlag = 1;
                    }else{
                        $('.no-more')[0].style.display = "block";
                        _this.dogFlag = 1;
                    }


                        show.style.display='none';


                },
                errorFn:function(){
                    var timer= setTimeout(function(){
                        if(show){
                            show.style.display='none';
                        }
                        clearTimeout(timer);
                    },1000);

                }});

        },


        resizeScreen:function(){
            var screenW=document.documentElement.offsetWidth;
            if(screenW>414){
                screenW=414;
            }else if(screenW<320){
                screenW=320;
            }
            document.documentElement.style.fontSize = screenW / 320*16 + 'px';
        },
        bind:function(){
            var _this=this;
            _this.coverId.onclick = function(e){
                var oEvent = e || event;
                var oSrc = oEvent.srcElement || oEvent.target;
                if(oSrc.className.indexOf('sim-btn') != -1 ){//看相似
                    //event.stopPropagation();阻止冒泡
                    event.preventDefault();//取消默认事件
                    window.location.href = oSrc.getAttribute('sim-url');
                }
                if(oSrc.className.indexOf('cancle-btn') != -1 ){//取消关注
                    event.preventDefault();
                    var cancelFavoriteUrl = oSrc.getAttribute('cancle-url');
                    //_this.toastsuccee("取消成功",92,129);
                    //$(oSrc).parent().parent().parent().remove();
                    $.ajax({
                        url: cancelFavoriteUrl,
                        type: 'post',
                        dataType:'json',
                        success: function(response) {
                            if(response.cancelFavorite){
                                if(response.cancelFavorite.trim() == '\u53d6\u6d88\u6210\u529f'){//取消成功
                                    _this.toastsuccee("\u53d6\u6d88\u6210\u529f",92,129);//取消成功
                                    $(oSrc).parent().parent().parent().remove();
                                    //判断是否该显示“没有关注任何商品”
                                    if(_this.coverId.children.length == 0){
                                        $('.just-text')[0].style.display = "block";
                                    }
                                }else{
                                    _this.toastError("\u53d6\u6d88\u5931\u8d25",92,129);//取消失败
                                }
                            }else{
                                console.log('cancelFavorite为空');
                                _this.toastError("\u53d6\u6d88\u5931\u8d25",92,129);//取消失败
                            }
                        },
                        error: function(response) {
                            //error;
                        }
                    });
                }
                if(oSrc.className.indexOf('car-btn') != -1 ){//加购物车
                    event.preventDefault();
                    event.stopPropagation();//阻止冒泡
                    var proId = oSrc.getAttribute('car-url');
                    var sid = '';
                    if(_this.attentionSID.value){
                        sid = _this.attentionSID.value;
                    }else{
                        sid = '';
                    }
                    var checkvalue = _this.getCookie("USER_FLAG_CHECK");
                    var carUrl = '//p.m.jd.com/cart/add.json?wareId='+proId+'&num=1&isAjax=false&resourceType=&resourceValue=&sid='+sid+'&USER_FLAG_CHECK='+checkvalue;

                    try{
                        var skuId = proId;                    // 必选参数sku
                        var eventId = "MMyJD_AddToCart";            // 必选参数，事件id
                        var cart = new MPing.inputs.AddCart(eventId, skuId);   // 构造AddCart 请求
                        cart.event_param = skuId;                            // 设置cart的参数,可以设置其他参数
                        cart.event_level=5;
                        var mping = new MPing();                    // 构造上报实例
                        mping.send(cart);                         // 上报cart
                    } catch (e){}

                    $.ajax({
                        url: carUrl,
                        type: 'post',
                        dataType:'json',
                        success: function(response) {
                            if(response){
                                if(response.cartJson.resultCode == 0){
                                    _this.toastsuccee("\u606d\u559c\uff0c\u5df2\u6dfb\u52a0\u81f3\u8d2d\u7269\u8f66",110,180);//恭喜，已添加至购物车
                                }else if(response.cartJson.resultCode == 1){
                                    _this.toastError("\u8d2d\u7269\u8f66\u5df2\u6ee1\uff0c\u5148\u53bb\u8d2d\u7269\u8f66\u4e0b\u5355\u5427",110,180);//购物车已满，先去购物车下单吧
                                }else if(response.cartJson.resultCode == 2){
                                    _this.toastError("\u52a0\u5165\u8d2d\u7269\u8f66\u5931\u8d25\uff0c\u8bf7\u7a0d\u540e\u91cd\u8bd5",110,165);//加入购物车失败，请稍后重试
                                }else{
                                    _this.toastError("error",92,129);
                                }
                            }else{
                                console.log('cancelFavorite为空');
                                _this.toastError("error",92,129);
                            }
                        },
                        error: function(response) {
                            //error;
                        }
                    });
                }

                if(($(oSrc).parent())[0].className.indexOf('discount-text') != -1 ){//促销信息点击

                    var salesFavoriteUrl = ($(oSrc).parent())[0].getAttribute('salesUrl');
                    event.preventDefault();
                    //event.stopPropagation();//阻止冒泡
                    if(salesFavoriteUrl){
                        window.location.href = salesFavoriteUrl;
                    }

                }
                if(($(oSrc).parent())[0].className.indexOf('discount-info') != -1 && !(oSrc.className.indexOf('up-arrow') != -1)&&!(oSrc.className.indexOf('down-arrow') != -1)){//促销信息空白位置
                    event.preventDefault();
                    event.stopPropagation();//阻止冒泡
                }
                if(oSrc.className.indexOf('discount-info') != -1 ){//促销信息空白位置
                    event.preventDefault();
                    event.stopPropagation();//阻止冒泡
                }
                if(oSrc.className.indexOf('down-arrow-m') != -1 ){//促销信息箭头
                    event.preventDefault();//取消默认事件
                    if(oSrc.className.indexOf('up-arrow') != -1){//信息已展开
                        oSrc.classList.remove('up-arrow');
                        oSrc.setAttribute('report-eventid','MMyJD_PromotionalArrowUp');
                        oSrc.parentNode.children[1].style.display = 'none';
                        oSrc.parentNode.children[3].style.display = 'none';
                    }else{//信息未展开
                        oSrc.classList.add('up-arrow');
                        oSrc.setAttribute('report-eventid','MMyJD_PromotionalArrow');
                        oSrc.parentNode.children[1].style.display = 'block';
                        oSrc.parentNode.children[3].style.display = 'block';
                    }

                }


            };
            //window.addEventListener("unload", this, false);
            //window.addEventListener("hashchange", this, false);


        },
        //handleEvent: function(e) {
        //    switch (e.type) {
        //        case 'unload':
        //            this.unloadF(e);
        //            break;
        //        case 'focus':
        //            this.focus(e);
        //            break;
        //        case 'hashchange':
        //            this.hashchange(e);
        //            break;
        //    }
        //},

        //focus:function(){
        //    var hash = window.location.hash;
        //    if(hash == "#0"){
        //        window.location.reload();
        //    }
        //},
        //unloadF:function(){
        //    //window.location.hash = "#0";
        //},
        //hashchange:function(){
        //    window.location.reload();
        //},

        getCookie:function(name){
            var acookie=document.cookie.split(";");
            for(var i=0;i<acookie.length;i++){
                if(acookie[i].indexOf(name)>0){
                    var arr=acookie[i].split("=");
                    if(arr.length>1){
                        return unescape(arr[1]);
                    }
                    else{
                        return "";
                    }
                }
            }
            return "";
        },

        goBack2Top: function(){
            var oUP = document.querySelector('#indexToTop');
            var CLICK='click',agent = window.navigator.userAgent;
            var evts = {
                init:function(){
                    evts.scrollEvt();
                    evts.toTopEvt();
                },
                toTopEvt:function(){
                    oUP.addEventListener(CLICK,function(){
                        scroll(0,0);
                        oUP.style.display='none';
                    },false);
                },
                scrollEvt:function(){
                    window.addEventListener('scroll',function(){
                        var clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
                        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                        if(scrollTop>clientHeight*2){
                            oUP.style.display='block';
                        }else{
                            oUP.style.display='none';
                        }
                    },false);
                }
            };
            return evts.init();
        },


        toastError:function(text,height,width) {
            $.toast({
                message: text,
                delay: 2000,
                cls: 'error-icon',
                height:height,
                width:width,
                islimitHeight:false,
                isMaskClose:false

            });
        },
        toastsuccee:function(text,height,width) {
            $.toast({
                message: text,
                delay: 2000,
                cls: 'succee-icon',
                height:height,
                width:width,
                islimitHeight:false,
                isMaskClose:false

            });
        },
        run:function(){
            var _this=this;
            _this.loadList();//不要首屏请求ajax了
        }
    });
            exports.clazz=Attention;
});