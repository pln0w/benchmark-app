# Benchmark application
> Measure website loading time to compare with other websites and generate either CLI output or HTML file report.

## Table of Contents

* [About](###About)
* [Stack](###Stack)
* [Usage](###Usage)

## About
This repo contains console application in PHP, that can perform benchmark of given websites and based on their loading times comparision can generate simple report.  
User can choose the type of output format (console log or HTML file ready to open in web browser).   
Each single request result is dumped into _log.txt_ file.    
  
### Stack
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

Tests code coverage: ~ 40%  


## Usage
> See Makefile legend  

```sh
$ make help
```
  
  
> Build Docker image  

```sh
$ make build
```
  
  
> Run application and perform benchmark for either yours or default website URLs  

```sh
$ make benchmark
```
_This step produce _log.txt_ file or _index.html_ file, if you choose to dump your report into HTML file. In this case, you'll be informed to open this file in your browser. Keep in mind the file will be removed after running this command next time._  
    
    
> Run unit tests  

```sh
$ make unit-tests
```
  
  
> Run phpstan static code analysis the highest level  

```sh
$ make phpstan
```
