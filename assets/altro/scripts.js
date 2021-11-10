/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


// DIV con la sidebar
var MenuSidebar = document.getElementById("Menu_Sidebar");

// DIV con l'overlay
var overlayBg = document.getElementById("Menu_Overlay");

// Mostra o nasconde la sidebar, con effetto slide
function menu_open() {
	if (MenuSidebar.style.display === 'block') {
		MenuSidebar.style.display = 'none';
		overlayBg.style.display = "none";
	} else {
		MenuSidebar.style.display = 'block';
		overlayBg.style.display = "block";
	}
}

// Chiude il menu premendo sul bottoncino
function menu_close() {
	MenuSidebar.style.display = "none";
	overlayBg.style.display = "none";
}
