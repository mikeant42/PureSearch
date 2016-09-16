var _terms = ['define', 'wiki', 'calculator', 'movie', 'calculate', 'alternatives to']; 
// YOUR SEARCH TERMS GO HERE //

    function preg_quote( str ) {
        return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
    }

function doit() {
	var s = processTweetLinks(processIPAddresses(document.getElementById('search').value));
	
	for (i=0; i<_terms.length; i++)
		s = s.replace( new RegExp( preg_quote( _terms[i] ), 'g' ), '<a href="docs/search-syntax#' + _terms[i] + '" class="doc-link">' + _terms[i] + '</a>' );
		document.getElementById('myOtherTextarea').innerHTML = s.replace( new RegExp( preg_quote( '\r' ), 'gi' ), '<br>' );
	}
	
clicker = document.getElementById('myOtherTextarea');

clicker.addEventListener('click', function() {
  document.getElementById('search').focus();
  click++;
}, false);


function stripHTML(html) {
    return html.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>?/gi, '');
}

function processTweetLinks(text) {
    exp = /(^|\s)#(\w+)/g;
    text = text.replace(exp, "$1<a href='https://twitter.com/search?q=%23$2&target=hash' target='_blank' class='doc-link'>#$2</a>");
    exp = /(^|\s)@(\w+)/g;
    text = text.replace(exp, "$1<a href='http://www.twitter.com/$2' target='_blank' class='doc-link'>@$2</a>");
    return text;
}

function processIPAddresses(text) {
	var exp = /^(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))$/;
    text = text.replace(exp, "<a href='http://ipinfo.io/$1.$3.$5.$7' target='_blank' class='doc-link'>$1.$3.$5.$7</a>");
    return text;
}