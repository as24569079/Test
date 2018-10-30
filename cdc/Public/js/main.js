 require.config({
            baseUrl: '/CMSScripts/Custom/Ecommercejs',
            urlArgs: "bust=" +  (new Date()).getTime(),
            paths: {
                'domReady': 'Vendor/DomReady/DomReady',
                'jquery': 'Vendor/jQuery/jQuery.min',
                'noty':'Vendor/Notify/jquery.noty.packaged.min'
            },
            shim: {
                jQuery: {
                    exports: 'jQuery',
                    init: function() {
                        return this.jQuery.noConflict(true);
                    }
                }
            }
        });

     require(['Modules/MobileMenu'], function () {
        });  