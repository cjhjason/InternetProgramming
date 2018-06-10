var domTree = "";
var indent = "";

// Define the main processing function
var addNode = function (node) {
    domTree += indent + node.tagName.toLowerCase();
    if (node.hasAttributes()) {
        domTree += " (";
        for ( var i = 0; i < node.attributes.length; i++) {
            domTree += node.attributes[i].name + "=\"";
            domTree += node.attributes[i].value + "\"";
            if ( i < node.attributes.length - 1) {
                domTree += " ";
            }
        }
        domTree += ")";
    }
    domTree += "\n";
}

// Define the preprocessing function
var moreIndent = function () { 
    indent += "    "; 
}

// Define the postprocessing function
var lessIndent = function () {
    // cuts 4 spaces off indent if it is > 4
	if (indent.length >= 4) indent = indent.slice(0,-4); 
}

// Define a function that calls the walk method
function init() {

var showDomTree = function () {
    jsLib.dom.walk(addNode, moreIndent, lessIndent);
    alert(domTree);
	};
	
document.addEventListener("click",showDomTree,false);
}

// Call the showDomTree function
//jsLib.dom.ready( showDomTree );

window.addEventListener( "load", init(), false );
