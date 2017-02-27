<?php
    date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__.'/../src/stylist.php';
    require_once __DIR__.'/../src/client.php';

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function() use($app) {
        return $app['twig']->render('homepage.html.twig', ['stylists' => Stylist::getAll()]);
    });

    $app->get('/add_stylist', function() use ($app) {
        return $app['twig']->render('add_stylist.html.twig', ['stylists' => Stylist::getAll()]);
    });

    $app->get('/stylists', function() use ($app) {
        return $app['twig']->render('stylists.html.twig', ['stylists' => Stylist::getAll()]);
    });

    $app->get('/clients', function() use ($app) {
        return $app['twig']->render('clients.html.twig', ['stylists' => Stylist::getAll(), 'clients' => Client::getAll()]);
    });

    $app->post('/add_stylist', function() use($app) {
       $name = $_POST['name'];
       $bio = $_POST['bio'];
       $new_stylist = new Stylist($name, $bio);
       $new_stylist->save();
       return $app["twig"]->render("homepage.html.twig", ['stylists' => Stylist::getAll()]);
   });

   $app->get('/stylists/{id}', function($id) use($app)  { //THIS IS FOR SEARCHING CLIENTS UNDER STYLIST
       $stylist = Stylist::find($id);
       return $app['twig']->render('stylist.html.twig', ['stylist' => $stylist, 'clients' => $stylist->getClients()]);
   });

   $app->post('/stylists/{id}', function($id) use($app) {
       $stylist = Stylist::find($id);
       $client = Client::find($stylist->getClients());
       return $app['twig']->render('stylist.html.twig', ['stylist' => $stylist, 'clients' => $stylist->getClients()]);
   });

   $app->get('/stylists/{id}/edit', function($id) use($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', ['stylist' => $stylist]);
    });

    $app->patch('/stylists/{id}/edit', function($id) use ($app) {
        $name = $_POST['name'];
        $stylist = Stylist::find($id);
        $stylist->update($name);
        return $app->redirect('/');
    });

    $app->delete('/stylists/{id}', function($id) use($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app->redirect('/stylists');
    });

    $app->post('/add_client', function() use($app) {
       $name = $_POST['name'];
       $stylist_id = $_POST['stylist'];
       $new_client = new Client($name, $stylist_id);
       $new_client->save();
       return $app["twig"]->render("homepage.html.twig", ['stylists' => Stylist::getAll(), 'clients' => Client::getAll()]);
   });

    $app->get('/clients/{id}/edit', function($id) use ($app) {
        return $app['twig']->render('client_edit.html.twig', ['client' => Client::find($id), 'stylists' => Stylist::getAll()]);
    });

    $app->patch('/clients/{id}/edit', function($id) use($app) {
        $new_name = $_POST['name'];
        $client = Client::find($id);
        $client->update($new_name);
        return $app->redirect('/clients');
    });

    $app->delete('/clients/{id}', function($id) use($app) {
     $client = Client::find($id);
     $client->delete();
     return $app->redirect('/');
    });

    return $app;
?>
