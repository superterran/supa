var supa;
supa = Class.create({


    panelIdle: true,

    initialize: function () {

        this.MessagesObserver();
        this.panelObserver();


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
                            this.panelIdle = false;
                            Effect.SlideUp(doto, { afterFinish: function() { doto.innerHTML = response.responseText; Effect.SlideDown.delay(.5, (doto)); this.panelIdle = true}.bind(this)});
                            return;
                        } else {

                            doto.innerHTML = response.responseText;
                            this.panelIdle = false;
                            Effect.SlideDown(doto);
                            this.panelIdle = true;
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

        }.bind(this));
    },

    close: function(doto)
    {

        this.panelIdle = false;
        Effect.BlindUp(doto, {afterFinish: function() {doto.innerHTML = ''; this.panelIdle = true }.bind(this)});
    },

    panelClose: function()
    {
        this.close($('panel_modal_container'));
    },

    move: function(doto, x, y) {

        if(this.panelIdle) {
            this.panelIdle = false;
            new Effect.Move(doto, { x: x, y: y, mode: 'absolute', afterFinish: function() { this.panelIdle = true }.bind(this) });
        }

    },

    panelHide: function()
    {
        this.move('panel', 0, -30);
    },

    panelShow: function()
    {
         this.move('panel', 0, 0);
    },

    panelObserver: function()
    {

        $('panel-sensor').observe('mouseout', function(e) {

            if(this.panelIdle) {

                console.log($('panel_modal_container').style.display);
                if($('panel_modal_container').style.display == 'none') {
                    this.panelHide();
                }

            }

        }.bind(this));

        $('panel-sensor').observe('mouseover', function(e) {
            if(this.panelIdle) {
                    this.panelShow();
            }
        }.bind(this));


//        $('panel').observe('mousemove', function(e) {
//            this.panelShow();
//        }.bind(this));


        new PeriodicalExecuter(function(pe) {

            if ($('panel_modal_container').style.display == 'none') {
//                alert('here');
                if(this.panelIdle) {
                    this.panelHide();
                }
            }
        }.bind(this), 5);

    }



});