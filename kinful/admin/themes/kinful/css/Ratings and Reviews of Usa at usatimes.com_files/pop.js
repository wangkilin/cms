// pop.js

// utility to open a new window for the widget
function launch_widget(partner, entity_id, city, state, country, name) {
	try{
		var new_url			= "http://www.openlist.com/widget?partner=" + escape(partner) + "&entity_id=" + entity_id + "&city=" + escape(city) + "&state=" + escape(state) + "&country=" + escape(country) + "&name=" + escape(name);
		window.open( new_url, 'widget', 'toolbar=no,width=210,height=450,status=no,scrollbars=no,menubar=no,resizable=yes,alwaysRaised=yes,screenX=0,screenY=0' );
	}catch(e){}
	return false;
}