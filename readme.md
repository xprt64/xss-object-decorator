# XSS Object Decorator

Use this library if you `echo` the results of a call to a method on an object

# Example of usage

## The code before

```php
    <?php
    /** @var SomeClass $someObject */
    echo $someObject->someMethod();
```

## The code after

```php
    <?php
    use \Gica\Xss\ObjectDecorator;
    
    /** @var SomeClass $someObject */
    $xssObject = new ObjectDecorator($someObject);
    
    echo $xssObject->someMethod();
    
```

If you want type-hinting in your IDE, you could add a @var declaration:

```php
    <?php
    use \Gica\Xss\ObjectDecorator;
    
    /** @var SomeClass $someObject */
    
    /** @var SomeClass $xssObject */
    $xssObject = new ObjectDecorator($someObject);
    
    echo $xssObject->someMethod();
    
```

If `$someObject` is passed from a controller to a view, you could replace `$someObject` with `new ObjectDecorator($someObject)` in that place and your view will not even know that
`$someObject` had been replaced with another one