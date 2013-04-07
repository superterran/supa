var supa;
supa = Class.create({

    updateInterval: 5,

    sites_lastChange: null,
    pile_lastChange: null,

    initialize: function () {

//        var sites = this.doAction('lastChange', {'part':'sites'});
//        this.sites_lastChange = sites;
//
//        var pile = this.doAction('lastChange', {'part':'pile'});
//        this.pile_lastChange = pile;

        this.MessagesObserver();

    },

    doModal: function(action, params, doto) {

        console.log(action, params);

        doto.removeClassName('success');
        doto.removeClassName('error');
        doto.removeClassName('problem');

        var url = '?do=' + action;

        new Ajax.Request(url, {
            method: 'get',
            asynchronous:false,
            parameters: params,
            onComplete: function (response) {

                if (400 === response.status) {
                    doto.addClassName('error');
                    return;
                }

                if (200 === response.status) {
                    doto.fade();
                    this.reload('list', 'list_container').bind(this);
                    this.reload('sites', 'sites_container').bind(this);
                    return;
                }

                doto.addClassName('problem');
            }.bind(this)
        });

    },

    doAction: function (action, params, doto) {

        if(doto) {
            doto.removeClassName('success');
            doto.removeClassName('error');
            doto.removeClassName('problem');
        }

        var url = '?do=' + action;

        var responseText;

        new Ajax.Request(url, {
            method: 'get',
            asynchronous:false,
            parameters: params,
            onComplete: function (response) {
                if (400 === response.status) {
                    if(doto) {
                        doto.addClassName('error');
                    } else {
                        doto = false;
                    }
                    return;
                }

                if (200 === response.status) {
                    if(doto) {
                        doto.addClassName('success');
                    } else {
                        responseText = (response.responseText);
                    }
                    return;
                }

                if(doto) doto.addClassName('problem');
            }
        });

        return responseText;
    },

    reload: function(phtml, container) {

        var url = '?phtml='+phtml;

        new Ajax.Request(url, {
            method: 'get',
            onComplete: function (response) {
                $(container).update(response.responseText);
                this.stateObserver(); //@todo needs to be moved
            }.bind(this)
        });

    },

    MessagesObserver: function () {

        $$('#messages li').each(function (e) {
            Effect.BlindUp.delay(5, 'messages', { duration: 1.0 });
//            e.dropOut({ duration: 6.0}).delay(5);
        }.bind(this));
    }

});