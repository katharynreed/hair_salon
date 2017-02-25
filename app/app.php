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

    $app->post('/add_stylist', function() use($app) {
       $name = $_POST['name'];
       $bio = $_POST['bio'];
       $new_stylist = new Stylist($name, $bio);
       $new_stylist->save();
       return $app["twig"]->render("homepage.html.twig", ['stylists' => Stylist::getAll()]);
   });

   $app->get('/stylists/{id}', function($id) use($app)  {
       $stylist = Stylist::find($id);
       return $app['twig']->render('stylist.html.twig', ['stylist' => $stylist, 'clients' => $stylist->getClients()]);
   });

    return $app;
?>
