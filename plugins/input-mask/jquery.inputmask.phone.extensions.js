(function($) {
    $.extend($.inputmask.defaults.aliases, {
        'phone': {
            url: "phone-codes/phone-codes.json",
            mask: function(opts) {
                opts.definitions = {
                    'p': {
                        validator: function() { return false; },
                        cardinality: 1
                    },
                    '#': {
                        validator: "[0-9]",
                        cardinality: 1
                    }
                };
                var maskList = [];
                $.ajax({
                    url: opts.url,
                    async: false,
                    dataType: 'json',
                    success: function(response) {
                        maskList = response;
                    }
                });

                maskList.splice(0, 0, "+p(ppp)ppp-pppp");
                return maskList;
            }
        }
    });
})(jQuery);