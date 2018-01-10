jsux.mobileGnb = jsux.mobileGnb || {};
jsux.mobileGnb.Menu = jsux.View.create();
jsux.mobileGnb.Menu.include({

  _path: '',
  _m: '',
  _isClick: false,
  _data: null,
  _startPosX: "100%",
  _targetPosX: 52,
  _isMobile: false,
  _isPc: false,

  addClass: function(parent, target) {

    if (!$(parent).hasClass(target)) {
      $(parent).addClass(target);
    }
  },
  removeClass: function(parent, target) {

    if ($(parent).hasClass(target)) {
      $(parent).removeClass(target);
    }
  },
  update: function(o, value) {

    this._data = value;

    this.defaultSetting();
    this.setUI();
    this.setEvent();
  },
  resetUI: function() {

  },
  defaultSetting: function() {

    this._path = jsux.mobileGnb.Menu.path;
    this._m = jsux.mobileGnb.Menu.m;
  },
  setUI: function() {

    var self = this,
          markup = '',
          menu$ = null,
          subMenu = null,
          menu_stage = null,
          depth = 0;

    markup = $('#gnbMenuItem').html();
    menu_stage = $(this._path).empty();

    var menuManager = (function f(target, data) {

      var menu$ = null;

      $(data).each( function( index ){

        menu$ = $(markup).appendTo(target);
        menu$.attr('data-id', index);
        menu$.attr('data-depth', depth);

        var menu_a$ =  menu$.find('> a');
        menu_a$.attr('href', data[index].link);
        menu_a$.text(data[index].label);

        data[index].depth = depth;
        data[index].target = target;
      }); // end of each

      for (var i=0; i<data.length; i++) {

        if (data[i].menu && data[i].menu.length > 0) {
          depth = data[i].depth + 1;
          target = data[i].target + '> li:eq('+ i + ') > .sub_mask > ul';
          arguments.callee(target, data[i].menu);
        }
      } //end of for 


    });
    menuManager(this._path, this._data);
    menuManager = null;
  },
  setEvent: function() {

    var self = this;

    $('.mobile-menu-btn').on('mouseover', function(e) {
      self.addClass('.mobile-menu-bg', 'menu-bg-activate');   
    });

    $('.mobile-menu-btn').on('mouseout', function(e) {      
      self.removeClass('.mobile-menu-bg', 'menu-bg-activate');   
    });

    $('.mobile-menu-btn').on('click', function(e) {

      self.show();
      self.openSlide();
      self.hideMobileMenu();

      self._isClick = true;
    });

    $('.mobile-gnb-case').on('click', function(e) {

      var url = $(e.target).attr('href'),
        target = $(e.target).attr('target');

      if (!url) {
         url = $(e.target).parent().attr('href');
         target = $(e.target).parent().attr('target');
      }

      if (url) {      
        self.click(url, target);
      }     
    });

    $('.menu-btn-close').on('click', function(e) {

      self.closeSlide();
      self._isClick = false;  
    });
    
    $('.sx-bgcover').on('click', function(e) {

      self.closeSlide();
      self._isClick = false;  
    });

    $(window).on('resize', function(e){

      var tw = $(window).outerWidth();
      if (tw < 768 && self._isMobile === false) {

        self._isMobile = true;
        self._isPc = false;

        if (self._isClick === true) {
          self.show();
        }
      } else if (tw >= 768 && self._isPc === false) {

        self._isMobile = false;
        self._isPc = true;

        self.hide();
        self._m.resetUI();
      }

      self._startPosX  = tw;
    });

    $(window).trigger('resize');
    this.tween('.mobile-gnb-case', 1, {x:this._startPosX, useFrames:true});
  },
  tween: function( target, time, op ) {
    TweenMax.to(target, time, op);
  },
  killTween: function( target ) {
    TweenMax.killTweensOf( target );
  },
  showCloseX: function() {

    this.killTween('.menu-btn-close');
    this.killTween('.menu-btn-close .sx-h-3stick');
    this.tween('.menu-btn-close', 1, {opacity:0, useFrames:true});
    this.tween('.menu-btn-close', 13, {opacity:1, ease: Expo.easeOut, useFrames:true});
    this.tween('.menu-btn-close .sx-h-3stick', 65, {rotation:360, useFrames:true});
  },
  hideCloseX: function() {

    var self = this;
    this.killTween('.menu-btn-close');
    this.killTween('.menu-btn-close .sx-h-3stick');
    this.tween('.menu-btn-close', 13, {opacity:0, useFrames:true, onComplete: $.proxy(self.showMobileMenu, self)});
    this.tween('.menu-btn-close .sx-h-3stick', 65, {rotation:0, useFrames:true});
  },
  showMobileMenu: function() {

    var self = this;

    this.killTween('.mobile-menu-btn .sx-h-3stick');
    $('.mobile-menu-btn .sx-h-3stick').find('> li').each(function(index) {
      self.tween(this, 21, {opacity:1, useFrames:true});
    });

    this.tween('.mobile-menu-btn .sx-h-3stick .sx-hline1', 21, {y:0, useFrames:true});
    this.tween('.mobile-menu-btn .sx-h-3stick .sx-hline3', 21, {y:0, useFrames:true}); 
  },
  hideMobileMenu: function() {

    var self = this;
    this.killTween('.mobile-menu-btn .sx-h-3stick');
    $('.mobile-menu-btn .sx-h-3stick').find('> li').each(function(index) {
      self.tween(this, 21, {opacity:0, useFrames:true});
    });
  },  
  openSlide: function() {

    self = this;
    $('.mobile-gnb-case').css({'transform':'translateX('+this._startPosX+'px)'});

    $('#test_startPosX').val(this._startPosX);

    this.killTween('.mobile-gnb-case');
    this.killTween('.mobile-menu-btn .sx-h-3stick .sx-hline1');
    this.killTween('.mobile-menu-btn .sx-h-3stick .sx-hline3');
    this.tween('.mobile-gnb-case', 17, {x:this._targetPosX, useFrames:true,onComplete: $.proxy(self.showCloseX, self)});
    this.tween('.mobile-menu-btn .sx-h-3stick .sx-hline1', 12, {y:6, useFrames:true});
    this.tween('.mobile-menu-btn .sx-h-3stick .sx-hline3', 12, {y:-6, useFrames:true});
  },
  closeSlide: function() {

    var self = this;

    this.killTween('.mobile-gnb-case');
    this.killTween('.mobile-menu-btn .sx-h-3stick .sx-hline1');
    this.killTween('.mobile-menu-btn .sx-h-3stick .sx-hline3');
    this.tween('.mobile-gnb-case', 17, {x:this._startPosX, useFrames:true, onComplete: $.proxy(self.hide, self)});    

    this.hideCloseX();  
  },
  show: function() {

    this.addClass('.sx-bgcover', 'sx-bgcover-active');
    this.addClass('.mobile-gnb-case', 'mobile-gnb-case-active');
    this.addClass('html', 'sx-hide-scroll');
    this.addClass('.wrapper', 'wrapper-reposition');
  },
  hide: function() {  

    this.removeClass('.sx-bgcover', 'sx-bgcover-active');
    this.removeClass('.mobile-gnb-case', 'mobile-gnb-case-active');
    this.removeClass('html', 'sx-hide-scroll');
    this.removeClass('.wrapper', 'wrapper-reposition');
  },
  showSitemap: function() {

    $('.mobile-menu-btn').trigger('click');
  },
  click: function( url, target) {

    //console.log( 'url : %s / target : %s', url, target);
    if (!(url === '#none' || url === '' || url === undefined)){
      jsux.goURL(url, target);
    }
  },
  menuOn: function() {

  },
  menuOff: function() {

  }
});

jsux.mobileGnb.Menu.extend({

  create: function( path, m) {

    if ($(path).length<1) {

      var markup = '<ul id="mobileGnb" class="sx-menu-panel"></ul>';
      $( document.body ).append( markup );
      this.path = '#mobileGnb';
    } else {
      this.path = path;     
    }
    this.m = m;

    return new jsux.mobileGnb.Menu();
  }
});