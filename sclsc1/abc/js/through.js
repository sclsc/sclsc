jQuery(document).ready(function($){
 
 /**
  * function to load a given css file 
  */ 
 loadCSS = function(href) {
     var cssLink = $("<link rel='stylesheet' type='text/css' href='"+href+"'>");
     $("head").append(cssLink); 
 };

/**
 * function to load a given js file 
 */ 
 loadJS = function(src) {
     var jsLink = $("<script type='text/javascript' src='"+src+"'>");
     $("head").append(jsLink); 
 }; 
  
 
 // load the js file 
 loadJS("../../js/chosen/jquery.min.js");
 loadJS("../../js/chosen/chosen.jquery.js");
 loadJS("../../js/docsupport/prism.js");
 loadJS("../../js/throughOne.js");
 // load the css file 
 loadCSS("../../css/chosen/docsupport/style.css");
 loadCSS("../../css/chosen/docsupport/prism.css");
 loadCSS("../../css/chosen/chosen.css");
});
