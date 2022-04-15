SortableBehaviorBundle
=========================

Sonata admin sortable for symfony 4

### Configuration

By default, this extension works with Doctrine ORM, but you can choose to use Doctrine MongoDB by defining the driver configuration : 

``` yaml
# app/config/config.yml
sortable_behavior:
    db_driver: mongodb # default value : orm
    position_field:
        default: sort #default value : position
        entities:
            AppBundle\Entity\Foobar: order
            AppBundle\Entity\Baz: rang
    sortable_groups:
        entities:
            AppBundle\Entity\Baz: [ group ]
            
```

#### Use a draggable list instead of up/down buttons
In order to use a draggable list instead of up/down buttons, change the template in the ```move``` action to ```SortableBehaviorBundle:Default:_sort_drag_drop.html.twig```.

```php
<?php

    // ClientAdmin.php
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('enabled')
            ->add('_action', null, array(
                'actions' => array(
                    'move' => array(
                        'template' => 'AppBundle:Admin:_sort_drag_drop.html.twig',
                        'enable_top_bottom_buttons' => true, //optional
                    ),
                ),
            ))
        ;
    }
```    
Also include the JavaScript needed for this to work, in your ```theme.yml``` file, add these two lines:
```yml
    //...
    javascripts:
        - bundles/sortablebehavior/js/jquery-ui.min.js // if you haven't got jQuery UI yet.
        - bundles/sortablebehavior/js/init.js
```

Adding the JavaScript and the template, will give you the possibility to drag items in a tablelist.
In case you need it, this plugin fires to jQuery events when dragging is done on the ```$(document)``` element, so if you want to add custom notification, that is possible. Also, when dragging the ```<body>``` gets an ```is-dragging``` class. This class is removed when you stop dragging. This could by quite handy if you have some custom js/css.
```
SortableBehaviorBundle.success
SortableBehaviorBundle.error
```
#### Disable top and bottom buttons
```php
<?php

    // ClientAdmin.php
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('enabled')
            ->add('_action', null, array(
                'actions' => array(
                    'move' => array(
                        'template' => 'SortableBehaviorBundle:Default:_sort_drag_drop.html.twig',
                        'enable_top_bottom_buttons' => true,
                    ),
                ),
            ))
        ;
    }
```    
