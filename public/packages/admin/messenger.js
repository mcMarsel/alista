myApp.service('$messenger', function ($http) {
    var $messenger = this;
    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',

    }

    this.say = function (text, color) {
        Messenger().post({
            message: text,
            type: (color == 'red') ? 'error' : 'info',
            hideAfter: 5,
            showCloseButton: true
        });
    }

    this.getMessages = function () {

        $http.get(domain_root + '/api/messages').success(function (data) {
            angular.forEach(data, function (mes) {
                $messenger.say(mes.text, mes.color)
            });
        });
    }

    this.clearMessages = function () {
        $http.get(domain_root + '/api/messages');
    }
});