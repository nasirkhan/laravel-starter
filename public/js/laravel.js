/*
Exemples :
<a href="posts/2" data-method="delete" data-token="{{csrf_token()}}">
- Or, request confirmation in the process -
<a href="posts/2" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?">
*/


(function() {

    var laravel = {
        initialize: function() {
            this.methodLinks = $('a[data-method]');
            this.token = $('a[data-token]');
            this.registerEvents();
        },

        registerEvents: function() {
            this.methodLinks.on('click', this.handleMethod);
        },

        handleMethod: function(e) {
            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();
            var form;

            // If the data-method attribute is not PUT, PATCH or DELETE,
            // Then we don't know what to do. Just ignore.
            if ( $.inArray(httpMethod, ['PUT', 'DELETE', 'PATCH']) === - 1 ) {
                return;
            }

            // Allow user to optionally provide data-confirm="Are you sure?"
            if ( link.data('confirm') ) {
                if ( ! laravel.verifyConfirm(link) ) {
                    return false;
                }
            }

            form = laravel.createForm(link);
            form.submit();

            e.preventDefault();
        },

        verifyConfirm: function(link) {
            return confirm(link.data('confirm'));
        },

        createForm: function(link) {
            var form =
            $('<form>', {
                'method': 'POST',
                'action': link.attr('href')
            });

            var token =
            $('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': link.data('token')
            });

            var hiddenInput =
            $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': link.data('method')
            });

            return form.append(token, hiddenInput)
            .appendTo('body');
        }
    };

    laravel.initialize();

})();
