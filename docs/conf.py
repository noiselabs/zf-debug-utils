# -*- coding: utf-8 -*-

import os
import sys

# If extensions (or modules to document with autodoc) are in another directory,
# add these directories to sys.path here. If the directory is relative to the
# documentation root, use os.path.abspath to make it absolute, like shown here.
sys.path.insert(0, os.path.abspath('..'))
import recommonmark
from recommonmark.transform import AutoStructify
from recommonmark.parser import CommonMarkParser

source_parsers = {
    '.md': CommonMarkParser,
}

source_suffix = ['.rst', '.md']

# -- General configuration ------------------------------------------------

extensions = [
    'sphinx.ext.autodoc',
]

templates_path = ['_templates']

# The master toctree document.
master_doc = 'index'

# General information about the project.
project = u'Noiselabs ZfDebugModule'
copyright = u'2016, Vítor Brandão and contributors'
author = u'Vítor Brandão and contributors'

exclude_patterns = ['_build']
pygments_style = 'sphinx'
html_theme = 'sphinx_rtd_theme'
html_static_path = ['_static']

github_doc_root = 'https://github.com/noiselabs/zf-debug-utils/tree/master/docs'

def setup(app):
    app.add_config_value('recommonmark_config', {
            'url_resolver': lambda url: github_doc_root + url,
            'auto_toc_tree_section': 'Contents',
            }, True)
    app.add_transform(AutoStructify)