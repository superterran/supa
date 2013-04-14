var supa;
supa = Class.create({

    updateInterval: 5,

    sites_lastChange: null,
    pile_lastChange: null,

    initialize: function () {

        this.MessagesObserver();
        Effect.Appear($('panel'));

    },

    doAction: function(todo, params, doto) {

        console.log(todo, params);

        doto.removeClassName('success');
        doto.removeClassName('error');
        doto.removeClassName('problem');

        var url = '/';


        var payload = { 'do' : todo, 'params' : JSON.stringify(params) }

        console.log(payload);

        new Ajax.Request(url, {
            method: 'post',
            asynchronous:false,
            parameters: payload,
            onComplete: function (response) {

                if (400 === response.status) {
                    doto.addClassName('error');
                    return;
                }

                if (200 === response.status) {
                    if(response.responseText) {

                        if(doto.innerHTML == "") doto.hide();
                        if(doto.style.display != "none")
                        {
                            Effect.SlideUp(doto, { afterFinish: function() { doto.innerHTML = response.responseText; Effect.SlideDown.delay(.5, (doto)); }});
                            return;
                        } else {
                            doto.innerHTML = response.responseText;
                            Effect.SlideDown(doto);
                            return;
                        }
                    }
                }

                doto.addClassName('problem');
            }.bind(this)
        });
    },

    MessagesObserver: function () {

        $$('#messages li').each(function (e) {
            Effect.BlindUp.delay(5, 'messages', { duration: 1.0 });
//            e.dropOut({ duration: 6.0}).delay(5);
        }.bind(this));
    },

    close: function(doto)
    {
        Effect.BlindUp(doto, {afterFinish: function() {doto.innerHTML = ''; }});
    },

    panelClose: function()
    {
        this.close($('panel_modal_container'));
    }


});