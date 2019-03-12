Monofony Documentation
======================

This directory contains documentation for Monofony. 

This documentation is inspired by [Sylius documentation](http://docs.sylius.org). 

Build
-----

In order to build the documentation:
* [Install `pip`, Python package manager](https://pip.pypa.io/en/stable/installing/)

* Download the documentation requirements: 

    `$ pip install -r requirements.txt`
    
    This makes sure that the version of Sphinx you'll get is >=1.4.2!

* Install [Sphinx](http://www.sphinx-doc.org/en/stable/)

    `$ pip install Sphinx`

* In the `docs` directory run `$ sphinx-build -b html . build` and view the generated HTML files in the `build` directory.

* If you want to update the complete structure use `-a` build option in order to rebuild the entire documentation
