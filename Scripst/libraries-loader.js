// Se carga jQuery (necesario para los complementos de JavaScript de Bootstrap)
var scriptJQuery = document.createElement('script');
scriptJQuery.src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js';
document.head.appendChild(scriptJQuery);

// Se carga Bootstrap JavaScript (compilado y minificado)
var scriptBootstrap = document.createElement('script');
scriptBootstrap.src = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js';
scriptBootstrap.integrity = 'sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS';
scriptBootstrap.crossOrigin = 'anonymous';
document.head.appendChild(scriptBootstrap);