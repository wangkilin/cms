// baseModuleToBeRequiredObject.js
function BaseSingleObject() {
	this.name = 'Default value';
	
	this.setName = function (name) {
		this.name = name;
	};
	
	this.getName = function () {
		return this.name;
	};
};

module.exports = BaseSingleObject;