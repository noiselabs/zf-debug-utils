# -*- coding: utf-8 -*-

import os
import sys

# If extensions (or modules to document with autodoc) are in another directory,
# add these directories to sys.path here. If the directory is relative to the
# documentation root, use os.path.abspath to make it absolute, like shown here.
sys.path.insert(0, os.path.abspath('..'))

from recommonmark.transform import AutoStructify
from recommonmark.parser import CommonMarkParser

source_parsers = {
    '.md': CommonMarkParser,
}

source_suffix = ['.rst', '.md']

# -- General configuration ------------------------------------------------

extensions = [
    'sphinx.ext.autodoc',
    'sphinx.ext.todo',
]

templates_path = ['_templates']

# The master toctree document.
master_doc = 'index'

# General information about the project.
project = u'Noiselabs ZfDebugModule'
copyright = u'2016, Vítor Brandão'
author = u'Vítor Brandão and contributors'
version = '0.2'
release = '0.2.0'

exclude_patterns = ['_build']
pygments_style = 'sphinx'
todo_include_todos = True
html_theme = 'sphinx_rtd_theme'
html_static_path = ['_static']
html_domain_indices = True
html_use_index = True
html_show_sphinx = True
html_show_copyright = True
html_file_suffix = None
html_search_language = 'en'
htmlhelp_basename = 'zf-debug-utils'

github_doc_root = 'https://github.com/noiselabs/zf-debug-utils/tree/master/docs'

def setup(app):
    app.add_config_value('recommonmark_config', {
            'url_resolver': lambda url: github_doc_root + url,
            'auto_toc_tree_section': 'Contents',
            'enable_auto_doc_ref': True,
            }, True)
    app.add_transform(AutoStructify)