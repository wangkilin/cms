// baseModuleToBeRequiredObject.js
function BaseSingleObject() {
	this.name = 'BaseSingleObject';
	
	this.setName = function (name) {
		this.name = name;
	};
	
	this.getName = function () {
		return this.name;
	};
};
function BaseSingleObject2() {
	this.name = 'BaseSingleObject2';
	
	this.setName = function (name) {
		this.name = name;
	};
	
	this.getName = function () {
		return this.name;
	};
};

exports.BaseSingleObject = BaseSingleObject;
exports.BaseSingleObject2 = BaseSingleObject2;