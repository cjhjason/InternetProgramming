<?php
class Model{
    public $text;
    public function __construct(){
        $this -> text = 'Hello World';
    }
}

class View
{
    private $model;
    private $controller;
    function __construct(Controller $controller, Model $model)
    {
        $this -> controller = $controller;
        $this -> model = $model;
    }

    public function output(){
        return '<a href = "HelloMVC_v2.php?action=textClicked">'.(this -> model -> text.'</a>');
    }
}

class Controller{
    private $model;
    public function __construct(Model $model){
        $this -> model = $model;
    }
    public function textClicked(){
        $this -> model -> text = 'text updated';
    }
}

if (!isset($model)){
    $model = new Model();
    $controller = new Controller($model);
    $view = new View($controller, $model);
}
if (isset($_GET['action']))
    // {$_GET['action']} = textClicked
    $controller -> {$_GET['action']}();
echo $view -> output();

 ?>

 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title></title>
     </head>
     <body>
         <a href="HelloMVC_v2.php?action=textClicked">Hello world!</a>
     </body>
 </html>
