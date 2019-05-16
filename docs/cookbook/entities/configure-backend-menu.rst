How to configure backend menu
=============================

To configure backend menu for your entity, you have to edit `src/Menu/AdminMenuBuilder.php`.

.. code-block:: php

    // src/Menu/AdminMenuBuilder.php

    public function createMenu(RequestStack $requestStack)
    {
        // add method ...
        $this->addContentSubMenu($menu);
        // rest of the code

        return $menu;
    }

    /**
     * @param ItemInterface $menu
     *
     * @return ItemInterface
     */
    private function addContentSubMenu(ItemInterface $menu)
    {
        $customer = $menu
            ->addChild('content')
            ->setLabel('sylius.ui.content')
        ;
        $customer->addChild('backend_article', ['route' => 'app_backend_article_index'])
            ->setLabel('app.ui.articles')
            ->setLabelAttribute('icon', 'newspaper');
        return $customer;
    }

