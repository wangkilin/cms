/**
 * $Rev: 1671 $
 * $LastChangedDate: 2010-03-16 18:15:04 +0800 (星期二, 2010-03-16) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    js
 * @copyright  Copyright (c) 2008 Martin Laine
 * @author     http://www.1pixelout.net
 * @version    $Id: 1pixelout-player.js 1671 2010-03-16 10:15:04Z junzhang $
 */

/**
 * Flash Audio Player, version 2.0
 */
var AudioPlayer = function () {
	var instances = [];
	var activePlayerID;
	var playerURL = "";
	var defaultOptions = {};
	var currentVolume = -1;

	function getPlayer(playerID) {
		if (document.all && !window[playerID]) {
			for (var i = 0; i < document.forms.length; i++) {
				if (document.forms[i][playerID]) {
					return document.forms[i][playerID];
					break;
				}
			}
		}
		return document.all ? window[playerID] : document[playerID];
	}

	function addListener (playerID, type, func) {
		getPlayer(playerID).addListener(type, func);
	}

	return {
		setup: function (url, options) {
			playerURL = url;
			defaultOptions = options;
		},

		getPlayer: function (playerID) {
			return getPlayer(playerID);
		},

		addListener: function (playerID, type, func) {
			addListener(playerID, type, func);
		},

		embed: function (elementID, options) {
			var instanceOptions = {};
			var key;
			var so;
			var bgcolor;
			var wmode;

			var flashParams = {};
			var flashVars = {};
			var flashAttributes = {};

			// Merge default options and instance options
			for (key in defaultOptions) {
				instanceOptions[key] = defaultOptions[key];
			}
			for (key in options) {
				instanceOptions[key] = options[key];
			}

			if (instanceOptions.transparentpagebg == "yes") {
				flashParams.bgcolor = "#FFFFFF";
				flashParams.wmode = "transparent";
			} else {
				if (instanceOptions.pagebg) {
					flashParams.bgcolor = "#" + instanceOptions.pagebg;
				}
				flashParams.wmode = "opaque";
			}

			flashParams.menu = "false";

			for (key in instanceOptions) {
				if (key == "pagebg" || key == "width" || key == "transparentpagebg") {
					continue;
				}
				flashVars[key] = instanceOptions[key];
			}

			flashAttributes.name = elementID;
			flashAttributes.style = "outline: none";

			flashVars.playerID = elementID;

			//swfobject.embedSWF(playerURL, elementID, instanceOptions.width.toString(), "24", "9", false, flashVars, flashParams, flashAttributes);
			//replaced with jquery-swfobject.js by James ZHANG
			flashVars['playerID'] = elementID + '_player';
			$('#' + elementID).flash({
			    swf: playerURL,
			    id: flashVars['playerID'],
			    width: instanceOptions.width.toString(),
			    height: '24',
			    style: 'outline: none',
			    flashvars: flashVars,
			    params: flashParams
			});

			instances.push(elementID);
		},

		syncVolumes: function (playerID, volume) {
			currentVolume = volume;
			for (var i = 0; i < instances.length; i++) {
				if (instances[i] != playerID) {
					getPlayer(instances[i]).setVolume(currentVolume);
				}
			}
		},

		activate: function (playerID, info) {
			if (activePlayerID && activePlayerID != playerID) {
				getPlayer(activePlayerID).close();
			}

			activePlayerID = playerID;
		},

		load: function (playerID, soundFile, titles, artists) {
			getPlayer(playerID).load(soundFile, titles, artists);
		},

		close: function (playerID) {
			getPlayer(playerID).close();
			if (playerID == activePlayerID) {
				activePlayerID = null;
			}
		},

		open: function (playerID, index) {
			if (index == undefined) {
				index = 1;
			}
			getPlayer(playerID).open(index == undefined ? 0 : index-1);
		},

		getVolume: function (playerID) {
			return currentVolume;
		}

	}

}();

/* EOF */