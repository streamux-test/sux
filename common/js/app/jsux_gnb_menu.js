/**
 * class gnb
 * update 2017.10.26
 * author streamux.com
 * description 'span 제거' 
 */
jsux.gnb = jsux.gnb || {};
jsux.gnb.Menu = jsux.View.create();
(function( app, $ ){

  var GNB = function( p, m ) {

    var _scope = this,
      _stage = $(p),     
      _data = null,
      _list = [],
      _m = m,
      _mid = -1,
      _sid = -1,
      _oldMid = -1,
      _oldSid = -1,
      _activateMid = -1,
      _activateSid = -1,
      _timer = -1,
      _activate = 'active';

    this.update = function( o,  value ) {

      _data = value;
      
      this.setUI();       
      this.setEvent();
    };

    this.setActivateClass = function( className) {

      _activate = className;
    };

    this.setUI = function() {

      var ty = 0;
      var markup = $('#gnbFirstMenu').html();
      var subMarkup = $('#gnbSecondMenu').html();

      $( _data ).each(function(mindex) {

        ty = (_data[mindex].menu !== undefined) ? -1*_data[mindex].menu.length * 35 : 0;
      
        _stage.append(markup);
        var menu = _stage.find('.sx-mmenu:eq('+mindex+') > li');
        menu.attr('data-mid', mindex);
        menu.attr('data-sid', -1);

        var menu_a =  menu.find('> a');
        menu_a.attr('href', _data[mindex].link);
        menu_a.text(_data[mindex].label);

        var sub_panel = menu.find('.sx-gnb-sub > .panel');
        sub_panel.attr('data-startPosY', ty+'px');
        sub_panel.css('top', ty+'px');
      });

      this.alignUI();

      $( _data ).each(function(mindex) {

        $( _data[mindex].menu ).each(function(sindex) {           
          _stage.find('.sx-mmenu:eq('+mindex+') .sx-gnb-sub > ul').append(subMarkup);

          var subMenu = _stage.find('.sx-mmenu:eq('+mindex+') .sx-gnb-sub > ul > li:eq('+sindex+')');
          subMenu.attr('data-mid', mindex);
          subMenu.attr('data-sid', sindex);
          subMenu.find('> a').attr('href', _data[mindex].menu[sindex].link);
          subMenu.find('> a').text(_data[mindex].menu[sindex].label);
        });
      });
    };

    this.alignUI = function() {

      var max_width = _stage.width(),
            max_txtWidth = 0,
            spaceWidth = 0,
            wdRate = 0,
            wd = 0,
            wd_lastChild = 0,
            sizeList = [];

      _list = _stage.find(".sx-mmenu");

      $( _list ).each(function(mindex){
        max_txtWidth += $(this).find("li > a").width();
      });

      spaceWidth = Math.floor((max_width - max_txtWidth)/_data.length);

      $( _list ).each(function(mindex) {

        wdRate = Math.floor((100-0)/(max_width - 0)*(($(this).find("li > a").width()+spaceWidth) - 0) + 0);  

        // 마지막은 항상 나머지 비율로 100%를 채운다.
        if (mindex == _list.length-1) {
          wdRate = 100-wd;
        }
        wd += wdRate;       
        $( this ).css("width", wdRate+"%");

        sizeList.push(wdRate);  
      });

      _m.setSizeList( sizeList );
    };

    this.setEvent = function() {

      _stage.find('.sx-mmenu > li > a').on('mouseover', function(e){

        e.preventDefault();
        _scope.stopTimer();

        var mid = $( this ).parent().attr('data-mid');
        _m.menuOn( mid, -1 ); 
      });

      _stage.find('.sx-mmenu > li > a').on('mouseout', function(e){

        e.preventDefault();
        _scope.startTimer();
        
      });

      _stage.find('.sx-mmenu > li > a').on('click', function(e){

        e.preventDefault();

        var mid = $( this ).parent().attr('data-mid');
        var url = _data[mid].link;
        if (url === '') {
          return;
        }
        jsux.goURL( jsux.rootPath + url, '_self' ); 
      });

      _stage.find('.sx-smenu > a').on('mouseover', function(e){

        e.preventDefault();
        _scope.stopTimer();

        var mid = $( this ).parent().attr('data-mid');
        var sid = $( this ).parent().attr('data-sid');
        _m.menuOn( mid,  sid);
        
      });

      _stage.find('.sx-smenu > a').on('mouseout', function(e){

        e.preventDefault();
        _scope.startTimer();        
      });

      _stage.find('.sx-smenu > a').on('click', function(e){

        e.preventDefault();

        var mid = $( this ).parent().attr('data-mid');
        var sid = $( this ).parent().attr('data-sid');
        var url = _data[mid].menu[sid].link;

        jsux.goURL( jsux.rootPath + url, '_self' );       
      });
    };

    this.mouseHandler = function(e, obj) {
      
      var type = e.type,
            menu  = null,
            menu_a = null,
            oldmenu_a = null,
            submenu = null,
            submenu_a = null,
            old_smenu_a = null,
            mask = null,
            panel = null,
            ty = 0,
            th = 0,
            oldMask = null,
            oldPanel = null,
            oldth = 0,
            oldty = 0;

      _mid  = obj.mid;
      _sid  = obj.sid;

      switch(type) {

        case 'mouseover' :          

          if (_mid > -1) {
            menu   = _list.eq(_mid);
            menu_a = menu.find('> li > a');
            if (!menu_a.hasClass(_activate)) {

              mask = menu.find('.sx-gnb-sub');
              panel = menu.find('.sx-gnb-sub .panel');
              ty = 0;
              th = _list.eq(_mid).find('.sx-gnb-sub .panel').attr('data-startPosY').replace(/[^(0-9)]/gi, '');

              menu_a.addClass(_activate);

              _scope.tween( panel, 10, {'top': ty, ease: Linear.easeOutQuad, useFrames: true, onUpdate: function() {

                var mh = th - panel.css('top').replace(/[^(0-9)]/gi, '');
                mask.css('height', mh);
              }});
            } 
          }
          
          if (_sid > -1) {
            submenu  = _list.eq(_mid).find('.sx-gnb-sub .sx-smenu').eq(_sid);         
            submenu_a = submenu.find('> li > a');

            if (!submenu_a.hasClass(_activate)) {
              submenu_a = submenu.find('> li > a');
            }
            submenu_a.addClass(_activate);
          }

          if (_oldMid != _mid && _oldMid > -1) {

            oldmenu_a = _list.eq(_oldMid).find('> li > a');

            oldMask = _list.eq(_oldMid).find('.sx-gnb-sub');
            oldPanel  = oldMask.find('> .panel');
            oldty = oldPanel.attr('data-startPosY');
            oldth = oldPanel.attr('data-startPosY').replace(/[^(0-9)]/gi, '');

            oldmenu_a.removeClass(_activate);

            _scope.tween( oldPanel, 10, {'top': oldty, ease: Linear.easeOutQuad, useFrames: true, onUpdate: function() {
              
              var mh = oldth - oldPanel.css('top').replace(/[^(0-9)]/gi, '');
              oldMask.css('height', mh);
            }});
          }

          if (_oldSid != _sid && _oldSid > -1) {
            old_smenu_a = _list.eq(_oldMid).find('.sx-gnb-sub .sx-smenu').eq(_oldSid).find('> li > a');
            old_smenu_a.removeClass(_activate);
          }         

          _oldMid = _mid;
          _oldSid   = _sid;
          break;

        case 'mouseout':

          if (_mid > -1) {
            menu = _list.eq(_mid);
            menu_a = menu.find('> li > a');
            if (menu && menu_a.hasClass(_activate)) {

              panel   = menu.find('.sx-gnb-sub .panel');
              ty    = menu.find('.sx-gnb-sub .panel').attr('data-startPosY');
              oldth = _list.eq(_mid).find('.sx-gnb-sub .panel').attr('data-startPosY').replace(/[^(0-9)]/gi, '');

              menu_a.removeClass(_activate);
              _scope.tween( panel, 10, {'top': ty, ease: Linear.easeOutQuad, useFrames: true, onUpdate: function() {
              
                var mh = oldth - $( panel ).css('top').replace(/[^(0-9)]/gi, '');
                menu.find('.sx-gnb-sub').css('height', mh);
              }});
            }
          }

          if (_sid > -1) {
            submenu  = menu.find('.sx-gnb-sub .sx-smenu').eq(_sid);
            submenu_a = submenu.find('> li >a');
            if (submenu && submenu_a.hasClass(_activate)) {
              submenu_a.removeClass(_activate);
            }
          }
          break;

        default:
          break;
      }
    };

    this.activate = function(m, s) {

      _activateMid  = parseInt(m, 10);
      _activateSid  = parseInt(s, 10);

      if (_activateMid <=0 && _activateMid > _data.length) {
        warn('It not a Avaliable Depth1\'s Number!');
        return;
      } 

      if (_activateSid <= 0 && _activateSid > _data[mid].menu.length) {
        warn('It not a Avaliable Depth2\'s Number!');
        return;
      }

      _activateMid  = _activateMid - 1;
      _activateSid    =  _activateSid - 1;

      this.menuOn( _activateMid, _activateSid);
    };

    this.menuOn = function(m, s) {

      _scope.mouseHandler({type:'mouseover'}, {mid: m, sid: s});
    };

    this.menuOff = function() {

      _scope.mouseHandler({type:'mouseout'}, {mid: _mid, sid: _sid});
    };

    this.tween = function( target, time, obj) {

      TweenLite.to( target, time, obj);
    };

    this.startTimer = function() {

      if (_timer == -1) {
        _timer = setInterval(function(){

          if (_activateMid > -1) {
            _m.menuOn(_activateMid, _activateSid);
          } else {
            _m.menuOff();
          }
          _scope.stopTimer();

        }, 500);
      }
    };

    this.stopTimer = function() {

      if (_timer) {
        clearInterval(_timer);
        _timer = -1;
      }
    };

    this.replaceNumber = function( str ) {

      return str.replace(/[^(0-9)]/gi, '');
    };
  };

  app.create = function( path, m ) {

    if ($(path).length<1) {
      $( document.body ).append('<div id="TEMP_GNB_CASE" class="sx-gnb"></div>');
      path = '#TEMP_GNB_CASE';
    }
    return new GNB(path, m);
  };
})(jsux.gnb.Menu, jQuery);