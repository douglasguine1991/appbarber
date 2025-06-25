// Evento para a instalação do sw colocando os arquivos em cache

self.addEventListener('install', function(event){
    event.waitUntil(
        caches.open('v1').then(function(cache){
 
            return cache.addAll([
 
                'index.php',
                '../app/view/template/head.php',
                '../app/view//login.php',
                'assets/css/style.css',
                'assets/img/logobarber.png',
                'assets/img/logobarber.png',
 
            ]);
        })
    );
});

//Requisição dos arquivos que estão e cache
self.addEventListener('fetch', function(event){

    event.respondwith(
        caches.match(event.request).then(function(response){
            return response || fetch(event.request);

        })
    );

});
 