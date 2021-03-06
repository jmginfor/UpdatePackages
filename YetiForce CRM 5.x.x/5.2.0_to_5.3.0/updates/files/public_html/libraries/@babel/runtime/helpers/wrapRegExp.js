var _typeof = require("../helpers/typeof");

var wrapNativeSuper = require("./wrapNativeSuper");

var getPrototypeOf = require("./getPrototypeOf");

var possibleConstructorReturn = require("./possibleConstructorReturn");

var inherits = require("./inherits");

function _wrapRegExp(re, groups) {
  module.exports = _wrapRegExp = function _wrapRegExp(re, groups) {
    return new BabelRegExp(re, groups);
  };

  var _RegExp = wrapNativeSuper(RegExp);

  var _super = RegExp.prototype;

  var _groups = new WeakMap();

  function BabelRegExp(re, groups) {
    var _this = _RegExp.call(this, re);

    _groups.set(_this, groups);

    return _this;
  }

  inherits(BabelRegExp, _RegExp);

  BabelRegExp.prototype.exec = function (str) {
    var result = _super.exec.call(this, str);

    if (result) result.groups = buildGroups(result, this);
    return result;
  };

  BabelRegExp.prototype[Symbol.replace] = function (str, substitution) {
    if (typeof substitution === "string") {
      var groups = _groups.get(this);

      return _super[Symbol.replace].call(this, str, substitution.replace(/\$<([^>]+)>/g, function (_, name) {
        return "$" + groups[name];
      }));
    } else if (typeof substitution === "function") {
      var _this = this;

      return _super[Symbol.replace].call(this, str, function () {
        var args = [];
        args.push.apply(args, arguments);

        if (_typeof(args[args.length - 1]) !== "object") {
          args.push(buildGroups(args, _this));
        }

        return substitution.apply(this, args);
      });
    } else {
      return _super[Symbol.replace].call(this, str, substitution);
    }
  };

  function buildGroups(result, re) {
    var g = _groups.get(re);

    return Object.keys(groups).reduce(function (groups, name) {
      groups[name] = result[g[name]];
      return groups;
    }, Object.create(null));
  }

  return _wrapRegExp.apply(this, arguments);
}

module.exports = _wrapRegExp;