# Purpose:: A PHP Template Engine With Cache Support

# Installation
   To install the package use composer. Your computer must have a composer install. Enter the following command to require the package. 
   * composer require purpose/template-engine

# Packaging Guide
You are able to use these package in your project. First define a class in which you are determined to use the package. Then extend the Template Engine Base Class. You have to override the base path property on which the template engine look for file to compile.
```
use TemplateEngine\PurposeTemplateEngine;
use TemplateEngine\Exceptions\PurposeTemplateException;

class Template extends PurposeTemplateEngine
{
    protected $path = __DIR__."\\view\\";
}
```
Make a instance of your defined class. To use the template engine view, the view file must be in filename.ps.php format. So every view file must be with .ps.php extension. You have a base method by which you going to process the view request. If you want to catch any exception thrown by the template engine, then make a instance inside a try block and you are able to catch any exception thrown by compiler. It will prevent you unexpected shutdown of your view process. Pass the data in a array, you want to use in your view. The array index name is your desired name to refer a data.
```
try {
    $template = new Template();
    $title = "Purpose";
    $user = [1, 2, 3, 4, 5, 6];
    $template->view("home", ["title" => $title, "usr" => $usr, "user" => $user]);
} catch (PurposeTemplateException $exception) {
    print $exception->getExceptionDetails();
}
```
     
# Reference

## Defining A Template
Define a template to extend the view.
```
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>{{ $title  }}</title>
</head>
<body>
   #capture('header')
   #capture('content')
   #capture('footer')
</body>
</html>
```
## Use of a Template
To use the template, define template source which you want to use in a view.
```
#template('template.default')
#attach('header')
  <div class="col-sm-3 sidenav">
        <h4>John's Blog</h4>
      </div>
#stop

#attach('content')
  <div class="col-sm-9">
        <h4><small>RECENT POSTS</small></h4>
   </div>
#stop

#attach('footer')
  <footer class="container-fluid">
        <p>Footer Text</p>
  </footer>
#stop
```
## Include a file
To include use the general syntax of view.
```
#include('web.navbar')
```
## Display Data
To display data use double curly braces to view the data. You can use any php built in function inside it. You can use any php code likely inside php general syntax. I support auto echo.
```
    {{ $title }}
```
### if control statement
```
#if($user1)
   {{ $user1 }}    
#elseif($user2)
     {{ $user2 }}    
#endif
```
### for loop control statement
```
#for($i = 0; $i < 100; $i++)
        {{ $i }}
    #endfor
```
### foreach loop loop control statement
```
#foreach($user as $name)
   {{ $name }}
#endforeach
```