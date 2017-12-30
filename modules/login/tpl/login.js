jsux.fn = jsux.fn || {};
jsux.fn.login = {

  checkForm: function( f ) {

    var userId = f.user_id,
          pwd = f.password;

    if ( userId.value.length < 1) {
      trace('아이디를 입력하세요.');
      userId.focus();
      return false;       
    }

    if ( pwd.value.length < 1) {
      trace('비밀번호를 입력하세요.');
      pwd.focus();
      return false;       
    }
    return true;
  },
  sendJson: function(f) {

    var params = '',
      url = '';
      
    params = {
      _method: f._method.value,
      user_id: f.user_id.value,
      password: f.password.value
    };
    
    if (!f.action) {
      alert('Not Exists URL');
    }
    url = f.action;

    jsux.getJSON( url, params, function( e ) {
      
      if (e.result.toLowerCase() == 'y') {
        jsux.goURL(jsux.rootPath + 'login');
      } else {
        jsux.goURL(jsux.rootPath + 'login-fail');
      }
    });
  },
  setEvent: function() {

    var self = this;
    $('form[name=f_login]').submit( function(e) {       
      e.preventDefault();      

      if (self.checkForm(this)) {
        self.sendJson(this);
      }
    });
  },
  init: function() {
    this.setEvent();
    jsux.setAutoFocus();
  }
};

jsux.fn.leave = {

  checkForm: function( f ) {

    var pwd = f.password.value.length;
    if ( pwd < 1) {
      trace('비밀번호를 입력하세요.');
      f.password.focus();
      return false;       
    }
    return true;
  },
  resetForm: function( f ) {

    var pwd = f.password;
    pwd.value = '';
    pwd.focus();
  },
  sendJson: function( f ) {

    var self = this,
      params = '',
      url = '';

    params = {
      _method: f._method.value,
      category: f.category.value,
      user_id: f.user_id.value,
      password: f.password.value
    };

    if (!f.action) {
      alert('Not Exists URL');
    }
    url = f.action;

    var logoutHandler = function( url ) {

      params._method = 'insert';
      jsux.getJSON( url, params, function( e ) {
        
        if (e.result.toUpperCase() === 'Y') {
          jsux.goURL(jsux.rootPath + 'login');
        }
      });
    };

    jsux.getJSON( url, params, function( e ) {

      trace( e.msg );
      if (e.result.toUpperCase() === 'Y') {
        logoutHandler(jsux.rootPath + 'logout');
      } else {
        self.resetForm(f);
      }
    });   
  },
  setEvent: function() {

    var self = this;
    $('form[name=f_loginleave]').on('submit',function(e) {
      e.preventDefault();

      if (self.checkForm(this)) {
        self.sendJson(this);        
      } 
    });
  },
  init: function() {
    this.setEvent();
    jsux.setAutoFocus();
  }
};
jsux.fn.searchResult = {

  init: function() {}
};

jsux.fn.searchId = {

  validateEmail: function(id) {

    var value = $('input:text[name='+id+']').val();
    var reg = /^([a-zA-Z0-9_+.-])+@([a-zA-Z0-9_-])+(\.[a-z0-9_-]+){1,2}$/;
    if (reg.test(value)) {
      return true;
    }
    return false;
  },
  checkForm: function( f ) {

    var userName = f.user_name,
      email = f.email_address;

    if ( userName.value.length < 1) {
      trace('이름을 입력하세요.');
      userName.focus();
      return false;       
    }

    if ( email.value.length < 1) {
      trace('이메일 주소를 입력하세요.');
      email.focus();
      return false;       
    }

    if (!this.validateEmail('email_address')) {
      trace('이메일이 올바르지 않습니다.');
      email.focus();
      return false;       
    }
    return true;
  },
  sendJson: function(f) {

    var params = '',
          url = '';
      
    params = {
      _method: f._method.value,
      user_name: f.user_name.value,
      email_address: f.email_address.value
    };
    
    if (!f.action) {
      alert('Not Exists URL');
    }
    url = f.action;

    jsux.getJSON( url, params, function( e ) {
      
      jsux.goURL(jsux.rootPath + 'search-id');
    });
  },
  setEvent: function() {

    var self = this;

    $('form[name=f_searchid]').on('submit',function(e) {
      
      if (!self.checkForm(this)) {
        e.preventDefault();
      } 
    });
  },
  init: function() {
    this.setEvent();
    jsux.setAutoFocus();
  }
};
jsux.fn.searchPassword = {

  validateEmail: function(id) {

    var value = $('input:text[name='+id+']').val();
    var reg = /^([a-zA-Z0-9_+.-])+@([a-zA-Z0-9_-])+(\.[a-z0-9_-]+){1,2}$/;
    if (reg.test(value)) {
      return true;
    }
    return false;
  },
  checkForm: function( f ) {

    var userName = f.user_name,
          userId = f.user_id,
          email = f.email_address;

    if ( userName.value.length < 1) {
      trace('이름을 입력하세요.');
      userName.focus();
      return false;       
    }

    if ( userId.value.length < 1) {
      trace('아이디를 입력하세요.');
      userId.focus();
      return false;       
    }

    if ( email.value.length < 1) {
      trace('이메일을 입력하세요.');
      f.email_address.focus();
      return false;       
    }

     if (!this.validateEmail('email_address')) {
        trace('이메일이 올바르지 않습니다.');
        email.focus();
        return false;       
      }

      return true;
  },
  setEvent: function() {

    var self = this;

    $('form[name=f_searchpwd]').on('submit',function(e) {
      
      if (!self.checkForm(this)) {
        e.preventDefault();
      } 
    });
  },
  init: function() {
    this.setEvent();
    jsux.setAutoFocus();
  }
};
