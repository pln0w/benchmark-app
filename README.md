# Benchmark application
> Measure website loading time to compare with other websites and generate either CLI output or HTML file report.

## Table of Contents

* [About](###About)
* [Usage](###Usage)
* [Presentation](###Presentation)

## About
This repo contains console application in PHP, that can perform benchmark of given websites and comparing their response times can generate simple report.  
User can choose the type of output format (console log or HTML file ready to open in web browser). Each request result is dumped into _log.txt_ file.  
  
### Dependencies
The script uses no framework, however it depends on few components to provide functionality for infrastructure and application layers.  

Versions:
* PHP 7.3.1  
* Xdebug 2.7.0beta1  
* PHPUnit 7.5.2  
 
List of application dependencies:  
* symfony/console  
* symfony/dependency-injection  
* symfony/config  
* symfony/templating  
* symfony/event-dispatcher  
* league/tactician  
* guzzlehttp/guzzle

Development dependencies:  
* phpunit/phpunit  
* mockery/mockery  
* phpstan/phpstan  

## Usage
> See Makefile legend  

`make help`
  
  
> Build Docker image  

`make build`  
  
  
> Run application and perform benchmark for either yours or default website URLs  

`make benchmark`  
_This step produce _log.txt_ file or _index.html_ file, if you choose to dump your report into HTML file. In this case, you'll be informed to open this file in your browser. Keep in mind the file will be removed after running this command next time._  
    
    
> Run unit tests  

`make unit-tests`  
  
  
> Run phpstan static code analysis the highest level  

`make phpstan`
