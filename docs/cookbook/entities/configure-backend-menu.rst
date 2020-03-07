How to configure backend menu
=============================

To configure backend menu for your entity, you have to edit `src/Menu/AdminMenuBuilder.php`.

.. code-block:: php

    // src/Menu/AdminMenuBuilder.php

    public function createMenu(array $options): ItemInterface
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
    private function addContentSubMenu(ItemInterface $menu): ItemInterface
    {
        $content = $menu
            ->addChild('content')
            ->setLabel('sylius.ui.content')
        ;

        $content->addChild('backend_article', ['route' => 'app_backend_article_index'])
            ->setLabel('app.ui.articles')
            ->setLabelAttribute('icon', 'newspaper');

        return $content;
    }

